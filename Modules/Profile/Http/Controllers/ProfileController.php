<?php

namespace Modules\Profile\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Auth;

class ProfileController extends Controller
{
    /**
     * Create a new ProfileController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
    }    

    public function getProfile(Request $request) {
        $user = Auth::user();
        if (is_null($user)) {
            return response()->json([
                'message' => 'Email or Password is not valid.',
            ], 422);
        }
        return response()->json([
            'message' => 'Get data is success.',
            'data' => $user
        ], 200);
    }

}
