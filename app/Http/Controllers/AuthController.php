<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Show the login portal.
     */
    public function showLogin()
    {
        // If already authenticated, redirect straight to the POS
        if (Auth::check()) {
            return redirect()->route('service-desk');
        }

        return view('auth.login');
    }

    /**
     * Authenticate the staff member.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->intended(route('service-desk'));
        }

        return back()->withErrors([
            'email' => 'Invalid credentials. Access denied.',
        ])->onlyInput('email');
    }

    /**
     * Destroy the authenticated session.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
