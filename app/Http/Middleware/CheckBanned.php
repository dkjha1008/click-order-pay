<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect as RedirectInertia;

class CheckBanned
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
        if (auth()->check() && auth()->user()->status !='1') {
            if (auth()->user()->status =='2') {
                $message = 'Your account has been Blocked. Please contact administrator.';
            } else {
                $message = 'Your account has been suspended. Please contact administrator.';
            }

            auth()->logout();
            return RedirectInertia::route('login')->with('error', $message);
        }

        return $next($request);
    }
}
