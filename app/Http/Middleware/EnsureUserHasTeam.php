<?php

namespace App\Http\Middleware;

use App\Enums\Plan;
use App\Models\Team;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnsureUserHasTeam
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if ($user && ! $user->team) {
            DB::transaction(function () use ($user) {
                $team = Team::query()->where('owner_id', $user->id)->first() ?? Team::create([
                    'name' => $user->name.'\' Team',
                    'plan' => Plan::SOLO,
                    'owner_id' => $user->id,
                ]);

                $user->update([
                    'current_team_id' => $team->id,
                ]);
            });
        }

        return $next($request);
    }
}
