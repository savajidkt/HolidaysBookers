<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class AgentAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, $guard = null)
    {
       
        if(Auth::guard('admin')->user()){
            return redirect(route('login'));
        }else if(auth()->check()){
            if(auth()->user()->user_type == User::CUSTOMER){
                return redirect(route('login'));
            }

        }else{
            return redirect(route('login'));
        }

        $response = $next($request);

        return $response;
    }
}
