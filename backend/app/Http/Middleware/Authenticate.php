<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // For API/JSON requests we do not want to redirect to a login route.
        // Returning null tells Laravel to send a 401 JSON response instead.
        if ($request->expectsJson() || $request->is('api/*')) {
            return null;
        }

        return route('admin.login');
    }
}