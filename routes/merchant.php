<?php

use App\Http\Middleware\HandleMerchantRole;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Merchant\TransactionsController;

//Route::middleware(['auth', HandleMerchantRole::class])->group(function () {
//    Route::resource('transactions', TransactionsController::class);
//})->prefix('merchant')->as('merchant.');


Route::middleware('auth')->group(function () {
    Route::group([
        'middleware' => HandleMerchantRole::class,
        'prefix' => 'merchant',
        'as' => 'merchant.',
    ], function () {
        Route::resource('transactions', TransactionsController::class);
    });
});
