<?php

namespace App\Http\Controllers\Merchant;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class WalletController extends Controller
{
    public function addMoney()
    {
        return Inertia::render('Merchant/AddMoney', [
            'users' => UserResource::collection(User::where('role', '!=', RoleEnum::ADMINISTRATOR->value)->get()),
        ]);
    }

    public function transferMoney()
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
