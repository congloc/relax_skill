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
        $this->middleware('auth:api', ['except' => ['login','register','verify_email, postReset']]);
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
                'status' => 422,
                'message' => $validator->errors()->first()
            ], 200);
        }

        $user = User::where('username', $request->username)->first();
        if (is_null($user)) {
            return response()->json([
                'status' => 422,
                'message' => 'Email or Password is not valid.',
            ], 200);
        }

        if (!$user->status) {
            return response()->json([
                'status' => 422,
                'message' => 'Your account is not verified email.',
            ], 200);
        }

        if ($user->status == 2) {
            return response()->json([
                'status' => 422,
                'message' => 'Your account has been banned.',
            ], 200);
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
                    'status' => 422,
                    'message' => 'Email or Password is not valid.'
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => 'failed_to_create_token'
            ], 200);
        }

        if (!$protectKey) {
            if ($request->has('twofa_code') && $request->twofa_code != '') {
                $twofa = new Twofa();
                $valid = $twofa->verifyCode($user->google2fa_secret, $request->twofa_code);
                if (!$valid) {
                    return response()->json([
                        'status' => 422,
                        'message' => 'The two factor authentication code is invalid',
                    ]);
                }
            } else {
                if ($user->google2fa_enable) {
                    return response()->json([
                        'status' => 401,
                        'message' => '2FA Authorization'
                    ]);
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
                'status' => 422,
                'message' => $validator->errors()->first()
            ], 200);
        }
        
        if($request->type == '0' && !$request->has('ref')) {
            return response()->json([
                'status' => 422,
                'message' => 'Ref field can require'
            ], 200);
        }

        $sponsor_id = 0;
        if ($request->has('ref_id') && $request->ref_id != '') {
            $sponsor = DB::table('users')->where('ref_id', $request->ref_id)->first();
            if (is_null($sponsor)) {
                return response()->json([
                    'status' => 422,
                    'message' => 'The sponsor id does not exist.',
                ], 200);
            }
            $sponsor_id = $sponsor->id;
        }

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
            'google2fa_secret' => $twofa->createSecret()
        ]);

        $code = encrypt($request->email);
        Mail::to($request->email)->queue(new VerifyEmail($user,$code));
        
        return response()->json([
            'status' => 200,
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
                'status' => 422,
                'message' => 'The activation link does not exist or has expired.',
            ], 200);
        }

        $user = DB::table('users')->where('email', $email)->where('status', 0)->first();
        if (is_null($user)) {
            return response()->json([
                'status' => 422,
                'message' => 'The activation link does not exist or has expired.',
            ], 200);
        }

        DB::table('users')->where('email', $email)->update([
            'status' => 1,
            'email_verified_at' => date(now())
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Your account has been actived successfully.',
        ], 200);
    }
}
