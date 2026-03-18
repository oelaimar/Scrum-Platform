<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Invitation;
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
    public function showRegister(Request $request)
    {
        $token = $request->query('token');
        $email = $request->query('email');

        if($token && $email){
            $invitation = Invitation::where('token', $token)
                ->where('email', $email)
                ->where('is_used', false)
                ->first();
            if(!$invitation){
                return redirect()->route('register')->with('error', 'this invitation link is invalid or has already been used');
            }
        }
        return view('auth.register', compact('token', 'email'));
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
    public function register(RegisterRequest $request)
    {
        $token = $request->input('token');
        $invitation = null;

        if($token){
            $invitation = Invitation::where('token', $token)
                ->where('email', $request->email)
                ->where('is_used', false)
                ->first();
            if(!$invitation){
                return back()->withErrors(['email' => 'your invitation token is invalid.']);
            }
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => UserRole::STUDENT,
            'status' => $invitation? UserStatus::ACTIVE : UserStatus::PENDING,
        ]);
        if($invitation){
            $user->projects()->attach($invitation->project_id);
            $invitation->update(['is_used' => true]);

            Auth::login($user);

            return redirect()->route('dashboard')->with('success', 'Welcome! You have joined the project.');
        }

        return redirect()->route('login')->with('success', 'Registration successful! Wait for teacher approval.');
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
