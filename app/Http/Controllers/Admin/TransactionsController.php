<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatusEnum;
use App\Enums\RoleEnum;
use App\Enums\TransactionTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreOrderRequest;
use App\Http\Requests\Admin\StoreTransactionRequest;
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

    public function addView()
    {
        return Inertia::render('Admin/Transactions/Create', [
            'users' => User::where('role', '!=', RoleEnum::ADMINISTRATOR->value)->get(),
            'types' => array_flip(TransactionTypeEnum::array()),
            'routeName' => 'admin.transactions.add',
        ]);
    }

    public function add(StoreTransactionRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                Transaction::create($request->validated() + [
                    'type' => TransactionTypeEnum::CREDIT->value,
                    'description' => 'Received funds #email: ' + $request->user()->email,
                ]);
            });
        } catch (\Throwable $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }

        return redirect()->route('admin.transactions')->with('success', 'Money Added');
    }


    public function decreaseView()
    {
        return Inertia::render('Admin/Transactions/Create', [
            'users' => User::where('role', '!=', RoleEnum::ADMINISTRATOR->value)->get(),
            'types' => array_flip(TransactionTypeEnum::array()),
            'routeName' => 'admin.transactions.decrease',
        ]);
    }

    public function decrease(StoreTransactionRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                Transaction::create($request->validated() + [
                    'type' => TransactionTypeEnum::DEBIT->value,
                    'description' => 'Decreased funds #email: ' + $request->user()->email,
                ]);
            });
        } catch (\Throwable $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }

        return redirect()->route('admin.transactions')->with('success', 'Money Decreased');
    }
}
