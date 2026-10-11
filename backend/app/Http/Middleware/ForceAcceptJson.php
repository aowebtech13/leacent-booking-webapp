<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceAcceptJson
{
    public function handle(Request $request, Closure $next): Response
    {
        // Ensure API requests negotiate a JSON response. Without an
        // "Accept: application/json" header, Laravel converts validation
        // errors into a 302 redirect instead of a 422 JSON response,
        // which then triggers a CORS error on the frontend.
        if (!str_contains((string) $request->header('Accept'), 'json')) {
            $request->headers->set('Accept', 'application/json');
        }

        return $next($request);
    }
}
