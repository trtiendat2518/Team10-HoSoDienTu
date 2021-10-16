<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckSession
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
        if(session()->has('admin_id')){
            if ((url('admin/login')==$request->url()) || (url('admin/forgetpassword')==$request->url())) {
                return back();
            }
        }
        return $next($request);
    }
}
