<?php

namespace App\Services;

use App\Enums\MoneyTypeEnum;
use App\Enums\TransactionTypeEnum;
use App\Http\Requests\AddMoneyRequest;
use App\Interfaces\WalletServiceInterface;
use App\Events\AddMoneyByCreateOrder;
use Exception;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class WalletService implements WalletServiceInterface
{
    public function addMoney(float $amount, int $userId, AddMoneyRequest $request): bool
    {
        switch ($request->type) {
            case MoneyTypeEnum::ORDER->value:
                AddMoneyByCreateOrder::dispatch($amount, $userId, $request);
                break;
            case MoneyTypeEnum::CARD->value:
                throw new Exception('not supported');
                break;
            case MoneyTypeEnum::BANK->value:
                throw new Exception('not supported');
                break;
            case MoneyTypeEnum::CASH->value:
                throw new Exception('not supported');
                break;
        }

        return true;
    }

    public function transferMoney(float $amount, User $from, User $to): bool
    {
        if ($from->amount < $amount) {
            throw new \Exception('Not enough money');
        }

        try {
            DB::transaction(function () use ($amount, $from, $to) {
                Transaction::create([
                    'amount' => $amount,
                    'type' => TransactionTypeEnum::CREDIT->value,
                    'user_id' => $to->id,
                    'description' => 'Received fund from #email: ' . $from->email,
                    'created_by' => $from->id,
                ]);

                Transaction::create([
                    'amount' => $amount,
                    'type' => TransactionTypeEnum::DEBIT->value,
                    'user_id' => $from->id,
                    'description' => 'Transferred fund to #email: ' . $to->email,
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
