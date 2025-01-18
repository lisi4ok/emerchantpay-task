<?php

namespace App\Http\Controllers\Merchant;

use App\Enums\TransactionTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TransactionsController extends Controller
{
    public function __invoke()
    {
        $transactions = $this->filter(
            Transaction::class,
            ['type'],
            ['amount'],
            ['user_id' => Auth::user()->id],
            ['user', 'createdBy']
        );

        return Inertia::render('Merchant/Transactions', [
            'transactions' => TransactionResource::collection($transactions),
            'transactionsTypes' => array_flip(TransactionTypeEnum::array()),
            'queryParams' => request()->query() ?: null,
        ]);
    }
}
