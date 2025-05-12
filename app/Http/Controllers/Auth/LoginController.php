<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        // return view('auth.login'); // Tampilkan form login
        return response()->json(['message' => 'Please login (form view not implemented yet)']);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            if ($user->isAdmin()) {
                // return redirect()->intended('/admin/dashboard');
                return response()->json(['message' => 'Admin Logged In', 'user' => $user, 'redirect_to' => '/admin/dashboard']);
            } elseif ($user->isKaryawan()) {
                // return redirect()->intended('/karyawan/dashboard');
                return response()->json(['message' => 'Karyawan Logged In', 'user' => $user, 'redirect_to' => '/karyawan/dashboard']);
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        // return redirect('/');
        return response()->json(['message' => 'Logged out']);
    }
}