<?php

namespace App\Providers;

// use Illuminate\Support\ServiceProvider;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Order;
use App\Observers\UserObserver;
use App\Observers\TransactionObserver;
use App\Observers\OrderObserver;
use Illuminate\Events\EventServiceProvider as ServiceProvider;


class EventServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        User::observe(UserObserver::class);
        Transaction::observe(TransactionObserver::class);
        Order::observe(OrderObserver::class);
    }
}
