<?php

namespace App\Http\Middleware;

use Closure;
use App\Exceptions\ApiUnauthorizedException;

class HasRootPermissions
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
        if (! auth()->check() || ! auth()->user()->hasRootPermissions()) {
            throw new ApiUnauthorizedException();
        }

        return $next($request);
    }
}
