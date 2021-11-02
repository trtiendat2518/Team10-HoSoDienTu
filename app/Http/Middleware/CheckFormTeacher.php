<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Lecturer;
use Session;

class CheckFormTeacher
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
        $user = Lecturer::where('lecturer_code' ,Session::get('lecturer_id'))->get();
        foreach($user as $role) {
            if($role->lecturer_role != 2) {
                return back();
            }
        }
        return $next($request);
    }
}
