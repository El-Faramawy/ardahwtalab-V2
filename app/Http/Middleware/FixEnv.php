<?php

namespace App\Http\Middleware;

use Closure;

class FixEnv {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if (!\App\Models\SiteConfig::first()->close == '1') {
            return $next($request);
        }
        return response()->view('fix_env');
//        return $next($request);
       /* if(isset($_COOKIE['debug'])) {
                return $next($request);
        } else {
            if (!\App\Models\SiteConfig::first()->close) {
                return $next($request);
            }
            return response()->view('fix_env');
        }*/
    }

}
