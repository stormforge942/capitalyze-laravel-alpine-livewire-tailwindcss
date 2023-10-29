<?php

namespace App\Http\Middleware;

use App\Services\OwnershipHistoryService;
use Closure;
use Illuminate\Http\Request;

class RememberOwnershipHistory
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $referer = $request->headers->get('referer');

        // If the user has visited outside of the ownership pages, or visited from sidenav clear the history
        if (
            !($referer && strpos(parse_url($referer, PHP_URL_PATH), '/ownership'))
            || $request->query('history', true) == false
        ) {
            OwnershipHistoryService::clear();
        }

        return $next($request);
    }
}
