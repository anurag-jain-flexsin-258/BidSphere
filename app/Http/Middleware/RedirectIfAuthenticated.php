<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * Redirect authenticated users away from login/OTP pages.
     */
    public function handle(Request $request, Closure $next, string $guard = null)
    {
        if ($guard && Auth::guard($guard)->check()) {
            if ($guard === 'customer') {
                return redirect()->route('customer.dashboard');
            }
            return redirect('/home'); // fallback for other guards
        }

        return $next($request);
    }
}
