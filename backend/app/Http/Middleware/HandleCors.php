<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class HandleCors
{
   
    public function handle(Request $request, Closure $next): Response
    {
        $origin = $request->headers->get('Origin');
        $allowedOrigin = $this->getAllowedOrigin($origin);

        // Preflight (OPTIONS) should return required CORS headers immediately.
        if ($request->isMethod('OPTIONS')) {
            $response = response('', 204);

            if ($allowedOrigin) {
                $response
                    ->header('Access-Control-Allow-Origin', $allowedOrigin)
                    ->header('Access-Control-Allow-Credentials', 'true')
                    ->header('Vary', 'Origin');
            }

            $requestedMethod = $request->headers->get('Access-Control-Request-Method');
            $methods = $requestedMethod
                ? Str::upper($requestedMethod)
                : 'GET, POST, PUT, PATCH, DELETE, OPTIONS';

            $requestedHeaders = $request->headers->get('Access-Control-Request-Headers');
            $headers = $requestedHeaders ?: 'Content-Type, Authorization, X-Requested-With, Accept, Origin';

            $response
                ->header('Access-Control-Allow-Methods', is_string($methods) ? $methods : 'GET, POST, PUT, PATCH, DELETE, OPTIONS')
                ->header('Access-Control-Allow-Headers', $headers)
                ->header('Access-Control-Max-Age', '86400');

            return $response;
        }

        $response = $next($request);

        // Only attach CORS headers when origin is allowed.
        if ($allowedOrigin) {
            $response
                ->header('Access-Control-Allow-Origin', $allowedOrigin)
                ->header('Access-Control-Allow-Credentials', 'true')
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With, Accept, Origin')
                ->header('Vary', 'Origin');
        }

        return $response;
    }

    private function getAllowedOrigin(?string $origin): ?string
    {
        if (!$origin) {
            return null;
        }

        // 1) Exact matches
        $allowedOrigins = config('cors.allowed_origins', []);
        if (is_array($allowedOrigins) && in_array($origin, $allowedOrigins, true)) {
            return $origin;
        }

        // 2) Pattern matches
        $patterns = config('cors.allowed_origins_patterns', []);
        if (!is_array($patterns)) {
            return null;
        }

        foreach ($patterns as $pattern) {
            if (!is_string($pattern) || $pattern === '') {
                continue;
            }

            // Patterns are expected to be PCRE regex strings like: #^https://[^/]+\\.vercel\\.app$#
            if (@preg_match($pattern, $origin) === 1) {
                return $origin;
            }
        }

        return null;
    }
}


