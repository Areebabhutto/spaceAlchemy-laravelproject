<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validate credentials
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Attempt login
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $user = Auth::user();

        // Create Passport token
        $token = $user->createToken('API Token')->accessToken;

        return response()->json([
            'token' => $token,
            'user' => $user
        ]);
    }

    // Optional: Logout
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete(); // revoke all tokens
        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
}
