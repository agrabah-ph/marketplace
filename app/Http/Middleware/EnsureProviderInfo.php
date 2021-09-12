<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class EnsureProviderInfo
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
        if (env('APP_ENV') === 'testing') {
            return $next($request);
        }

        if(auth()->user()->hasRole('farmer') ){
            if(Auth::user()->farmer->community_leader == 1 ){
                if(is_null(Auth::user()->farmer->profile)){
                    return redirect()->route('profile-create');
                }
            }
        }

        if(auth()->user()->hasRole('buyer')){
            if(is_null(Auth::user()->profile)){

                return redirect()->route('profile-create');
            }
        }

        return $next($request);
    }
}
