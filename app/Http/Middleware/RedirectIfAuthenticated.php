<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Auth\AuthMongoController;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (AuthMongoController::check()) {
            return redirect('/');
        }

        return $next($request);
    }
}
