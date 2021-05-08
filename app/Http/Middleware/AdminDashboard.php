<?php

namespace App\Http\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Closure;


class AdminDashboard
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
        if(Auth::user()->type !== 'admin'){
            return redirect('/dashboard');
        }
        return $next($request);
    }
}
