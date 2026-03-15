<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }
    public function showRegister()
    {
        return view('auth.register');
    }
    public function login(LoginRequest $request)
    {
        if(Auth::attempt($request->only('email', 'password'), $request->remember)){
            $request->session()->regenerate();
            if(Auth::user()->status !== UserStatus::ACTIVE) {
                Auth::logout();
                return back()->withErrors(['email' => 'your account is pending teacher approval']);
            }
            return redirect()->intended('dashboard');
        }
        return back()->withErrors(['email' => 'The provided credentials do not match our records.']);
    }
    public function register(RegisterRequest$request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => UserRole::STUDENT,
            'status' => UserStatus::PENDING,
        ]);
        return redirect()->route('login')->with('success', 'Registration successful! Wait for teacher approval.');
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
