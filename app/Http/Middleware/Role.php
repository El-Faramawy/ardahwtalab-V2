<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$role)
    {

        if(!isset(Auth::user()->roles->roles)){
        return $next($request);

        }

        $roles=explode(',',Auth::user()->roles->roles);
        if(in_array($role,$roles)){
            return $next($request);
        }
        return redirect()->back();
    }
}
