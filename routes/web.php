<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;

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

Route::get('/company/{ticker}', [CompanyController::class, 'show'])->name('company.show');
Route::get('/company/{ticker}/product', [CompanyController::class, 'product'])->name('company.product');
Route::get('/company/{ticker}/calcbench', [CompanyController::class, 'calcbench'])->name('company.calcbench');
Route::get('/company/{ticker}/report', [CompanyController::class, 'report'])->name('company.report');
Route::get('/company/{ticker}/periods', [CompanyController::class, 'periods'])->name('company.periods');
Route::get('/company/{ticker}/sc2', [CompanyController::class, 'sc2'])->name('company.sc2');
Route::get('/company/{ticker}/sc3', [CompanyController::class, 'sc3'])->name('company.sc3');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
