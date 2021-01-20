<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
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
        // BUG: AL NO ESTAR LOGEADO EL $request VIENE VACIO CON LO CUAL GENERA ERROR
        if(Auth::check())           
        {
            if($request->user()->authorizeRoles(['developer']))
            {
                return redirect()->route('developer.index');
            }
            else
            {
                return redirect()->route('client.index');
            }
        }
        else
        {
            return $next($request);  
        }
    }
}
