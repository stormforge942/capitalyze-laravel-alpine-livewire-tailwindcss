<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\FundController;
use App\Http\Livewire\EarningsCalendar;

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
    return view('welcome');
})->name('home');

/*
| Global routes
*/
Route::get('/calendar', EarningsCalendar::class)->name('earnings-calendar');

/*
| Company routing
*/
Route::get('/company/{ticker}/', [CompanyController::class, 'product'])->name('company.product');
Route::get('/company/{ticker}/geographic', [CompanyController::class, 'geographic'])->name('company.geographic');
Route::get('/company/{ticker}/metrics', [CompanyController::class, 'metrics'])->name('company.metrics');
Route::get('/company/{ticker}/report', [CompanyController::class, 'report'])->name('company.report');
Route::get('/company/{ticker}/shareholders', [CompanyController::class, 'shareholders'])->name('company.shareholders');
Route::get('/company/{ticker}/summary', [CompanyController::class, 'summary'])->name('company.summary');
Route::get('/company/{ticker}/filings', [CompanyController::class, 'filings'])->name('company.filings');
Route::get('/company/{ticker}/insider', [CompanyController::class, 'insider'])->name('company.insider');
Route::get('/company/{ticker}/restatement', [CompanyController::class, 'restatement'])->name('company.restatement');

/*
| Fund routing
*/

Route::get('/fund/{cik}/', [FundController::class, 'summary'])->name('fund.summary');
Route::get('/fund/{cik}/holdings', [FundController::class, 'holdings'])->name('fund.holdings');
Route::get('/fund/{cik}/metrics', [FundController::class, 'metrics'])->name('fund.metrics');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
