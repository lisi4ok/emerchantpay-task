<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatusEnum;
use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreOrderRequest;
use App\Http\Requests\Admin\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class OrdersController extends Controller
{
    public function index()
    {
        $orders = $this->filter(Order::class);

        return Inertia::render('Admin/Orders/Index', [
            'orders' => OrderResource::collection($orders),
            'statuses' => array_flip(OrderStatusEnum::array()),
            'queryParams' => request()->query() ?: null,
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Orders/Create', [
            'users' => User::where('role', '!=', RoleEnum::ADMINISTRATOR->value)->get(),
            'statuses' => array_flip(OrderStatusEnum::array()),
        ]);
    }

    public function store(StoreOrderRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                Order::create($request->validated());
            });
        } catch (\Throwable $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }

        return redirect()->route('admin.orders.index')->with('success', 'Order created');
    }

    public function show(int $id)
    {
        $order = Order::with('user')->findOrFail($id);

        return Inertia::render('Admin/Orders/Show', [
            'order' => $order,
        ]);
    }

    public function edit(int $id)
    {
        $order = Order::findOrFail($id);

        return Inertia::render('Admin/Orders/Edit', [
            'order' => $order,
            'users' => User::where('role', '!=', RoleEnum::ADMINISTRATOR->value)->get(),
            'statuses' => array_flip(OrderStatusEnum::array()),
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

    public function destroy($id)
    {
        Order::findOrFail($id)->delete();

        return redirect()->route('admin.orders.index')->with('success', 'User deleted');
    }
}
