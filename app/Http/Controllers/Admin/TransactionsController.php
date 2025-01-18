<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatusEnum;
use App\Enums\RoleEnum;
use App\Enums\TransactionTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreOrderRequest;
use App\Http\Requests\Admin\StoreTransactionRequest;
use App\Http\Requests\Admin\UpdateOrderRequest;
use App\Http\Requests\Admin\UpdateTransactionRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\TransactionResource;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class TransactionsController extends Controller
{
    public function index()
    {
        $transactions = $this->filter(
            Transaction::class,
            ['type'],
            ['amount'],
            [],
            ['user', 'createdBy']
        );

        return Inertia::render('Admin/Transactions/Index', [
            'transactions' => TransactionResource::collection($transactions),
            'types' => array_flip(TransactionTypeEnum::array()),
            'queryParams' => request()->query() ?: null,
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Transactions/Create', [
            'users' => User::where('role', '!=', RoleEnum::ADMINISTRATOR->value)->get(),
            'types' => array_flip(TransactionTypeEnum::array()),
        ]);
    }

    public function store(StoreTransactionRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $transaction = Transaction::create($request->validated());
                $this->updateTransactionUser($transaction);
            });
        } catch (\Throwable $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }

        return redirect()->route('admin.transactions.index')->with('success', 'Transaction created');
    }

    public function show(int $id)
    {
        $transaction = Transaction::with('user')->findOrFail($id);

        return Inertia::render('Admin/Transactions/Show', [
            'transaction' => $transaction,
        ]);
    }

    public function edit(int $id)
    {
        $transaction = Transaction::with('user')->findOrFail($id);

        return Inertia::render('Admin/Transactions/Edit', [
            'transaction' => $transaction,
            'users' => User::where('role', '!=', RoleEnum::ADMINISTRATOR->value)->get(),
            'types' => array_flip(TransactionTypeEnum::array()),
        ]);
    }

    public function update(UpdateTransactionRequest $request, int $id)
    {
        $transaction = Transaction::with('user')->findOrFail($id);
        try {
            DB::transaction(function () use ($transaction, $request) {
                $transaction->update($request->validated());
                $this->updateTransactionUser($transaction);
            });
        } catch (\Throwable $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }

        return redirect()->route('admin.transactions.index')->with('success', 'Transaction updated');
    }

    public function destroy($id)
    {
        Transaction::findOrFail($id)->delete();

        return redirect()->route('admin.transactions.index')->with('success', 'Transaction deleted');
    }

    private function updateTransactionUser(Transaction $transaction)
    {
        if ($transaction->type == TransactionTypeEnum::DEBIT->value) {
            $transaction->user()->update(['amount' => $transaction->user->amount - $transaction->amount]);
        } elseif ($transaction->type == TransactionTypeEnum::CREDIT->value) {
            $transaction->user()->update(['amount' => $transaction->user->amount + $transaction->amount]);
        }
    }
}
