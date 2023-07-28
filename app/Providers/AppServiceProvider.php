<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use App\Models\Company;
use App\Models\Fund;
use WireElements\Pro\Components\Spotlight\Spotlight;
use WireElements\Pro\Components\Spotlight\SpotlightQuery;
use WireElements\Pro\Components\Spotlight\SpotlightResult;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Spotlight::registerGroup('companies', 'Companies');
        Spotlight::registerGroup('funds', 'Funds');
        Spotlight::registerGroup('lse', 'LSE');
        Spotlight::registerGroup('euronext', 'Euronext');
        Spotlight::registerGroup('shanghai', 'Shanghai');

        Spotlight::registerQueries(
            SpotlightQuery::asDefault(function ($query) {
                $collection = collect();

                $companies = Company::where('name', 'ilike', "%{$query}%")->orWhere('ticker', 'ilike', "%{$query}%")->take(10)->get();
                $euronexts = DB::connection('pgsql-xbrl')
                ->table('euronext_statements')
                ->where('registrant_name', 'ilike', "%{$query}%")
                ->orWhere('symbol', 'ilike', "%{$query}%")
                ->orWhere('market', 'ilike', "%{$query}%")
                ->orWhere('market_full_name', 'ilike', "%{$query}%")
                ->take(10)->get();
                $lses = DB::connection('pgsql-xbrl')
                ->table('lse_statements')
                ->where('registrant_name', 'ilike', "%{$query}%")
                ->orWhere('symbol', 'ilike', "%{$query}%")
                ->orWhere('market', 'ilike', "%{$query}%")
                ->orWhere('market_segment', 'ilike', "%{$query}%")
                ->orWhere('share_register_country', 'ilike', "%{$query}%")
                ->take(10)->get();
                $shanghais = DB::connection('pgsql-xbrl')
                ->table('shanghai_statements')
                ->where('full_name', 'ilike', "%{$query}%")
                ->orWhere('symbol', 'ilike', "%{$query}%")
                ->orWhere('short_name', 'ilike', "%{$query}%")
                ->take(10)->get();
                $funds = Fund::where('name', 'ilike', "%{$query}%")->orWhere('cik', 'ilike', "%{$query}%")->take(10)->get();

                foreach ($companies as $company) {
                    $collection->push(
                        SpotlightResult::make()
                            ->setGroup('companies')
                            ->setTitle($company->name)
                            ->setAction('jump_to', ['path' => '/company/'.$company->ticker])
                    );
                }

                foreach ($euronexts as $euronext) {
                    $collection->push(
                        SpotlightResult::make()
                            ->setGroup('euronext')
                            ->setTitle($company->name)
                            ->setAction('jump_to', ['path' => '/euronext/'.$company->ticker])
                    );
                }

                foreach ($lses as $lse) {
                    $collection->push(
                        SpotlightResult::make()
                            ->setGroup('lse')
                            ->setTitle($company->name)
                            ->setAction('jump_to', ['path' => '/lse/'.$company->ticker])
                    );
                }

                foreach ($shanghais as $shanghai) {
                    $collection->push(
                        SpotlightResult::make()
                            ->setGroup('shanghai')
                            ->setTitle($company->name)
                            ->setAction('jump_to', ['path' => '/shanghai/'.$company->ticker])
                    );
                }

                foreach ($funds as $fund) {
                    $collection->push(
                        SpotlightResult::make()
                            ->setGroup('funds')
                            ->setTitle($fund->name)
                            ->setAction('jump_to', ['path' => '/fund/'.$fund->cik])
                    );
                }
            
                return $collection;
            })
        );
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
        // log DB request local to termninal for debugging purposes
        if (App::environment('local')) {
            DB::listen(function($query) {
                Log::debug(
                    "Query: {$query->sql}, Bindings: ".json_encode($query->bindings).", Time: {$query->time}"
                );
            });
        }
    }
}
