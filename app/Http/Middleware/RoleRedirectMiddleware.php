<?php

namespace App\Http\Middleware;

use Closure;

class RoleRedirectMiddleware
{
    public function handle($request, Closure $next)
    {
        // Check if the user is authenticated
        if (auth()->check()) {
            // Get the authenticated user's role
            $role = auth()->user()->role;

            // Redirect the user based on their role
            if ($role === 'Client') {
                return redirect()->route('client.transfers');
            } elseif ($role === 'Admin') {
                return redirect()->route('transfer.index');
            }
        }

        // For other roles or unauthenticated users, continue to the next middleware
        return $next($request);
    }
}
