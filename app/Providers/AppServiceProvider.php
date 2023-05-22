<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (App::environment('production')) {
            DB::listen(function($query) {
                Log::stack(['papertrail'])->debug(
                    "Query: {$query->sql}, Bindings: ".json_encode($query->bindings).", Time: {$query->time}"
                );
            });
        }
    }
}
