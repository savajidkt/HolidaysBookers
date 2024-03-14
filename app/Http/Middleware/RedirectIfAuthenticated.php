<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;
        $webRoute = Route::getCurrentRoute()->getAction('authGrouping') === 'users.auth';
        foreach ($guards as $guard) {

            if (Auth::guard($guard)->check()) {
                if (isset(auth()->user()->user_type) && auth()->user()->user_type == User::AGENT) {
                    return redirect(route('agent.dashboard'));
                } else if (isset(auth()->user()->user_type) && auth()->user()->user_type == User::VENDOR) {
                    return redirect(route('vendor.dashboard'));
                } else if (isset(auth()->user()->user_type) && auth()->user()->user_type == User::CORPORATE) {
                    return redirect(route('corporate.dashboard'));
                } else if (isset(auth()->user()->user_type) && auth()->user()->user_type == User::CUSTOMER) {                    
                    return redirect(route('customer.dashboard'));
                } else if ($guard == "admin") {                    
                    return redirect(RouteServiceProvider::adminHOME);
                } else {                    
                    return redirect(RouteServiceProvider::HOME);
                }                                
            }
        }
        
        //dd(Auth::guard($guard)->check());
        return $next($request);
    }
}
