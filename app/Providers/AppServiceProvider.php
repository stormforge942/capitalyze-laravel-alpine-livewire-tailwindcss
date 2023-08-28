<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use App\Models\Company;
use App\Models\Fund;
use App\Models\MutualFunds;
use App\Models\Lse;
use App\Models\Hkex;
use App\Models\Tsx;
use App\Models\Shanghai;
use App\Models\Euronext;
use App\Models\Japan;
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
        Spotlight::registerGroup('mutual-funds', 'Mutual Funds');
        Spotlight::registerGroup('euronexts', 'Euronexts');
        Spotlight::registerGroup('lses', 'LSE');
        Spotlight::registerGroup('tsxs', 'TSX');
        Spotlight::registerGroup('shanghais', 'Shanghai');
        Spotlight::registerGroup('japans', 'Japan');
        Spotlight::registerGroup('hkexs', 'HKEX');

        Spotlight::registerQueries(
            SpotlightQuery::asDefault(function ($query) {
                $collection = collect();

                $companies = Company::where('name', 'ilike', "%{$query}%")->orWhere('ticker', 'ilike', "%{$query}%")->take(10)->get();
                $funds = Fund::where('name', 'ilike', "%{$query}%")->orWhere('cik', 'ilike', "%{$query}%")->take(10)->get();

                $mutualFunds = MutualFunds::where('registrant_name', 'ilike', "%{$query}%")->orWhere('cik', 'ilike', "%{$query}%")->take(10)->get();

                $euronexts = Euronext::where('registrant_name', 'ilike', "%{$query}%")
                ->orWhere('symbol', 'ilike', "%{$query}%")
                ->orWhere('market_full_name', 'ilike', "%{$query}%")
                ->take(10)->get();
                $lses = Lse::where('registrant_name', 'ilike', "%{$query}%")
                ->orWhere('symbol', 'ilike', "%{$query}%")
                ->take(10)->get();
                $hkexs = Hkex::where('short_name', 'ilike', "%{$query}%")
                ->orWhere('symbol', 'ilike', "%{$query}%")
                ->take(10)->get();
                $tsxs = Tsx::where('registrant_name', 'ilike', "%{$query}%")
                ->orWhere('symbol', 'ilike', "%{$query}%")
                ->take(10)->get();
                $shanghais = Shanghai::where('full_name', 'ilike', "%{$query}%")
                ->orWhere('symbol', 'ilike', "%{$query}%")
                ->orWhere('short_name', 'ilike', "%{$query}%")
                ->take(10)->get();
                $japans = Japan::where('registrant_name', 'ilike', "%{$query}%")
                ->orWhere('symbol', 'ilike', "%{$query}%")
                ->orWhere('isin', 'ilike', "%{$query}%")
                ->take(10)->get();

                foreach ($companies as $company) {
                    $collection->push(
                        SpotlightResult::make()
                            ->setGroup('companies')
                            ->setTitle("$company->name ($company->ticker)")
                            ->setAction('jump_to', ['path' => '/company/'.$company->ticker])
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

                foreach ($mutualFunds as $mutualFund) {
                    $collection->push(
                        SpotlightResult::make()
                            ->setGroup('mutual-funds')
                            ->setTitle("$mutualFund->cik | $mutualFund->registrant_name | $mutualFund->fund_symbol | $mutualFund->series_id | $mutualFund->class_id")
                            ->setAction('jump_to', ['path' => '/mutual-fund/'.$mutualFund->cik.'/'.$mutualFund->fund_symbol.'/'.$mutualFund->series_id.'/'.$mutualFund->class_id])
                    );
                }

                foreach ($euronexts as $euronext) {
                    $collection->push(
                        SpotlightResult::make()
                            ->setGroup('euronexts')
                            ->setTitle("$euronext->registrant_name | $euronext->symbol | $euronext->market | $euronext->market_full_name | $euronext->isin")
                            ->setAction('jump_to', ['path' => '/euronext/'.$euronext->symbol])
                    );
                }

                foreach ($lses as $lse) {
                    $collection->push(
                        SpotlightResult::make()
                            ->setGroup('lses')
                            ->setTitle("$lse->registrant_name | $lse->symbol | $lse->market | $lse->market_segment | $lse->isin")
                            ->setAction('jump_to', ['path' => '/lse/'.$lse->symbol])
                    );
                }

                foreach ($hkexs as $hkex) {
                    $collection->push(
                        SpotlightResult::make()
                            ->setGroup('hkexs')
                            ->setTitle("$hkex->short_name | $hkex->symbol")
                            ->setAction('jump_to', ['path' => '/hkex/'.$hkex->symbol])
                    );
                }

                foreach ($tsxs as $tsx) {
                    $collection->push(
                        SpotlightResult::make()
                            ->setGroup('tsxs')
                            ->setTitle("$tsx->registrant_name | $tsx->symbol")
                            ->setAction('jump_to', ['path' => '/tsx/'.$tsx->symbol])
                    );
                }

                foreach ($shanghais as $shanghai) {
                    $collection->push(
                        SpotlightResult::make()
                            ->setGroup('shanghais')
                            ->setTitle("$shanghai->full_name | $shanghai->symbol | $shanghai->short_name")
                            ->setAction('jump_to', ['path' => '/shanghai/'.$shanghai->symbol])
                    );
                }

                foreach ($japans as $japan) {
                    $collection->push(
                        SpotlightResult::make()
                            ->setGroup('japans')
                            ->setTitle("$japan->registrant_name | $japan->symbol | $japan->isin")
                            ->setAction('jump_to', ['path' => '/japan/'.$japan->symbol])
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
