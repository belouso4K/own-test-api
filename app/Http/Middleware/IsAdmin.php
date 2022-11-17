<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        /*
      Any user with a permission that is not an admin will
      receive a 403 un authorized action response.
    */

            if (auth()->check() && auth()->user()->roles()->exists()) {
                return $next($request);
            }

//        if(!auth()->user()->hasRole($role)) {
//            abort(404);
//        }
//        if($permission !== null && !auth()->user()->can($permission)) {
//            abort(404);
//        }
//        return $next($request);
//        if (Auth::user()->roles()->first()->slug != 'super-admin' ) {
//            abort(403, 'Несанкционированное действие.');
//        }
//        return $next($request);
    }
}
