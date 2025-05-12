<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (request()->expectsJson()) {
            return response()->json(['message' => 'Please login']);
        }
        
        return view('auth.login'); // Return view untuk web
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            if ($request->expectsJson()) {
                $user = Auth::user();
                $token = $user->createToken('auth-token')->plainTextToken; // Untuk API
                
                return response()->json([
                    'message' => 'Login successful',
                    'user' => $user,
                    'token' => $token,
                    'redirect_to' => $user->isAdmin() ? '/admin/dashboard' : '/karyawan/dashboard'
                ]);
            }
            
            $request->session()->regenerate();
            $user = Auth::user();
            
            if ($user->isAdmin()) {
                return redirect()->intended('/admin/dashboard');
            } elseif ($user->isKaryawan()) {
                return redirect()->intended('/karyawan/dashboard');
            }
        }

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'The provided credentials do not match our records.'
            ], 401);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        if ($request->expectsJson()) {
            $request->user()->currentAccessToken()->delete();
            
            return response()->json(['message' => 'Logged out successfully']);
        }
        
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}