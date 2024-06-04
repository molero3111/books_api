<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyAdminRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        $user = $request->user();
        if (!$user->tokenCan($role) || !$user->hasRole($role)) {
            return response()->json(['message' => 'Unauthorized. You are not allowed to perform this action.'], 401);
        }
        return $next($request);
    }
}
