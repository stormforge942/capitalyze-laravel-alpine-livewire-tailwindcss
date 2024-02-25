<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckPagePermission
{
    public function handle($request, Closure $next)
    {
        $routeName = $request->route()->getName();

        /** @var \App\Models\User */
        $user = Auth::user();

        abort_unless($user?->hasNavbar($routeName), 403, 'You do not have permission to access this page.');

        return $next($request);
    }
}
