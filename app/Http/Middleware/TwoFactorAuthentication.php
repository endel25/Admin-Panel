<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwoFactorAuthentication
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->two_factor_code && now()->lt(Auth::user()->two_factor_expires_at)) {
            return redirect()->route('auth.two-factor');
        }
        return $next($request);
    }
}
