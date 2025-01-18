<?php

namespace App\Services;

use App\Enums\OrderStatusEnum;
use App\Enums\TransactionTypeEnum;
use App\Interfaces\WalletServiceInterface;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class WalletService implements WalletServiceInterface
{
    public function addMoney(float $amount, int $userId, string $title, ?string $description = null): bool
    {
        try {
            DB::transaction(function () use ($amount, $userId, $title, $description) {
                Order::create([
                    'amount' => $amount,
                    'user_id' => $userId,
                    'status' => $status,
                    'title' => $title,
                    'description' => $description,
                ]);
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
                if ($from->amount < $amount) {
                    throw new \Exception('Not enough money');
                }

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

                $from->update(['amount' => $from->amount - $amount]);
                $to->update(['amount' => $to->amount + $amount]);

            });
        } catch (\Throwable $exception) {
            throw $exception;
        }

        return true;
    }
}
