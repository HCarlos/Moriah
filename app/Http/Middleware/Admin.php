<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;

class Admin
{
    public function handle($request, Closure $next)
    {
//        if (! auth()->user()->admin ){
        if ( !auth()->user()->isAdmin() ){
//        if (! optional($request->user())->isAdmin() ){
            throw new AuthorizationException();
        }
        return $next($request);
    }
}
