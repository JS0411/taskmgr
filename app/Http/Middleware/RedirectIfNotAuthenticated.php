<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfNotAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $guard = null): Response
    {       
        if (!Auth::guard($guard)->check() && !$request->isMethod('post')) {
            $routeName = Route::currentRouteName();
            if (!in_array($routeName, ['login', 'register'])) {
                return redirect()->route('login');
            }
        }
        return $next($request);
    }
}
