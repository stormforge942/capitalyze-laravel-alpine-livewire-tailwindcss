<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\LseController;
use App\Http\Controllers\EuronextController;
use App\Http\Controllers\ShanghaiController;
use App\Http\Controllers\FundController;
use App\Http\Controllers\JapanController;
use App\Http\Livewire\CompanyFilingsPage;
use App\Http\Livewire\FundFilingsPage;
use App\Http\Livewire\CompanyIdentifiers;
use App\Http\Livewire\Delistings;
use App\Http\Livewire\Euronexts;
use App\Http\Livewire\Lses;
use App\Http\Livewire\Shanghais;
use App\Http\Livewire\Japans;
use App\Http\Livewire\PressRelease;
use App\Http\Livewire\EarningsCalendar;
use App\Http\Livewire\EconomicsCalendar;
use App\Http\Livewire\EconomicRelease;
use App\Http\Livewire\EconomicReleaseSeries;
use App\Http\Controllers\AdminController;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if (auth()->check() && (auth()->user()->is_approved == false || !auth()->user()->hasVerifiedEmail())) {
        return redirect()->route('waiting-for-approval');
    }

    return view('welcome');
})->name('home');


Route::middleware(['auth', 'approved', 'verified'])->group(function () {
    /*
    | Global routes
    */
    Route::get('/calendar/earnings', EarningsCalendar::class)->name('earnings-calendar');
    Route::get('/calendar/economics', EconomicsCalendar::class)->name('economics-calendar');
    Route::get('/calendar/economics/{release_id}/', EconomicRelease::class)->name('economics-release');
    Route::get('/calendar/economics/{release_id}/{series_id}/', EconomicReleaseSeries::class)->name('economics-release-series');
    Route::get('/company-filings', CompanyFilingsPage::class)->name('company-filings');
    Route::get('/fund-filings', FundFilingsPage::class)->name('fund-filings');
    Route::get('/identifiers', CompanyIdentifiers::class)->name('company-identifiers');
    Route::get('/delistings', Delistings::class)->name('delistings');
    Route::get('/euronext', Euronexts::class)->name('euronexts');
    Route::get('/lse', Lses::class)->name('lses');
    Route::get('/shanghai', Shanghais::class)->name('shanghais');
    Route::get('/japan', Japans::class)->name('japans');
    Route::get('/press-release', PressRelease::class)->name('press.release');

    /*
    | Company routing
    */
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

    /*
    | Fund routing
    */
    Route::get('/fund/{cik}/', [FundController::class, 'summary'])->name('fund.summary');
    Route::get('/fund/{cik}/holdings', [FundController::class, 'holdings'])->name('fund.holdings');
    Route::get('/fund/{cik}/metrics', [FundController::class, 'metrics'])->name('fund.metrics');
    Route::get('/fund/{ticker}/filings', [FundController::class, 'filings'])->name('fund.filings');
    Route::get('/fund/{ticker}/insider', [FundController::class, 'insider'])->name('fund.insider');
    Route::get('/fund/{ticker}/restatement', [FundController::class, 'restatement'])->name('fund.restatement');

    /*
    | Euronext routing
    */
    Route::get('/euronext/{ticker}/', [EuronextController::class, 'metrics'])->name('euronext.metrics');
    Route::get('/euronext/{ticker}/filings', [EuronextController::class, 'filings'])->name('euronext.filings');

    /*
    | Lse routing
    */
    Route::get('/lse/{ticker}/', [LseController::class, 'metrics'])->name('lse.metrics');
    Route::get('/lse/{ticker}/filings', [LseController::class, 'filings'])->name('lse.filings');

    /*
    | Shanghai routing
    */
    Route::get('/shanghai/{ticker}/', [ShanghaiController::class, 'metrics'])->name('shanghai.metrics');
    Route::get('/shanghai/{ticker}/filings', [ShanghaiController::class, 'filings'])->name('shanghai.filings');

    /*
    | Lse routing
    */
    Route::get('/japan/{ticker}/', [JapanController::class, 'metrics'])->name('japan.metrics');
    Route::get('/japan/{ticker}/filings', [JapanController::class, 'filings'])->name('japan.filings');
});

Route::middleware(['auth', 'verified', 'ensureUserIsApproved'])->group(function () {
    Route::middleware(['auth:sanctum', config('jetstream.auth_session')])->group(function () {
        Route::get('/dashboard', function () {
            return view('welcome');
        })->name('dashboard');
    });

    Route::middleware(['auth:sanctum', 'verified', 'ensureUserIsAdmin'])->group(function () {
        Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users');
        // You can add more routes here that should be subject to the same middleware
    });
});

Route::middleware(['auth', 'custom.email.verification'])->group(function () {
    Route::get('/waiting-for-approval', function () {
        return view('waiting-for-approval');
    })->name('waiting-for-approval');
});

// Routes for guests
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

// Logout route accessible to all users
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
