<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class ApiAuth
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
        $akun = User::where(['remember_token' => $request->token]);
        if( $akun->count() !== 1 )
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda tidak memiliki wewenang'
            ], 403);
        }

        $request->account = $akun->get()->first();
        return $next($request);
    }
}
