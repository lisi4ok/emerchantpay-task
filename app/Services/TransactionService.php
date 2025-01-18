<?php

namespace App\Services;

use App\Enums\OrderStatusEnum;
use App\Enums\TransactionTypeEnum;
use App\Interfaces\WalletServiceInterface;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TransactionService //implements WalletServiceInterface
{
    public function addMoney(float $amount, string $title, ?string $description = null): bool
    {
        try {
            DB::transaction(function () use ($amount, $title, $description) {
                $status = OrderStatusEnum::PENDING_PAYMENT->value;
                Order::create(compact('amount', 'title', 'description', 'status'));
            });
        } catch (\Throwable $exception) {
            throw new $exception;
        }

        return true;

    }

    public function transferMoney(float $amount, User $from, User $to): bool
    {
        try {
            DB::transaction(function () use ($amount, $from, $to) {
                Transaction::create([
                    'amount' => $amount,
                    'type' => TransactionTypeEnum::CREDIT->value,
                    'user_id' => $to->id,
                    'description' => 'Received fund from ' . $from->email,
                    'created_by' => $from->id,
                ]);

                Transaction::create([
                    'amount' => $amount,
                    'type' => TransactionTypeEnum::DEBIT->value,
                    'user_id' => $from->id,
                    'description' => 'Transferred fund to ' . $to->email,
                ]);

                $from->update([
                   'amount' => $from->amount - $amount,
                ]);
                $to->update([
                    'amount' => $from->amount + $amount,
                ]);

            });
        } catch (\Throwable $exception) {
            throw $exception;
        }

        return true;
    }
}
