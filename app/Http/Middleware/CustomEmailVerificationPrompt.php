<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;

class CustomEmailVerificationPrompt
{
    public function handle(Request $request, Closure $next)
    {
        if (
            $request->user() instanceof MustVerifyEmail &&
            !$request->user()->hasVerifiedEmail() &&
            !$request->is('email/*', 'logout', 'waiting-for-approval')
        ) {
            return redirect()->route('waiting-for-approval');
        }

        return $next($request);
    }
}
