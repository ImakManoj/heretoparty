<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\User;


class Users
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
        if (Auth::check() && Auth::User()->role == 'Users') {
            return $next($request);
        }
        elseif (Auth::check() && Auth::User()->role == 'Admin') {
            return redirect('/');
        }elseif (Auth::check() && Auth::User()->role == 'Vendor') {
            return redirect('/');
        }else {
            return redirect('/');
        }
    }
}
