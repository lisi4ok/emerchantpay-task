<?php

namespace App\Http\Controllers\Merchant;

use App\Enums\MoneyTypeEnum;
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
        return Inertia::render('Merchant/AddMoney', [
            'amount' => (new UserResource(Auth::user()))->amount,
            'addMoneyTypes' => array_flip(MoneyTypeEnum::array()),
            'orderMoneyType' => MoneyTypeEnum::ORDER->value, // array_flip(MoneyTypeEnum::array())[MoneyTypeEnum::ORDER->value],
        ]);
    }

    public function storeMoney(AddMoneyRequest $request)
    {
        try {
            $this->walletService->addMoney(
                (float) $request->validated('amount'),
                (int) Auth::user()->id,
                $request
            );
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return redirect()->route('dashboard')->with('success', 'Money added');
    }


    public function sendMoney()
    {
        $users = User::where('id', '!=', Auth::user()->id)
            ->where('role', '!=', RoleEnum::ADMINISTRATOR->value)
            ->get();

        return Inertia::render('Merchant/SendMoney', [
            'users' => UserResource::collection($users),
            'amount' => (new UserResource(Auth::user()))->amount,
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
        return redirect()->route('dashboard')->with('success', 'Money transferred');
    }
}
