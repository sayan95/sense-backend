<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;

class CSRFCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if($request->header('csrf-token') !== auth()->guard($guard)->payload()->get('csrf-token')){
            throw new AuthorizationException('csrf token did not match');
        }
        return $next($request);
    }
}
