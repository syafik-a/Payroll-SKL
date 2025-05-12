<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KaryawanMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->isKaryawan()) {
            return $next($request);
        }
        
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Unauthorized action. Karyawan access required.'], 403);
        }
        
        abort(403, 'Unauthorized action.');
    }
}