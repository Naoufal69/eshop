<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTokenActivity
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->user()?->currentAccessToken();

        if ($token) {
            $lastUsed = $token->last_used_at;
            if ($lastUsed && now()->diffInDays($lastUsed) > 30) {
                $token->delete();
                return response()->json(['message' => 'Token expiré par inactivité'], 401);
            }
            $token->forceFill(['last_used_at' => now()])->save();
        }

        return $next($request);
    }
}
