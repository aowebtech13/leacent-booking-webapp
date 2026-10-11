<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class CheckInactivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $bearerToken = $request->bearerToken();
        
        if ($bearerToken) {
            $token = PersonalAccessToken::findToken($bearerToken);
            
            if ($token && $token->last_used_at) {
                $inactivityLimit = 120; // 2 hours in minutes
                
                if ($token->last_used_at->diffInMinutes(now()) > $inactivityLimit) {
                    $token->delete();
                    return response()->json([
                        'success' => false,
                        'message' => 'Session expired due to inactivity. Please log in again.',
                        'error' => 'inactivity_logout'
                    ], 401);
                }
            }
        }

        return $next($request);
    }
}
