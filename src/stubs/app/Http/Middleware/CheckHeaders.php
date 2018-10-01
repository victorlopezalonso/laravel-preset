<?php

namespace App\Http\Middleware;

use App\Http\Requests\Headers;
use Closure;

class CheckHeaders
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
        $request->headers->set('Accept', 'application/json');

        Headers::checkHeaders();

        return $next($request);
    }
}
