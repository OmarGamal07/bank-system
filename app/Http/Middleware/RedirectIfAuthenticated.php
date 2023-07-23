<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;
    //    if(Auth::user()->role=='client'){
    //     return redirect()->route('client.transfers');
    //    }
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                //  // Get the authenticated user
                //  $user = Auth::guard($guard)->user();
                    
                //  // Check the user's role
                //  if ($user->role === 'Client') {
                //      return redirect()->route('client.transfers');
                // // return '/admin';

                //  } elseif ($user->role === 'Admin') {
                //      return redirect()->route('transfer.index');
                //  }
                return $next($request);
            }
        }

        return $next($request);
    }
}
