<?php

use App\Http\Livewire\Lses;
use App\Http\Livewire\Otcs;
use App\Http\Livewire\Tsxs;
use App\Http\Livewire\Hkexs;
use App\Http\Livewire\Japans;
use Laravel\Fortify\RoutePath;
use App\Http\Livewire\Euronexts;
use App\Http\Livewire\Shanghais;
use App\Http\Livewire\Delistings;
use App\Http\Livewire\ReviewPage;
use App\Http\Livewire\PressRelease;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\EconomicRelease;
use App\Http\Livewire\FundFilingsPage;
use App\Http\Controllers\LseController;
use App\Http\Controllers\OtcController;
use App\Http\Controllers\TsxController;
use App\Http\Livewire\EarningsCalendar;
use App\Http\Livewire\PermissionDenied;
use App\Http\Controllers\FundController;
use App\Http\Controllers\HkexController;
use App\Http\Livewire\EconomicsCalendar;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\JapanController;
use App\Http\Livewire\CompanyFilingsPage;
use App\Http\Livewire\CompanyIdentifiers;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EuronextController;
use App\Http\Controllers\FrankfurtController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShanghaiController;
use App\Http\Livewire\EconomicReleaseSeries;
use App\Http\Livewire\MutualFundFilingsPage;
use App\Http\Controllers\MutualFundController;
use App\Http\Controllers\ResetLinkSentController;
use App\Http\Controllers\ResetPasswordSuccessfulController;
use App\Http\Controllers\VerifyEmailController;
use App\Http\Livewire\Frankfurts;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

Route::get('/permission-denied', PermissionDenied::class)->name('permission-denied');

Route::get('/', HomeController::class)->name('home');

