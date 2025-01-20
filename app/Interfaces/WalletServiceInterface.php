<?php
namespace App\Interfaces;

use App\Http\Requests\AddMoneyRequest;
use App\Models\User;

interface WalletServiceInterface
{
    public function addMoney(float $amount, int $userId, AddMoneyRequest $request): bool;
    public function transferMoney(float $amount, User $from, User $to): bool;
}
