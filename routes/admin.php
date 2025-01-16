<?php

use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UserController;
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
        Route::resource('users', UserController::class);
        Route::resource('roles', RolesController::class);
        Route::resource('transactions', TransactionsController::class);
        Route::resource('orders', OrdersController::class);
    });
});
