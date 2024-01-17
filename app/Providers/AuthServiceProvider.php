<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\DB;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $groupsThatCanReviewData = DB::table('navbar_group_shows')
            ->join('navbars', 'navbar_group_shows.navbar_id', '=', 'navbars.id')
            ->where('navbars.route_name', '=', 'create.company.segment.report')
            ->where('navbar_group_shows.show', '=', true)
            ->pluck('group_id')
            ->toArray();

        // dd($groupsThatCanReviewData);

        Gate::define('review-data', fn ($user) => in_array($user->group_id, $groupsThatCanReviewData));
    }
}
