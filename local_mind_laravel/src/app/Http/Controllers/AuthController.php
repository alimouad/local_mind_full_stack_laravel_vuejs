<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login()
    {
        return view('pages.auth.login');
    }

    public function register()
    {
        return view('pages.auth.register');
    }

    public function processLogin(Request $request)
    {
        // Process login data here
        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        $user = $request->only('email', 'password');

        if (Auth::attempt($user)) {
            $request->session()->regenerate();
            return match (auth()->user()->role) {
                'ADMIN' => redirect()->intended(route('admin.home')),
                'USER' => redirect()->intended(route('home')), // Specific student route
                default => redirect()->intended(route('home')),
            };
        }
        throw ValidationException::withMessages([
            'credentials' => 'Sorry, incorrect credentials',
        ]);
    }
    public function processRegister(Request $request)
    {
        // Process registration data here
        $credentials = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $user = User::create([
            'name' => $credentials['name'],
            'email' => $credentials['email'],
            'password' => bcrypt($credentials['password']),
        ]);

        Auth::login($user);
        return redirect()->route('login')->with('success', 'the account created successfully');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
        // Process logout here
    }
}
