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

Route::get('/company/{ticker}/', [CompanyController::class, 'product'])->name('company.product');
Route::get('/company/{ticker}/geographic', [CompanyController::class, 'geographic'])->name('company.geographic');
Route::get('/company/{ticker}/metrics', [CompanyController::class, 'metrics'])->name('company.metrics');
Route::get('/company/{ticker}/report', [CompanyController::class, 'report'])->name('company.report');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
