<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PhoneUserAuth
{
    public function handle(Request $request, Closure $next)
    {
        // ✅ If the phone user is NOT logged in, redirect to register page
        if (!Auth::guard('phoneUser')->check()) {
            return redirect('/register-user')->with('error', 'براہ کرم پہلے لاگ ان کریں۔');
        }

        return $next($request);
    }
}


