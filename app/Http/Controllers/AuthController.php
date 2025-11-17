<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request) {
        $c = $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        if(Auth::attempt($c)) {
            $request->session()->regenerate();

            return response()->json([
                'message' => 'Successful login.',
            ]);
        }

        return response()->json([
            'message' => 'Incorrect login or password.',
        ], 403);
    }
}
