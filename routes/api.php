<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(CustomerController::class)
    ->prefix('customer')
    ->name('customer.')
    ->group(function () {
        Route::post('/register', 'register')->name('register');
        Route::post('/login', 'login')->name('login');
    });


Route::controller(AccountController::class)
    ->middleware('auth:sanctum')
    ->prefix('account')
    ->name('account.')
    ->group(function () {
        Route::post('/open', 'open')->name('open');
        Route::post('/money-transfer', 'moneyTransfer')->name('money-transfer');
        Route::get('{account}/balance', 'balance')->name('balance');
    });


Route::controller(TransactionController::class)
    ->middleware('auth:sanctum')
    ->prefix('transaction')
    ->name('transaction.')
    ->group(function () {
        Route::get('{account}/history', 'history')->name('history');
    });
