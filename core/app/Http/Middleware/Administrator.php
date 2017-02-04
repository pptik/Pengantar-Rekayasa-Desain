<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Administrator
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
        $user = Auth::user();
        if($user->peran != 1){
            return view("errors.404");
            //return "Anda tidak diizinkan untuk mengakses halaman ini";
        }else{
            return $next($request);
        }

        //return $next($request);
    }
}
