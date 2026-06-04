<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * Aborts with 403 if the authenticated user does not have the required role.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (! auth()->check() || auth()->user()->role->value !== $role) {
            abort(403);
        }

        return $next($request);
    }
}
