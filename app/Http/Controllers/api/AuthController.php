<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{

    public function register(AuthRegisterRequest $request) {
        $c = $request->validated();

        $user = User::create($c);

        Auth::setUser($user);

        $token = $user->createToken('auth_token', ['*'], env('AUTH_COOKIE_TLL'))->plainTextToken;
        
        $a_c = $this->get_auth_cookie($token);

        return response()->json([
            'token' => $token,
            'login'=> Auth::user()->login,
            'ttl' => env('AUTH_COOKIE_TTL') * 24 * 60 * 60,   // returns in seconds
        ])->cookie($a_c);
    }


    public function login(AuthLoginRequest $request)
    {
        $c = $request->validated();

        if(Auth::attempt($c)) {
            
            $user = User::where('login', $c['login'])->first();

            $token = $user->createToken('auth_token', ['*'], env('AUTH_COOKIE_TLL'))->plainTextToken;

            $a_c = $this->get_auth_cookie($token);

            return response()->json([
                'token' => $token,
                'login'=> Auth::user()->login,
                'ttl' => env('AUTH_COOKIE_TTL') * 24 * 60 * 60,   // returns in seconds
            ])->cookie($a_c);
        }

        return response()->json([
            'message' => 'Incorrect email or password.',
        ], 403);
    }


    public function logout(Request $request) {
        
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Successful logout.',
        ])->withoutCookie(env('AUTH_COOKIE_NAME'));
    }


    private function get_auth_cookie($token) {
        return cookie(
            env('AUTH_COOKIE_NAME'),
            $token,
            env('AUTH_COOKIE_TTL') * 24 * 60,
            null,
            null,
            env('APP_DEBUG') ? false : true,
            true,
            false,
            'Strict',
        );
    }
    
}
