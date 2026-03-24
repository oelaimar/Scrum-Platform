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
    public function showRegister(Request $request, ?string $token = null)
    {
        if ($token && !$request->hasValidSignature()) {
            return redirect()->route('register')->with('error', 'The invitation link has expired or is invalid.');
        }
        $token = $token ?? $request->query('token');
        $email = $request->query('email');

        if($token && $email){
            $invitation = Invitation::where('token', $token)
                ->where('email', $email)
                ->where('is_used', false)
                ->where('expires_at', '>', now())
                ->first();
            if(!$invitation){
                return redirect()->route('register')->with('error', 'this invitation link is invalid or has already been used');
            }

            // If user exists, redirect to login with info
            if (User::where('email', $email)->exists()) {
                if (Auth::check() && Auth::user()->email === $email) {
                    Auth::user()->projects()->syncWithoutDetaching([$invitation->project_id]);
                    $invitation->update(['is_used' => true]);
                    return redirect()->route('dashboard')->with('success', 'You have successfully joined the project!');
                }
                return redirect()->route('login', ['token' => $token, 'email' => $email])
                    ->with('info', 'You already have an account. Please login to join the project.');
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

            // Handle invitation attachment after login
            if ($request->has('token') && $request->has('email') && Auth::user()->email === $request->email) {
                $invitation = Invitation::where('token', $request->token)
                    ->where('email', $request->email)
                    ->where('is_used', false)
                    ->where('expires_at', '>', now())
                    ->first();
                if ($invitation) {
                    Auth::user()->projects()->syncWithoutDetaching([$invitation->project_id]);
                    $invitation->update(['is_used' => true]);
                    return redirect()->route('dashboard')->with('success', 'Welcome! You have joined the project.');
                }
            }

            return redirect()->intended(route('dashboard'));
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
                ->where('expires_at', '>', now())
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
            'status' => $invitation ? UserStatus::ACTIVE : UserStatus::PENDING,
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
