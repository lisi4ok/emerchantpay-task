<?php

namespace App\Http\Controllers\Merchant;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddMoneyRequest;
use App\Http\Requests\TransferMoneyRequest;
use App\Http\Resources\UserResource;
use App\Interfaces\WalletServiceInterface;
use App\Models\User;
use App\Services\WalletService;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class WalletController extends Controller
{
    protected ?WalletServiceInterface $walletService;
    public function __construct() {
        $this->walletService = new WalletService;
    }


    public function addMoney()
    {
        return Inertia::render('Merchant/AddMoney');
    }

    public function storeMoney(AddMoneyRequest $request)
    {
        try {
            $this->walletService->addMoney(
                (float) $request->validated('amount'),
                $request->validated('title')
            );

        } catch (\Throwable $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
        return redirect()->route('dashboard')->with('success', 'Successfully added Money');
    }


    public function sendMoney()
    {
        $users = User::where('id', '!=', Auth::user()->id)
            ->where('role', '!=', RoleEnum::ADMINISTRATOR->value)
            ->get();

        return Inertia::render('Merchant/SendMoney', [
            'users' => UserResource::collection($users),
            'amount' => Auth::user()->amount,
        ]);
    }

    public function transferMoney(TransferMoneyRequest $request)
    {
        try {
            $from = Auth::user();
            $to = User::findOrFail($request->validated('user_id'));

            $this->walletService->transferMoney((float) $request->validated('amount'), $from, $to);

        } catch (\Throwable $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
        return redirect()->route('dashboard')->with('success', 'Successfully added Money');
    }
}
