<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Role;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class TransactionsController extends Controller
{
    public function index()
    {
        $transactions = $this->filter(Transaction::class, [], ['name', 'type', 'amount']);

        return Inertia::render('Admin/Transactions/Index', [
            'transactions' => TransactionResource::collection($transactions),
            'queryParams' => request()->query() ?: null,
            'success' => session('success'),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Transactions/Create', [
            'transactions' => Transaction::all(),
        ]);
    }

    public function store(StoreUserRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $user = User::create($request->validated());
                $user->roles()->sync($request->get('roles'));
            });
        } catch (\Throwable $exception) {
            return redirect()->back()->withErrors(['error' => $exception->getMessage()]);
        }

        return redirect()->route('admin.transactions.index')->with('success', 'Transaction created');
    }

    public function show(int $id)
    {
        $user = User::with('roles')->findOrFail($id);

        return Inertia::render('Admin/Transactions/Show', [
            'user' => $user,
            'userRoles' => $user->roles->pluck('id'),
            'roles' => Role::all(),
        ]);
    }

    public function edit(int $id)
    {
        $user = User::with('roles')->findOrFail($id);

        return Inertia::render('Admin/Transactions/Edit', [
            'user' => $user,
            'userRoles' => $user->roles->pluck('id'),
            'roles' => Role::all(),
        ]);
    }

    public function update(UpdateUserRequest $request, int $id)
    {
        $user = User::with('roles')->findOrFail($id);

        try {
            DB::transaction(function () use ($user, $request) {
                $data = $request->validated();
                $password = $data['password'] ?? null;
                if (!$password) {
                    unset($data['password']);
                }
                $user->update($data);
                $user->roles()->sync($request->get('roles'));
            });
        } catch (\Throwable $exception) {
            return redirect()->back()->withErrors(['error' => $exception->getMessage()]);
        }

        return redirect()->route('admin.transactions.index')->with('success', 'Transaction updated');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return redirect()->route('admin.transactions.index')->with('success', 'Transaction deleted');
    }
}
