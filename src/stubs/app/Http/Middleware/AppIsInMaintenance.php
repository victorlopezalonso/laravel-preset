<?php

namespace App\Http\Middleware;

use App\Exceptions\ApiAppInMaintenanceException;
use App\Models\Config;
use Closure;

class AppIsInMaintenance
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     * @throws \Throwable
     */
    public function handle($request, Closure $next)
    {
        throw_if(Config::first()->appIsInMaintenance(), new ApiAppInMaintenanceException());

        return $next($request);
    }
}
