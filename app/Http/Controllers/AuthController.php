<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Container\Attributes\Auth;
// use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login() {
        // dd(Hash::make(123456));
        if(!empty(Auth::check()))
        {
            return view('panel.dashboard');
        }
        return view('auth.login');
    }

    public function auth_login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('panel/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->only('email');
    }

    public function logout()
    {
        Auth::logout();
        return redirect(url(''));
    }
}
