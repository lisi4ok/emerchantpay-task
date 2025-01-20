<?php

namespace App\Events;

use App\Enums\OrderStatusEnum;
use App\Enums\RoleEnum;
use App\Http\Requests\AddMoneyRequest;
use App\Models\Order;
use App\Models\User;
use App\Notifications\OrderCreatedNotification;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Events\ShouldDispatchAfterCommit;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;
use App\Events\SendOrderCreatedMessage;

class AddMoneyByCreateOrder implements ShouldDispatchAfterCommit
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public float $amount,
        public int $userId,
        public AddMoneyRequest $request,
    ) {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $status = OrderStatusEnum::PENDING_PAYMENT->value;
        $order = Order::create([
            'amount' => $amount,
            'user_id' => $userId,
            'status' => $status,
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        $users = User::where('role', RoleEnum::ADMINISTRATOR->value)->get();
        Notification::send($users, new OrderCreatedNotification($order));
        event(new SendOrderCreatedMessage('You have new Order to approve'));
    }
}
