<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use DB;
class Systems
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$type)
    {
       if(DB::table('site_systems')->where('type',$type)->first()->active){
            return $next($request);
       } return redirect()->route('errors',['type'=>'not_allowed']);
    }
}
