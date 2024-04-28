<?php

use App\Http\Livewire\Lses;
use App\Http\Livewire\Otcs;
use App\Http\Livewire\Tsxs;
use App\Http\Livewire\Hkexs;
use App\Http\Livewire\Japans;
use Laravel\Fortify\RoutePath;
use App\Http\Livewire\Euronexts;
use App\Http\Livewire\Shanghais;
use App\Http\Livewire\Shenzhens;
use App\Http\Livewire\Delistings;
use App\Http\Livewire\Frankfurts;
use App\Http\Livewire\ReviewPage;
use App\Http\Livewire\PressRelease;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\EconomicRelease;
use App\Http\Livewire\FundFilingsPage;
use App\Http\Controllers\EtfController;
use App\Http\Controllers\LseController;
use App\Http\Controllers\OtcController;
use App\Http\Controllers\TsxController;
use App\Http\Controllers\FundController;
use App\Http\Controllers\HkexController;
use App\Http\Controllers\HomeController;
use App\Http\Livewire\EconomicsCalendar;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Builder\ChartController;
use App\Http\Controllers\JapanController;
use App\Http\Livewire\CompanyFilingsPage;
use App\Http\Livewire\CompanyIdentifiers;
use App\Http\Middleware\EnsureUserIsAdmin;
use App\Http\Controllers\BuilderController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EuronextController;
use App\Http\Controllers\ShanghaiController;
use App\Http\Controllers\ShenzhenController;
use App\Http\Livewire\EconomicReleaseSeries;
use App\Http\Livewire\MutualFundFilingsPage;
use App\Http\Middleware\CheckPagePermission;
use App\Http\Controllers\FrankfurtController;
use App\Http\Controllers\MutualFundController;
use App\Http\Controllers\VerifyEmailController;
use App\Http\Controllers\EventFilingsController;
use App\Http\Controllers\ResetLinkSentController;
use App\Http\Controllers\TrackInvestorController;
use App\Http\Controllers\EarningsCalendarController;
use App\Http\Middleware\CustomEmailVerificationPrompt;
use App\Http\Controllers\InsiderTransactionsController;
use App\Http\Controllers\ResetPasswordSuccessfulController;
use App\Http\Controllers\UpdateSettingsController;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

Route::get('/test-speed', function () {
    return "hello World";
});

Route::get('/', HomeController::class)->name('home');

