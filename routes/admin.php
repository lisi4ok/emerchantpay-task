<?php

use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\TransactionsController;
use App\Http\Controllers\Admin\OrdersController;
use App\Http\Middleware\HandleAdminRole;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::group([
        'middleware' => HandleAdminRole::class,
        'prefix' => 'admin',
        'as' => 'admin.',
    ], function () {
        Route::resource('users', UsersController::class);
        Route::resource('roles', RolesController::class);

        Route::get('transactions', [TransactionsController::class, 'index'])->name('transactions');
        Route::get('add', [TransactionsController::class, 'addView'])->name('transactions.addView');
        Route::post('add', [TransactionsController::class, 'add'])->name('transactions.add');
        Route::get('decrease', [TransactionsController::class, 'addView'])->name('transactions.decreaseView');
        Route::post('decrease', [TransactionsController::class, 'decrease'])->name('transactions.decrease');

        Route::resource('orders', OrdersController::class)
            ->only(['index', 'edit', 'update']);
    });
});
