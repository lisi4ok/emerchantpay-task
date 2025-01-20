<?php

namespace App\Events;

use App\Enums\OrderStatusEnum;
use App\Http\Requests\AddMoneyRequest;
use App\Models\Order;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Events\ShouldDispatchAfterCommit;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AddMoneyByCreateOrder implements ShouldDispatchAfterCommit
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

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
        Order::create([
            'amount' => $amount,
            'user_id' => $userId,
            'status' => $status,
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);
    }
}
