<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class OrdersController extends Controller
{
    public function index()
    {
        $orders = $this->filter(
            model: Order::class,
            fields: ['status'],
            fieldsLike: ['amount', 'title'],
            with: ['user']
        );

        return Inertia::render('Admin/Orders/Index', [
            'orders' => OrderResource::collection($orders),
            'statuses' => array_flip(OrderStatusEnum::array()),
            'pendingPaymentStatus' => OrderStatusEnum::PENDING_PAYMENT->name,
            'queryParams' => request()->query() ?: null,
        ]);
    }

    public function edit(int $id)
    {
        $order = Order::with('user')->findOrFail($id);

        return Inertia::render('Admin/Orders/Edit', [
            'order' => $order,
            'statuses' => array_flip(OrderStatusEnum::array()),
            'orderStatus' => array_flip(OrderStatusEnum::array())[$order->status],
        ]);
    }

    public function update(UpdateOrderRequest $request, int $id)
    {
        $order = Order::findOrFail($id);

        try {
            DB::transaction(function () use ($order, $request) {
                $order->update($request->validated());
            });
        } catch (\Throwable $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }

        return redirect()->route('admin.orders.index')->with('success', 'Order updated');
    }
}
