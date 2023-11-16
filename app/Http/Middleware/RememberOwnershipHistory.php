<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\OwnershipHistoryService;

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
        $referer = rtrim(parse_url($request->headers->get('referer', ""), PHP_URL_PATH), '/');

        // If the user has visited outside of the ownership pages, or visited from sidenav clear the history
        $routePatterns = [
            '/^\/company\/([a-zA-Z0-9_]+)\/ownership$/',
            '/^\/fund\/([a-zA-Z0-9_]+)$/',
        ];

        if (
            !$referer ||
            !(preg_match($routePatterns[0], $referer) || preg_match($routePatterns[1], $referer)) ||
            $request->query('history', true) == false
        ) {
            info('cleared');
            OwnershipHistoryService::clear();
        }

        return $next($request);
    }
}
