<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo(Request $request)
    {
        // If request expects JSON (like API), just return null
        if ($request->expectsJson()) {
            return null;
        }

        // Multi-auth redirect based on URL patterns
        if ($request->is('customer/*')) {
            // Redirect to customer login
            return route('customer.login');
        }

        // You can add more guards here if needed
        // Example: if ($request->is('admin/*')) { return route('admin.login'); }

        // Default fallback (web/login)
        return route('login');
    }
}
