<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Controllers\Auth\AuthMongoController;

class AuthMongoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!AuthMongoController::check()){
            return redirect()->route('logInPage');
        }
        return $next($request);
    }
}
