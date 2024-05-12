<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Active {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        // dd('sdvfdbvdfbvs');
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        if (Auth::user()->active) {
            return $next($request);
        }
        return redirect()->route('users.active')->with(['error', 'يجب تفعيل الحساب أولا']);
    }

}