Route::group(['middleware' => ['auth', 'approved', 'verified', CheckPagePermission::class]], function () {
    Route::get('/track-investors', TrackInvestorController::class)->name('track-investors');
    Route::get('/event-filings', EventFilingsController::class)->name('event-filings');
    Route::get('/insider-transactions', InsiderTransactionsController::class)->name('insider-transactions');
    Route::get('/calendar/earnings', EarningsCalendarController::class)->name('earnings-calendar');

    Route::get('/calendar/economics', EconomicsCalendar::class)->name('economics-calendar');
    Route::get('/calendar/economics/{release_id}/', EconomicRelease::class)->name('economics-release');
    Route::get('/calendar/economics/{release_id}/{series_id}/', EconomicReleaseSeries::class)->name('economics-release-series');
    Route::get('/company-filings', CompanyFilingsPage::class)->name('company-filings');
    Route::get('/fund-filings', FundFilingsPage::class)->name('fund-filings');
    Route::get('/mutual-fund-filings', MutualFundFilingsPage::class)->name('mutual-fund-filings');
    Route::get('/etf-filings', [EtfController::class, 'filings'])->name('etf-filings');
    Route::get('/identifiers', CompanyIdentifiers::class)->name('company-identifiers');
    Route::get('/delistings', Delistings::class)->name('delistings');
    Route::get('/euronext', Euronexts::class)->name('euronexts');
    Route::get('/lse', Lses::class)->name('lses');
    Route::get('/tsx', Tsxs::class)->name('tsxs');
    Route::get('/shanghai', Shanghais::class)->name('shanghais');
    Route::get('/japan', Japans::class)->name('japans');
    Route::get('/hkex', Hkexs::class)->name('hkexs');
    Route::get('/otc', Otcs::class)->name('otcs');
    Route::get('/frankfurt', Frankfurts::class)->name('frankfurts');
    Route::get('/shenzhen', Shenzhens::class)->name('shenzhens');
    Route::get('/review', ReviewPage::class)->name('review');
    Route::get('/press-release', PressRelease::class)->name('press.release');

    Route::group(['prefix' => 'company/{ticker}', 'as' => 'company.'], function () {
        Route::get('/', [CompanyController::class, 'profile'])->name('profile');
        Route::get('/products', [CompanyController::class, 'product'])->name('profiles');
        Route::get('/filings-summary', [CompanyController::class, 'filingsSummary'])->name('filings-summary');
        Route::get('/executive-compensation', [CompanyController::class, 'executiveCompensation'])->name('executive.compensation');
        Route::get('/chart', [CompanyController::class, 'chart'])->name('chart');
        Route::get('/splits', [CompanyController::class, 'splits'])->name('splits');
        Route::get('/geographic', [CompanyController::class, 'geographic'])->name('geographic');
        Route::get('/metrics', [CompanyController::class, 'metrics'])->name('metrics');
        Route::get('/report', [CompanyController::class, 'report'])->name('report');
        Route::get('/shareholders', [CompanyController::class, 'shareholders'])->name('shareholders');
        Route::get('/summary', [CompanyController::class, 'summary'])->name('summary');
        Route::get('/filings', [CompanyController::class, 'filings'])->name('filings');
        Route::get('/insider', [CompanyController::class, 'insider'])->name('insider');
        Route::get('/restatement', [CompanyController::class, 'restatement'])->name('restatement');
        Route::get('/employee', [CompanyController::class, 'employee'])->name('employee');
        Route::get('/fail-to-deliver', [CompanyController::class, 'failToDeliver'])->name('fail.to.deliver');
        Route::get('/analysis', [CompanyController::class, 'analysis'])->name('analysis');
    });

    Route::get('/company/{ticker}/ownership/{start?}', [CompanyController::class, 'ownership'])->name('company.ownership');

    Route::get('/legacy/fund/{cik}/', [FundController::class, 'summary'])->name('fund.summary');
    Route::get('/fund/{cik}/holdings', [FundController::class, 'holdings'])->name('fund.holdings');
    Route::get('/fund/{cik}/metrics', [FundController::class, 'metrics'])->name('fund.metrics');
    Route::get('/fund/{ticker}/filings', [FundController::class, 'filings'])->name('fund.filings');
    Route::get('/fund/{ticker}/insider', [FundController::class, 'insider'])->name('fund.insider');
    Route::get('/fund/{ticker}/restatement', [FundController::class, 'restatement'])->name('fund.restatement');

    // if company is supplied in url, it will show history of fund for that company otherwise it will show history of fund for all companies
    Route::get('/fund/{fund}/{company?}', [CompanyController::class, 'fund'])->name('company.fund');
    Route::get('/mutual-fund/{cik}/{fund_symbol}/{series_id}/{class_id}/{class_name}{company?}', [CompanyController::class, 'mutualFund'])->name('company.mutual-fund');

    Route::get('builder/chart', [BuilderController::class, 'chart'])->name('builder.chart');
    Route::get('builder/table', [BuilderController::class, 'table'])->name('builder.table');

    Route::get('/legacy/mutual-fund/{cik}/{fund_symbol}/{series_id}/{class_id}/', [MutualFundController::class, 'holdings'])->name('mutual-fund.holdings');
    Route::get('/legacy/mutual-fund/{cik}/{fund_symbol}/{series_id}/{class_id}/returns', [MutualFundController::class, 'returns'])->name('mutual-fund.returns');

    Route::get('/etf/{cik}/{etf_symbol}', [EtfController::class, 'holdings'])->name('etf.holdings');

    Route::get('/euronext/{ticker}/', [EuronextController::class, 'metrics'])->name('euronext.metrics');
    Route::get('/euronext/{ticker}/profile', [EuronextController::class, 'profile'])->name('euronext.profile');
    Route::get('/euronext/{ticker}/filings', [EuronextController::class, 'filings'])->name('euronext.filings');

    Route::get('/lse/{ticker}/', [LseController::class, 'metrics'])->name('lse.metrics');
    Route::get('/lse/{ticker}/profile', [LseController::class, 'profile'])->name('lse.profile');
    Route::get('/lse/{ticker}/filings', [LseController::class, 'filings'])->name('lse.filings');

    Route::get('/tsx/{ticker}/', [TsxController::class, 'metrics'])->name('tsx.metrics');
    Route::get('/tsx/{ticker}/profile', [TsxController::class, 'profile'])->name('tsx.profile');
    Route::get('/tsx/{ticker}/filings', [TsxController::class, 'filings'])->name('tsx.filings');

    Route::get('/shanghai/{ticker}/', [ShanghaiController::class, 'metrics'])->name('shanghai.metrics');
    Route::get('/shanghai/{ticker}/profile', [ShanghaiController::class, 'profile'])->name('shanghai.profile');
    Route::get('/shanghai/{ticker}/filings', [ShanghaiController::class, 'filings'])->name('shanghai.filings');

    Route::get('/japan/{ticker}/', [JapanController::class, 'metrics'])->name('japan.metrics');
    Route::get('/japan/{ticker}/profile', [JapanController::class, 'profile'])->name('japan.profile');
    Route::get('/japan/{ticker}/filings', [JapanController::class, 'filings'])->name('japan.filings');

    Route::get('/hkex/{ticker}/', [HkexController::class, 'metrics'])->name('hkex.metrics');
    Route::get('/hkex/{ticker}/profile', [HkexController::class, 'profile'])->name('hkex.profile');
    Route::get('/hkex/{ticker}/filings', [HkexController::class, 'filings'])->name('hkex.filings');

    Route::get('/otc/{ticker}/', [OtcController::class, 'metrics'])->name('otc.metrics');
    Route::get('/otc/{ticker}/profile', [OtcController::class, 'profile'])->name('otc.profile');
    Route::get('/otc/{ticker}/filings', [OtcController::class, 'filings'])->name('otc.filings');

    Route::get('/frankfurt/{ticker}/', [FrankfurtController::class, 'metrics'])->name('frankfurt.metrics');
    Route::get('/frankfurt/{ticker}/profile', [FrankfurtController::class, 'profile'])->name('frankfurt.profile');
    Route::get('/frankfurt/{ticker}/filings', [FrankfurtController::class, 'filings'])->name('frankfurt.filings');

    Route::get('/shenzhen/{ticker}/', [ShenzhenController::class, 'metrics'])->name('shenzhen.metrics');

    Route::post('settings', UpdateSettingsController::class)->name('settings.update');

    Route::post('chart-builder/{chart}/update', [ChartController::class, 'update'])->name('chart-builder.update');
});

