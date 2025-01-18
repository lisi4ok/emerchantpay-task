<?php

namespace App\Observers;

use App\Enums\TransactionTypeEnum;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionObserver
{
    public function saving(Transaction $transaction)
    {
        if (Auth::user()) {
            $transaction->created_by = Auth::user()->id;
        }
    }

    public function creating(Transaction $transaction)
    {
        echo '<pre>';
        var_dump($transaction->type === TransactionTypeEnum::DEBIT->value);
        var_dump($transaction->type);
        exit;

        if ($transaction->type === TransactionTypeEnum::CREDIT->value) {
            $transaction->user()->update([
                'amount' => $transaction->user->amount + $transaction->amount,
            ]);
        } elseif ($transaction->type === TransactionTypeEnum::DEBIT->value)  {
            if ($transaction->amount > $transaction->user->amount) {
                throw new \Exception('User: not enough fund');
            }
            $transaction->user()->update([
                'amount' => $transaction->user->amount - $transaction->amount,
            ]);
        }
    }
}
