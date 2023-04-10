<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class CustomerAuthenticated
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

        if (Auth::guard('admin')->user()) {
            return redirect(route('login'));
        } else if (auth()->check()) {
            if (auth()->user()->user_type == User::AGENT) {
                return redirect(route('login'));
            }
            if (auth()->user()->user_type == User::VENDOR) {
                return redirect(route('login'));
            }
            if (auth()->user()->user_type == User::CORPORATE) {
                return redirect(route('login'));
            }
        } else {
            return redirect(route('login'));
        }

        $response = $next($request);

        return $response;
    }
}
