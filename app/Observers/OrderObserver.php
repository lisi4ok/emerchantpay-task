<?php

namespace App\Observers;

use App\Enums\OrderStatusEnum;
use App\Enums\TransactionTypeEnum;
use App\Models\Order;
use App\Models\Transaction;

class OrderObserver
{
    public function updating(Order $order): void
    {
        $type = null;
        if ($order->status == OrderStatusEnum::COMPLETED->value) {
            $type = TransactionTypeEnum::CREDIT->value;
        } elseif ($order->status == OrderStatusEnum::REFUNDED)  {
            if ($order->amount > $order->user->amount) {
                throw new \Exception('User: not enough fund');
            }

            $type = TransactionTypeEnum::DEBIT->value;
        }

        if ($type === null) {
            return;
        }

        $transaction = Transaction::create([
            'user_id' => $order->user->id,
            'amount' => (float) $order->amount,
            'type' => $type,
            'description' => 'Purchased funds #order_id: ' . $order->id,
        ]);

        $order->description = 'Payment funds #transaction_id: ' . $transaction->id . PHP_EOL . $order->description;
    }
}
