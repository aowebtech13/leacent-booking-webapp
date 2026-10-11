<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateLastSeen
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = null;

        // Check web guard (session-based)
        if (auth('web')->check()) {
            $user = auth('web')->user();
        } 
        // Check sanctum guard (token-based) if it's an API request
        elseif ($request->expectsJson() || $request->is('api/*')) {
            // We use auth('sanctum')->user() which will attempt to authenticate if not already done
            $user = auth('sanctum')->user();
        }

        if ($user) {
            // Only update if last_seen_at is null or more than 1 minute ago to reduce DB writes
            if (!$user->last_seen_at || $user->last_seen_at->lt(now()->subMinute())) {
                // Use update to avoid triggering other model events if not needed, 
                // but since we need to update the model instance too, we use save or update
                $user->last_seen_at = now();
                $user->save();
            }
        }

        return $next($request);
    }
}
