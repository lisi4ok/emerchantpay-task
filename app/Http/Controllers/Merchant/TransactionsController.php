<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TransactionsController extends Controller
{
    public function index()
    {
        $transactions = $this->filter(
            Transaction::class,
            [],
            ['name', 'type', 'amount'],
            ['user_id' => Auth::user()->id],
        );

        return Inertia::render('Merchant/Transactions/Index', [
            'transactions' => TransactionResource::collection($transactions),
            'queryParams' => request()->query() ?: null,
            'success' => session('success'),
        ]);
    }
}
