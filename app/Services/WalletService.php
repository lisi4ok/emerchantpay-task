<?php

namespace App\Services;

use App\Interfaces\WalletServiceInterface;
use App\Models\User;

class WalletService implements WalletServiceInterface
{
//    public function __construct(
//        public User $user,
//    ) {}

    public function addMoney(User $user, float $amount)
    {

    }

    public function transferMoney(User $user, float $amount)
    {

    }
}
