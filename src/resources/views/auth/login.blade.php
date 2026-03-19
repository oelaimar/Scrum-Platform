@extends('layouts.auth')
@section('auth-title', 'Login')

@section('content')
<form method="POST" action="{{ route('login.store') }}" class="space-y-6">
    @csrf
    <div>
        <label for="email" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5 ml-1">Email Address</label>
        <div class="relative">
            <input type="email" name="email" id="email" required value="{{ old('email') }}" autofocus
                   class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-5 py-3.5 text-sm font-medium text-gray-900 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none"
                   placeholder="name@example.com">
        </div>
        @error('email') <p class="text-xs text-red-500 mt-1.5 ml-1 font-medium">{{ $message }}</p> @enderror
    </div>

    <div>
        <div class="flex items-center justify-between mb-1.5 ml-1">
            <label for="password" class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Password</label>
            <a href="#" class="text-[10px] font-bold text-indigo-500 uppercase tracking-widest hover:text-indigo-600 transition-colors">Forgot?</a>
        </div>
        <input type="password" name="password" id="password" required
               class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-5 py-3.5 text-sm font-medium text-gray-900 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none"
               placeholder="••••••••">
    </div>

    <div class="flex items-center gap-2 px-1">
        <input type="checkbox" name="remember" id="remember" class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
        <label for="remember" class="text-xs font-bold text-gray-500 uppercase tracking-widest">Remember Me</label>
    </div>

    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black py-4 rounded-2xl shadow-xl shadow-indigo-100 transition-all active:scale-[0.98] uppercase tracking-widest text-xs">
        Sign In
    </button>
</form>

<div class="text-center mt-8">
    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">New here? <a href="{{ route('register') }}" class="text-indigo-500 hover:text-indigo-600 transition-colors">Create Account</a></p>
</div>
@endsection
