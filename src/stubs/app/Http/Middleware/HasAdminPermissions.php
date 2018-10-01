<?php

namespace App\Http\Middleware;

use Closure;
use App\Exceptions\ApiUnauthorizedException;

class HasAdminPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! auth()->check() || ! auth()->user()->hasAdminPermissions()) {
            throw new ApiUnauthorizedException();
        }

        return $next($request);
    }
}
