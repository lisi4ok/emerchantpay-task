<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\StoreTransactionRequest;
use App\Http\Requests\Admin\UpdateTransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = $this->filter(
            model: Transaction::class,
            where: ['user_id' => Auth::user()],
            with: ['user', 'createdBy']
        );

        return Inertia::render('Merchant/Transactions/Index', [
            'transactions' => TransactionResource::collection($transactions),
            'queryParams' => request()->query() ?: null,
        ]);
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransactionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
