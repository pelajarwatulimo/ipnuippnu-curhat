<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role = null)
    {
        if( !Auth::user()->is_admin && $role == 'admin' )
            abort(404);

        elseif( Auth::user()->is_admin && $role == 'user' )
            abort(404);
            
        return $next($request);
    }
}
