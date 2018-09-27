<?php

namespace App\Http\Middleware;

use App\Exceptions\ApiUnauthorizedException;
use Closure;

class HasAdminPermissions
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
        if ( ! auth()->check() || ! auth()->user()->hasAdminPermissions()) {
            throw new ApiUnauthorizedException();
        }

        return $next($request);

    }
}