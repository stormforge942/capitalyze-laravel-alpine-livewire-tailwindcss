<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwoFactorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (! Auth::check() && ! $request->session()->has('user_id')) {
            return redirect()->route('login');
        }

        if (! Auth::check()) {
            return redirect()->route('2fa.index');
        }

        return $next($request);
    }
}
