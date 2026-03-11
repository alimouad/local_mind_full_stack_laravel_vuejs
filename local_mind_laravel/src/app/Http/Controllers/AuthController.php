<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = Auth::user();
        $token = Str::random(60);
        $user->api_token = $token;
        $user->save();

        return response()->json([
            'user' => $user->only('id', 'name', 'email', 'role'),
        ])->cookie('api_token', $token, 60 * 24 * 7, '/', null, false, true);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|string|email|max:255|unique:users',
            'password'              => 'required|string|min:8|confirmed',
        ]);

        $token = Str::random(60);

        $user = User::create([
            'name'      => $validated['name'],
            'email'     => $validated['email'],
            'password'  => bcrypt($validated['password']),
            'api_token' => $token,
        ]);

        return response()->json([
            'user' => $user->only('id', 'name', 'email', 'role'),
        ], 201)->cookie('api_token', $token, 60 * 24 * 7, '/', null, false, true);
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        if ($user) {
            $user->update(['api_token' => null]);
        }

        return response()->json(['message' => 'Logged out successfully'])
            ->cookie('api_token', '', -1, '/', null, false, true);
    }
}

