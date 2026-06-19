<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! in_array($request->user()->role, $roles)) {
            return response()
                ->json([
                    'success' => false,
                    'mesage' => 'Insufficient permission to perform this action',
                ], 403);
        }

        return $next($request);
    }
}
