<?php

namespace App\Providers;

use App\Models\Etf;
use App\Models\Lse;
use App\Models\Otc;
use App\Models\Tsx;
use App\Models\Fund;
use App\Models\Hkex;
use App\Models\Japan;
use App\Models\Company;
use App\Models\Euronext;
use App\Models\Shanghai;
use App\Models\Shenzhen;
use App\Models\Frankfurt;
use App\Models\MutualFunds;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Blade;
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
        $this->registerSpotlight();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->logDbQueries();

        $this->customizeEmails();

        Blade::directive('redIfNegative', function (...$args) {
            $value = redIfNegative(...$args);
            return "<?php echo $value ?>";
        });
    }

    private function registerSpotlight()
    {
        Spotlight::registerGroup('companies', 'Companies');
        Spotlight::registerGroup('funds', 'Funds');
        Spotlight::registerGroup('mutual-funds', 'Mutual Funds');
        Spotlight::registerGroup('etfs', 'Etf');
        Spotlight::registerGroup('euronexts', 'Euronexts');
        Spotlight::registerGroup('lses', 'LSE');
        Spotlight::registerGroup('tsxs', 'TSX');
        Spotlight::registerGroup('shanghais', 'Shanghai');
        Spotlight::registerGroup('japans', 'Japan');
        Spotlight::registerGroup('hkexs', 'HKEX');
        Spotlight::registerGroup('otcs', 'OTC');
        Spotlight::registerGroup('frankfurts', 'Frankfurt');
        Spotlight::registerGroup('shenzhens', 'Shenzhen');

        Spotlight::registerQueries(
            SpotlightQuery::asDefault(function ($query) {
                $collection = collect();

                $companies = Company::where('name', 'ilike', "%{$query}%")->orWhere('ticker', 'ilike', "%{$query}%")->take(10)->get();
                $funds = Fund::where('name', 'ilike', "%{$query}%")->orWhere('cik', 'ilike', "%{$query}%")->take(10)->get();

                $mutualFunds = MutualFunds::where('registrant_name', 'ilike', "%{$query}%")->orWhere('cik', 'ilike', "%{$query}%")->orWhere('class_id', 'ilike', "%{$query}%")->orWhere('series_id', 'ilike', "%{$query}%")->orWhere('fund_symbol', 'ilike', "%{$query}%")->take(10)->get();
                $etfs = Etf::where('registrant_name', 'ilike', "%{$query}%")->orWhere('cik', 'ilike', "%{$query}%")->orWhere('etf_symbol', 'ilike', "%{$query}%")->take(10)->get();

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
                $otcs = Otc::where('company_name', 'ilike', "%{$query}%")
                    ->orWhere('symbol', 'ilike', "%{$query}%")
                    ->take(10)->get();
                $frankfurts = Frankfurt::where('company_name', 'ilike', "%{$query}%")
                    ->orWhere('symbol', 'ilike', "%{$query}%")
                    ->take(10)->get();
                $shenzhens = Shenzhen::where('company_name', 'ilike', "%{$query}%")
                    ->orWhere('symbol', 'ilike', "%{$query}%")
                    ->take(10)->get();

                foreach ($companies as $company) {
                    $collection->push(
                        SpotlightResult::make()
                            ->setGroup('companies')
                            ->setTitle("$company->name ($company->ticker)")
                            ->setAction('jump_to', ['path' => '/company/' . $company->ticker])
                    );
                }

                foreach ($funds as $fund) {
                    $collection->push(
                        SpotlightResult::make()
                            ->setGroup('funds')
                            ->setTitle($fund->name)
                            ->setAction('jump_to', ['path' => '/fund/' . $fund->cik])
                    );
                }

                foreach ($mutualFunds as $mutualFund) {
                    $collection->push(
                        SpotlightResult::make()
                            ->setGroup('mutual-funds')
                            ->setTitle("$mutualFund->cik | $mutualFund->registrant_name | $mutualFund->fund_symbol | $mutualFund->series_id | $mutualFund->class_id | $mutualFund->class_name")
                            ->setAction('jump_to', ['path' => '/mutual-fund/' . $mutualFund->cik . '/' . $mutualFund->fund_symbol . '/' . $mutualFund->series_id . '/' . $mutualFund->class_id])
                    );
                }

                foreach ($etfs as $etf) {
                    $collection->push(
                        SpotlightResult::make()
                            ->setGroup('etfs')
                            ->setTitle("$etf->cik | $etf->registrant_name | $etf->etf_symbol")
                            ->setAction('jump_to', ['path' => '/etf/' . $etf->cik . '/' . $etf->etf_symbol])
                    );
                }

                foreach ($euronexts as $euronext) {
                    $collection->push(
                        SpotlightResult::make()
                            ->setGroup('euronexts')
                            ->setTitle("$euronext->registrant_name | $euronext->symbol | $euronext->market | $euronext->market_full_name | $euronext->isin")
                            ->setAction('jump_to', ['path' => '/euronext/' . $euronext->symbol])
                    );
                }

                foreach ($lses as $lse) {
                    $collection->push(
                        SpotlightResult::make()
                            ->setGroup('lses')
                            ->setTitle("$lse->registrant_name | $lse->symbol | $lse->market | $lse->market_segment | $lse->isin")
                            ->setAction('jump_to', ['path' => '/lse/' . $lse->symbol])
                    );
                }

                foreach ($hkexs as $hkex) {
                    $search = !empty($hkex->full_name) ? "$hkex->full_name | $hkex->short_name | $hkex->symbol" : "$hkex->short_name | $hkex->symbol";
                    $collection->push(
                        SpotlightResult::make()
                            ->setGroup('hkexs')
                            ->setTitle($search)
                            ->setAction('jump_to', ['path' => '/hkex/' . $hkex->symbol])
                    );
                }

                foreach ($tsxs as $tsx) {
                    $collection->push(
                        SpotlightResult::make()
                            ->setGroup('tsxs')
                            ->setTitle("$tsx->registrant_name | $tsx->symbol")
                            ->setAction('jump_to', ['path' => '/tsx/' . $tsx->symbol])
                    );
                }

                foreach ($shanghais as $shanghai) {
                    $collection->push(
                        SpotlightResult::make()
                            ->setGroup('shanghais')
                            ->setTitle("$shanghai->full_name | $shanghai->symbol | $shanghai->short_name")
                            ->setAction('jump_to', ['path' => '/shanghai/' . $shanghai->symbol])
                    );
                }

                foreach ($japans as $japan) {
                    $collection->push(
                        SpotlightResult::make()
                            ->setGroup('japans')
                            ->setTitle("$japan->registrant_name | $japan->symbol | $japan->isin")
                            ->setAction('jump_to', ['path' => '/japan/' . $japan->symbol])
                    );
                }

                foreach ($otcs as $otc) {
                    $collection->push(
                        SpotlightResult::make()
                            ->setGroup('otcs')
                            ->setTitle("$otc->company_name | $otc->symbol")
                            ->setAction('jump_to', ['path' => '/otc/' . $otc->symbol])
                    );
                }

                foreach ($frankfurts as $frankfurt) {
                    $collection->push(
                        SpotlightResult::make()
                            ->setGroup('frankfurts')
                            ->setTitle("$frankfurt->company_name | $frankfurt->symbol")
                            ->setAction('jump_to', ['path' => '/frankfurt/' . $frankfurt->symbol])
                    );
                }

                foreach ($shenzhens as $shenzhen) {
                    $collection->push(
                        SpotlightResult::make()
                            ->setGroup('shenzhens')
                            ->setTitle("$shenzhen->company_name | $shenzhen->symbol")
                            ->setAction('jump_to', ['path' => '/shenzhen/' . $shenzhen->symbol])
                    );
                }

                return $collection;
            })
        );
    }

    private function logDbQueries()
    {
        // if (App::environment('production')) {
        //     DB::listen(function ($query) {
        //         Log::stack(['papertrail'])->debug(
        //             "Query: {$query->sql}, Bindings: " . json_encode($query->bindings) . ", Time: {$query->time}"
        //         );
        //     });
        // }
        // log DB request local to termninal for debugging purposes

        if (App::environment('local') && env('DB_LOG', true)) {
            DB::listen(function ($query) {
                // Get the full stack trace
                $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);

                // Filter out the vendor calls and get the first user-land caller
                $caller = collect($backtrace)
                    ->filter(function ($trace) {
                        return isset($trace['file']) && !str_contains($trace['file'], 'vendor/');
                    })
                    ->first();

                $class = $caller['class'] ?? 'N/A';
                $function = $caller['function'] ?? 'N/A';
                $file = $caller['file'] ?? 'N/A';
                $line = $caller['line'] ?? 'N/A';

                // Construct the log message
                $message = "Query: {$query->sql}, Bindings: " . json_encode($query->bindings) . ", Time: {$query->time}";
                $message .= ", Called by: {$class}@{$function}, File: {$file}, Line: {$line}";

                // Log the message
                Log::debug($message);
            });
        }
    }

    private function customizeEmails()
    {
        // Customize verify email notification
        VerifyEmail::toMailUsing(function ($user, $url) {
            return (new MailMessage)
                ->subject('Important: Please verify your email address')
                ->view('mails.verify-email', [
                    'user' => $user,
                    'url' => $url,
                ]);
        });

        // customize reset password notification
        ResetPassword::toMailUsing(function ($user, $token) {
            return (new MailMessage)
                ->subject('Password change request')
                ->view('mails.reset-password', [
                    'user' => $user,
                    'url' => url(route('password.reset', [
                        'token' => $token,
                        'email' => $user->getEmailForPasswordReset(),
                    ], false)),
                ]);
        });
    }
}
