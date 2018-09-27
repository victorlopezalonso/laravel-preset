<?php

namespace App\Http\Middleware;

use App\Exceptions\ApiUnauthorizedException;
use Closure;

class HasRootPermissions
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
        if ( ! auth()->check() || ! auth()->user()->hasRootPermissions()) {
            throw new ApiUnauthorizedException();
        }

        return $next($request);
    }
}