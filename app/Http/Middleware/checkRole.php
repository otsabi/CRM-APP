<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;

class checkRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$roles)
    {
        $array_role = explode('|',$roles);

        if(!Auth::user()->hasRole($array_role)){
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
