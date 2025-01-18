<?php

use App\Http\Middleware\HandleMerchantRole;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Merchant\TransactionsController;
use App\Http\Controllers\Merchant\WalletController;

Route::middleware('auth')->group(function () {
    Route::group([
        'middleware' => HandleMerchantRole::class,
        'prefix' => 'merchant',
        'as' => 'merchant.',
    ], function () {
        Route::get('transactions', TransactionsController::class)->name('transactions');
        Route::get('money/add', [WalletController::class, 'addMoney'])->name('money.add');
        Route::post('money/store', [WalletController::class, 'storeMoney'])->name('money.store');
        Route::get('money/send', [WalletController::class, 'sendMoney'])->name('money.send');
        Route::post('money/transfer', [WalletController::class, 'transferMoney'])->name('money.transfer');
    });
});
