@extends('layouts.authLayout')

@section('title', 'Create Account')

@section('content')
<div class="w-full max-w-md mx-auto">
    <div class="text-center mb-8">
        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Join us</h2>
        <p class="text-sm text-gray-500 mt-2">Create your account to get started.</p>
    </div>

    <form method="POST" action="{{ route('register.process') }}" class="space-y-5" novalidate>
        @csrf

        <div>
            <label for="name" class="block text-sm font-semibold text-gray-700">Full Name</label>
            <div class="mt-1">
                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    autofocus
                    placeholder="John Doe"
                    class="block w-full px-4 py-3 rounded-xl border-gray-200 shadow-sm focus:ring-2 focus:ring-primary focus:border-primary border transition-all duration-200 outline-none @error('name') border-red-500 @enderror"
                >
            </div>
            @error('name')
                <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700">Email Address</label>
            <div class="mt-1">
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    placeholder="name@company.com"
                    class="block w-full px-4 py-3 rounded-xl border-gray-200 shadow-sm focus:ring-2 focus:ring-primary focus:border-primary border transition-all duration-200 outline-none @error('email') border-red-500 @enderror"
                >
            </div>
            @error('email')
                <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
                <div class="mt-1">
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        placeholder="••••••••"
                        class="block w-full px-4 py-3 rounded-xl border-gray-200 shadow-sm focus:ring-2 focus:ring-primary focus:border-primary border transition-all duration-200 outline-none @error('password') border-red-500 @enderror"
                    >
                </div>
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700">Confirm</label>
                <div class="mt-1">
                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        required
                        placeholder="••••••••"
                        class="block w-full px-4 py-3 rounded-xl border-gray-200 shadow-sm focus:ring-2 focus:ring-primary focus:border-primary border transition-all duration-200 outline-none"
                    >
                </div>
            </div>
        </div>
        
        @error('password')
            <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
        @enderror

        <div class="pt-2">
            <button
                type="submit"
                class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-primary hover:bg-primary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all duration-150 active:scale-[0.98] shadow-lg shadow-indigo-200"
            >
                Create account
            </button>
        </div>

        <p class="text-center text-sm text-gray-500 pt-4">
            Already have an account? 
            <a href="{{ route('login') }}" class="font-bold text-primary hover:text-primary transition-colors">
                Sign in
            </a>
        </p>
    </form>
</div>
@endsection