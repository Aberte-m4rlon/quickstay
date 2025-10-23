<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * $roles can be passed in route: ->middleware(['role:admin,owner'])
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();

        if (!$user) {
            // Not authenticated
            abort(403, 'Unauthorized.');
        }

        if (!in_array($user->role, $roles)) {
            abort(403, 'Unauthorized.');
        }

        return $next($request);
        
    }
}
