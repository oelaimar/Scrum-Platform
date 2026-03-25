@extends('layouts.auth')
@section('auth-title', 'Register')

@section('content')
@php
    $inviteToken = request()->query('token');
@endphp

<div class="mb-6">
    {{-- Invitation logic removed --}}
</div>

<form method="POST" action="{{ route('register.store') }}" class="space-y-5">
    @csrf
    @if($inviteToken)
        <input type="hidden" name="token" value="{{ $inviteToken }}">
    @endif

    <div>
        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5 ml-1">Full Name</label>
        <input type="text" name="name" required value="{{ old('name') }}"
               class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-5 py-3 text-sm font-medium text-gray-900 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none"
               placeholder="John Doe">
        @error('name') <p class="text-xs text-red-500 mt-1.5 ml-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5 ml-1">Email Address</label>
        <input type="email" name="email" required value="{{ old('email') }}"
               class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-5 py-3 text-sm font-medium text-gray-900 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none"
               placeholder="name@example.com">
        @error('email') <p class="text-xs text-red-500 mt-1.5 ml-1">{{ $message }}</p> @enderror
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5 ml-1">Password</label>
            <input type="password" name="password" required
                   class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-5 py-3 text-sm font-medium text-gray-900 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none"
                   placeholder="••••••••">
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5 ml-1">Confirm</label>
            <input type="password" name="password_confirmation" required
                   class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-5 py-3 text-sm font-medium text-gray-900 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none"
                   placeholder="••••••••">
        </div>
    </div>
    @error('password') <p class="text-xs text-red-500 ml-1">{{ $message }}</p> @enderror

    <div class="pt-2">
        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black py-4 rounded-2xl shadow-xl shadow-indigo-100 transition-all active:scale-[0.98] uppercase tracking-widest text-xs">
            Create Account
        </button>
    </div>
</form>

<div class="text-center mt-8">
    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Already a member? <a href="{{ route('login') }}" class="text-indigo-500 hover:text-indigo-600 transition-colors">Sign In</a></p>
</div>
@endsection
