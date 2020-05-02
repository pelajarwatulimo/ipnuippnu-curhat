<?php

namespace App\Http\Middleware;

use Closure;

class ProtectIndexPHP
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
        if( preg_match("/\/index\.php[A-Za-z0-9_.\-~]*/", $_SERVER['REQUEST_URI']) )
            abort(404);
            
        return $next($request);
    }
}
