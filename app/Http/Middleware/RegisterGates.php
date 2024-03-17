<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;

class RegisterGates
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
        $groupsThatCanReviewData = DB::table('navbar_group_shows')
            ->join('navbars', 'navbar_group_shows.navbar_id', '=', 'navbars.id')
            ->where('navbars.route_name', '=', 'create.company.segment.report')
            ->where('navbar_group_shows.show', '=', true)
            ->pluck('group_id')
            ->toArray();

        Gate::define('review-data', fn ($user) => in_array($user->group_id, $groupsThatCanReviewData));

        return $next($request);
    }
}
