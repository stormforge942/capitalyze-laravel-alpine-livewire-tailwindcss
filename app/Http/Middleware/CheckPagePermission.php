<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckPagePermission
{
    public function handle($request, Closure $next)
    {
        $routeName = $request->route()->getName();

        if (Auth::user()->hasNavbar($routeName)) {
            return $next($request);
        }

        return redirect()->route('permission-denied');
    }
}
