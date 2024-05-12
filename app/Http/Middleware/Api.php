<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use App\Http\Requests;
use Closure;
use Response;

class Api
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $type)
    {
        $user = null;
        // dd($request->all() , 'sdfss');
        if ($type == 'auth') {
            $user = \App\User::where(['api_token' => $request->input('api_token')])->first();
        } elseif ($type == 'lawyer') {
            $user = \App\Lawyer::where(['api_token' => $request->input('api_token')])->first();
        }
        if ($request->input('api_token') && $user) {
            return $next($request);
        }
        return Response::json([
            'code'    => '401',
            'message' => 'Unauthorized action'
        ]);
    }
}
