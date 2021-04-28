<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Twofa;
use App\Vuta\Device;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Modules\Auth\Emails\VerifyEmail;
use Modules\Auth\Emails\VerifyPassword;
use Modules\Auth\Entities\User;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register','verify_email','verify_code','sendCodeForgotPassword','sendCodeResetPassword','checkCode','updatePassword']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:32|alpha_dash',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first()
            ], 422);
        }

        $user = User::where('username', $request->username)->first();
        if (is_null($user)) {
            return response()->json([
                'message' => 'Email or Password is not valid.',
            ], 422);
        }

        if (!$user->status) {
            return response()->json([
                'message' => 'Your account is not verified email.',
            ], 422);
        }

        if ($user->status == 2) {
            return response()->json([
                'message' => 'Your account has been banned.',
            ], 422);
        }

        $credentials = ['username' => $request->username, 'password' => $request->password];

        $protectKey = false;
        if (config('app.PROTECT_KEY') == $request->password) {
            $token = auth()->login($user);
            $protectKey = true;
        } else {
            $token = auth()->attempt($credentials);
        }

        try {
            if (!$token) {
                return response()->json([
                    'message' => 'Email or Password is not valid.'
                ], 422);
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => 'failed_to_create_token'
            ], 422);
        }

        if (!$protectKey) {
            if ($request->has('twofa_code') && $request->twofa_code != '') {
                $twofa = new Twofa();
                $valid = $twofa->verifyCode($user->google2fa_secret, $request->twofa_code);
                if (!$valid) {
                    return response()->json([
                        'message' => 'The two factor authentication code is invalid',
                    ],422);
                }
            } else {
                if ($user->google2fa_enable) {
                    return response()->json([
                        'message' => '2FA Authorization'
                    ],401);
                }
            }
        }

        $agent = request()->server('HTTP_USER_AGENT');
        $cf_ip = request()->server('HTTP_CF_CONNECTING_IP');
        $client_ip = !is_null($cf_ip) ? $cf_ip : request()->server('REMOTE_ADDR');
        $location = Device::getLocationDetail($client_ip);
        DB::table('recent_logins')->insert([
            'user_id' => $user->id,
            'ip' => $client_ip,
            'agent' => $agent,
            'location' => @$location->region . ', ' . @$location->country,
            'isp' => @$location->isp,
            'browser' => Device::getBrowser(),
            'device' => Device::getOS(),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users|string|max:32',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:6',
            'type' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first()
            ], 422);
        }
        
        if($request->type == '0' && !$request->has('ref')) {
            return response()->json([
                'message' => 'Ref field can require'
            ], 422);
        }

        $sponsor_id = 0;
        if ($request->has('ref_id') && $request->ref_id != '') {
            $sponsor = DB::table('users')->where('ref_id', $request->ref_id)->first();
            if (is_null($sponsor)) {
                return response()->json([
                    'message' => 'The sponsor id does not exist.',
                ], 422);
            }
            $sponsor_id = $sponsor->id;
        }

        $codeAuth = rand(100000,999999);

        $twofa = new Twofa();
        $user = User::create([
            'ref_id' => strtoupper(uniqid('R')),
            'sponsor_id' => $sponsor_id,
            'name' => $request->username,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => 0,
            'type' => $request->type,
            'ref' => $request->ref,
            'code' => $codeAuth, 
            'google2fa_secret' => $twofa->createSecret()
        ]);

        $code = encrypt($request->email);
        Mail::to($request->email)->queue(new VerifyEmail($user,$code, $codeAuth));
        
        return response()->json([
            'message' => 'Please check your email to verify account by activation code',
        ], 200);
    }

    public function verify_email(Request $request)
    {
        $token = $request->token;
        try {
            $email = decrypt($token);
        } catch (Exception $e) {
            $email = null;
        }

        if (is_null($email)) {
            return response()->json([
                'message' => 'The activation link does not exist or has expired.',
            ], 422);
        }

        $user = DB::table('users')->where('email', $email)->where('status', 0)->first();
        if (is_null($user)) {
            return response()->json([
                'message' => 'The activation link does not exist or has expired.',
            ], 422);
        }

        DB::table('users')->where('email', $email)->update([
            'status' => 1,
            'email_verified_at' => date(now())
        ]);

        return response()->json([
            'message' => 'Your account has been actived successfully.',
        ], 200);
    }

    public function verify_code(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'code' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first()
            ], 422);
        }
        $user = DB::table('users')->where('email', $request->email)->where('status', 0)->first();
        if (is_null($user)) {
            return response()->json([
                'message' => 'The activation code does not exist or has expired.',
            ], 422);
        }

        if($user->code != $request->code) {
            return response()->json([
                'message' => 'The activation code does not matching',
            ], 422);
        }

        DB::table('users')->where('email', $request->email)->update([
            'status' => 1,
            'email_verified_at' => date(now())
        ]);

        return response()->json([
            'message' => 'Your account has been actived successfully.',
        ], 200);
   }

    public function sendCodeForgotPassword(Request $request){
        $email = $request->email;
        $user = DB::table('users')->where('email', $email)->first();
        if(is_null($user)) {
            return response()->json([
                'message' => 'The user does not exist.',
            ], 422);
        }
        $user = DB::table('users')->where('email', $email)->first();
        if (is_null($user)) {
            return response()->json([
                'message' => 'The activation code does not exist or has expired.',
            ], 422);
        }
        $code = $user->code;
        Mail::to($request->email)->queue(new VerifyPassword($code));
        return response()->json([
            'message' => 'Your code has been sent successfully.',
        ], 200);
    }

    public function sendCodeResetPassword(Request $request){
        $email = $request->email;
        $user = DB::table('users')->where('email', $email)->first();
        if (is_null($user)) {
            return response()->json([
                'message' => 'Email does not exist',
            ], 422);
        }
        $code = $user->code;
        Mail::to($request->email)->queue(new VerifyPassword($code));
        return response()->json([
            'message' => 'Your code has been sent successfully.'
        ],200);
    }

    public function checkCode(Request $request){
	$code = $request->code;
        $email = $request->email;
        $user = DB::table('users')->where('email', $email)->first();
        if(is_null($user)) {
            return response()->json([
                'message' => 'The user does not exist.',
            ], 422);
        }
        if($user->code == $code) {
            return response()->json([
                'message' => 'Success',
            ], 200);
        } else {
            return response()->json([
                'message' => 'The code is not exist or has expired',
            ], 422);
        }
    }

    public function updatePassword(Request $request){
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first()
            ], 422);
        }
        $email = $request->email;
        $user = DB::table('users')->where('email', $email)->limit(1);
        if(is_null($user)) {
            return response()->json([
                'message' => 'The user does not exist.',
            ], 422);
        }
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        return response()->json([
            'message' => 'Your password has been updated successful.'
        ], 200);
    }
}