Route::middleware([])->group(function () {
    Route::middleware(['auth', 'approved', 'verified', 'checkPagePermission'])->group(function () {
        Route::get('/calendar/earnings', EarningsCalendar::class)->name('earnings-calendar');
        Route::get('/calendar/economics', EconomicsCalendar::class)->name('economics-calendar');
        Route::get('/calendar/economics/{release_id}/', EconomicRelease::class)->name('economics-release');
        Route::get('/calendar/economics/{release_id}/{series_id}/', EconomicReleaseSeries::class)->name('economics-release-series');
        Route::get('/company-filings', CompanyFilingsPage::class)->name('company-filings');
        Route::get('/fund-filings', FundFilingsPage::class)->name('fund-filings');
        Route::get('/mutual-fund-filings', MutualFundFilingsPage::class)->name('mutual-fund-filings');
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
        Route::get('/review', ReviewPage::class)->name('review');
        Route::get('/press-release', PressRelease::class)->name('press.release');

        Route::get('/company/{ticker}/', [CompanyController::class, 'product'])->name('company.product');
        Route::get('/company/{ticker}/profile', [CompanyController::class, 'profile'])->name('company.profile');
        Route::get('/company/{ticker}/executive-compensation', [CompanyController::class, 'executiveCompensation'])->name('company.executive.compensation');
        Route::get('/company/{ticker}/chart', [CompanyController::class, 'chart'])->name('company.chart');
        Route::get('/company/{ticker}/splits', [CompanyController::class, 'splits'])->name('company.splits');
        Route::get('/company/{ticker}/geographic', [CompanyController::class, 'geographic'])->name('company.geographic');
        Route::get('/company/{ticker}/metrics', [CompanyController::class, 'metrics'])->name('company.metrics');
        Route::get('/company/{ticker}/report', [CompanyController::class, 'report'])->name('company.report');
        Route::get('/company/{ticker}/shareholders', [CompanyController::class, 'shareholders'])->name('company.shareholders');
        Route::get('/company/{ticker}/summary', [CompanyController::class, 'summary'])->name('company.summary');
        Route::get('/company/{ticker}/filings', [CompanyController::class, 'filings'])->name('company.filings');
        Route::get('/company/{ticker}/insider', [CompanyController::class, 'insider'])->name('company.insider');
        Route::get('/company/{ticker}/restatement', [CompanyController::class, 'restatement'])->name('company.restatement');
        Route::get('/company/{ticker}/employee', [CompanyController::class, 'employee'])->name('company.employee');
        Route::get('/company/{ticker}/fail-to-deliver', [CompanyController::class, 'failToDeliver'])->name('company.fail.to.deliver');

        Route::get('/fund/{cik}/', [FundController::class, 'summary'])->name('fund.summary');
        Route::get('/fund/{cik}/holdings', [FundController::class, 'holdings'])->name('fund.holdings');
        Route::get('/fund/{cik}/metrics', [FundController::class, 'metrics'])->name('fund.metrics');
        Route::get('/fund/{ticker}/filings', [FundController::class, 'filings'])->name('fund.filings');
        Route::get('/fund/{ticker}/insider', [FundController::class, 'insider'])->name('fund.insider');
        Route::get('/fund/{ticker}/restatement', [FundController::class, 'restatement'])->name('fund.restatement');

        Route::get('/mutual-fund/{cik}/{fund_symbol}/{series_id}/{class_id}/', [MutualFundController::class, 'holdings'])->name('mutual-fund.holdings');
        Route::get('/mutual-fund/{cik}/{fund_symbol}/{series_id}/{class_id}/returns', [MutualFundController::class, 'returns'])->name('mutual-fund.returns');

        Route::get('/euronext/{ticker}/', [EuronextController::class, 'metrics'])->name('euronext.metrics');
        Route::get('/euronext/{ticker}/filings', [EuronextController::class, 'filings'])->name('euronext.filings');

        Route::get('/lse/{ticker}/', [LseController::class, 'metrics'])->name('lse.metrics');
        Route::get('/lse/{ticker}/filings', [LseController::class, 'filings'])->name('lse.filings');

        Route::get('/tsx/{ticker}/', [TsxController::class, 'metrics'])->name('tsx.metrics');
        Route::get('/tsx/{ticker}/filings', [TsxController::class, 'filings'])->name('tsx.filings');

        Route::get('/shanghai/{ticker}/', [ShanghaiController::class, 'metrics'])->name('shanghai.metrics');
        Route::get('/shanghai/{ticker}/filings', [ShanghaiController::class, 'filings'])->name('shanghai.filings');

        Route::get('/japan/{ticker}/', [JapanController::class, 'metrics'])->name('japan.metrics');
        Route::get('/japan/{ticker}/filings', [JapanController::class, 'filings'])->name('japan.filings');

        Route::get('/hkex/{ticker}/', [HkexController::class, 'metrics'])->name('hkex.metrics');
        Route::get('/hkex/{ticker}/filings', [HkexController::class, 'filings'])->name('hkex.filings');

        Route::get('/otc/{ticker}/', [OtcController::class, 'metrics'])->name('otc.metrics');
        Route::get('/otc/{ticker}/filings', [OtcController::class, 'filings'])->name('otc.filings');

        Route::get('/frankfurt/{ticker}/', [FrankfurtController::class, 'metrics'])->name('frankfurt.metrics');
        Route::get('/frankfurt/{ticker}/filings', [FrankfurtController::class, 'filings'])->name('frankfurt.filings');
    });
});

Route::middleware(['auth', 'verified', 'ensureUserIsApproved'])->group(function () {
    Route::middleware(['auth:sanctum', config('jetstream.auth_session')])->group(function () {
        Route::get('/dashboard', function () {
            return view('welcome');
        })->name('dashboard');
    });

    Route::middleware(['auth:sanctum', 'verified', 'ensureUserIsAdmin'])->group(function () {
        Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users');
    });

    Route::middleware(['auth:sanctum', 'verified', 'ensureUserIsAdmin'])->group(function () {
        Route::get('/admin/permission', [AdminController::class, 'permission'])->name('admin.permission-management');
    });

    Route::middleware(['auth:sanctum', 'verified', 'ensureUserIsAdmin'])->group(function () {
        Route::get('/admin/groups', [AdminController::class, 'groups'])->name('admin.groups-management');
    });
});

Route::middleware(['auth', 'custom.email.verification'])->group(function () {
    Route::get('/waiting-for-approval', function () {
        return view('waiting-for-approval');
    })->name('waiting-for-approval');
});

Route::middleware(['guest'])->group(function () {
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