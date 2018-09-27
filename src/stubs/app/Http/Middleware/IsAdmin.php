<?php

namespace App\Http\Middleware;

use Closure;

class IsAdmin
{

    /**
     * Handle an incoming request.
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     * @throws \Exception
     */
    public function handle($request, Closure $next)
    {
        if ( ! auth()->check() || ! auth()->user()->isAdmin()) {
            return redirect()->guest('/');
        }

        return $next($request);

    }
}