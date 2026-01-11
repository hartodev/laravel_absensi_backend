<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContextMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $type, $role = null): Response
    {
        $user = $request->user();

        // cek company type
        if ($user->company->type !== $type) {
            return response()->json(['message' => 'Wrong app context'], 403);
        }

        // jika ada role
        if ($role && $user->role !== $role) {
            return response()->json(['message' => 'Wrong role'], 403);
        }

        return $next($request);
    }
}
