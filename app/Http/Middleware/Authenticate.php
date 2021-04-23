<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }

    // handle authenticated request
    public function handle($request, Closure $next, ...$guards)
    {
        if($jwt = $request->cookie('jwt')){
            $request->headers->set('Authorization', 'Bearer' . $jwt);
        }
        if($csrf = $request->cookie('csrf')){
            $request->headers->set('CSRF-Token', $csrf);
        }

        $this->authenticate($request, $guards);
        return $next($request);
    }
}
