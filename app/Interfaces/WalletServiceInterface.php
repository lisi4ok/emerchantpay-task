<?php
namespace App\Interfaces;

use App\Models\User;

interface WalletServiceInterface
{
    public function addMoney(User $user, float $amount);
    public function transferMoney(User $user, float $amount);
}
