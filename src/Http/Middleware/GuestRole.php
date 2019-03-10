<?php

namespace Kjjdion\Laracrud\Http\Middleware;

use Closure;
use Illuminate\Support\Str;

class GuestRole
{
    public function handle($request, Closure $next, $guard = null)
    {
        // redirect user to role home page if logged in
        if (auth()->check()) {
            return redirect()->route(Str::snake(auth()->user()->role));
        }

        return $next($request);
    }
}