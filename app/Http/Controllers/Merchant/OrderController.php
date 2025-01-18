<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Order;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function __invoke()
    {
        $orders = $this->filter(Order::class, [], ['name', 'email']);

        return Inertia::render('Admin/Orders/Index', [
            'orders' => UserResource::collection($orders),
            'queryParams' => request()->query() ?: null,
        ]);
    }
}
