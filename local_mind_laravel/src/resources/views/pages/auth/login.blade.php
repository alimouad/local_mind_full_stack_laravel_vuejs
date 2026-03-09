@extends('layouts.authLayout')

@section('title', 'Welcome Back')

@section('content')
<div class="w-full max-w-md mx-auto">
    <div class="text-center mb-8">
        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Welcome back</h2>
        <p class="text-sm text-gray-500 mt-2">Please enter your details to sign in.</p>
    </div>

    <form method="POST" action="{{ route('login.process') }}" class="space-y-6">
        @csrf

        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700">Email Address</label>
            <div class="mt-1 relative">
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    placeholder="name@company.com"
                    class="block w-full px-4 py-3 rounded-xl border-gray-200 shadow-sm focus:ring-2 focus:ring-primary focus:border-primary border transition-all duration-200 outline-none @error('email') border-red-500 @enderror"
                >
            </div>
            @error('email')
                <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <div class="flex items-center justify-between">
                <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
                <a href="#" class="text-xs font-semibold text-primary hover:text-primary">Forgot password?</a>
            </div>
            <div class="mt-1 relative">
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    placeholder="••••••••"
                    class="block w-full px-4 py-3 rounded-xl border-gray-200 shadow-sm focus:ring-2 focus:ring-primary focus:border-primary border transition-all duration-200 outline-none @error('password') border-red-500 @enderror"
                >
            </div>
            @error('password')
                <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center">
            <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded cursor-pointer">
            <label for="remember_me" class="ml-2 block text-sm text-gray-600 cursor-pointer">Remember me</label>
        </div>

        @error('credentials')
            <div class="p-3 rounded-lg bg-red-50 border border-red-100">
                <p class="text-sm text-red-600 text-center font-medium">{{ $message }}</p>
            </div>
        @enderror

        <button
            type="submit"
            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-primary hover:bg-primary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all duration-150 active:scale-[0.98] shadow-lg shadow-indigo-200"
        >
            Sign in
        </button>

        <p class="text-center text-sm text-gray-500 pt-4">
            New here? 
            <a href="{{ route('register') }}" class="font-bold text-primary hover:text-primary transition-colors">
                Create an account
            </a>
        </p>
    </form>
</div>
@endsection