Route::group(['middleware' => ['auth', 'verified', EnsureUserIsAdmin::class]], function () {
    Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users');
    Route::get('/admin/permission', [AdminController::class, 'permission'])->name('admin.permission-management');
    Route::get('/admin/groups', [AdminController::class, 'groups'])->name('admin.groups-management');
    Route::get('/admin/feedbacks', [AdminController::class, 'feedbacks'])->name('admin.feedbacks-management');
    Route::get('/admin/cache', [AdminController::class, 'cache'])->name('admin.cache-management');
});

Route::view('/waiting-for-approval', 'waiting-for-approval')
    ->name('waiting-for-approval')
    ->middleware(['auth', CustomEmailVerificationPrompt::class]);

Route::group(['middleware' => ['guest']], function () {
    Route::redirect('register', '/')->name('register');

    Route::get('/reset-password-successful', ResetPasswordSuccessfulController::class)->name('password.reset.successful');

    Route::get('/reset-link-sent', ResetLinkSentController::class)->name('password.reset-link.sent');

    Route::redirect('/waitlist', '/')->name('waitlist.join');
});

// override fortify route to verify user without needing to login
Route::get(RoutePath::for('verification.verify', '/email/verify/{id}/{hash}'), VerifyEmailController::class)
    ->middleware(['signed', 'throttle:' . config('fortify.limiters.verification', '6,1')])
    ->name('verification.verify');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::post('ping', fn () => response('OK'))->name('refresh-csrf');
