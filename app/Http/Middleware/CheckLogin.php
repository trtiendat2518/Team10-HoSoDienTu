<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckLogin
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
        if( (!session()->has('admin_id')) && (!session()->has('lecturer_id')) ) {
            return redirect('admin/login')->with('fail', 'Bạn cần đăng nhập để vào hệ thống!');
        }
        return $next($request);
    }
}
