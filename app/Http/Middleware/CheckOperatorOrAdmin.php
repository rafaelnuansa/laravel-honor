<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckOperatorOrAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();

        if (!$user || ($user->level !== 'Operator' && $user->level !== 'Administrator' || !auth()->guard('users')->check())) {
            return redirect()->route('login')->with('warning', 'Please login with your account');
        }

        return $next($request);
    }

}
