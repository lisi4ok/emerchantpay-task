<?php
namespace App\Interfaces;

use App\Models\User;

interface WalletServiceInterface
{
    public function addMoney(float $amount, string $title, ?string $description = null): bool;
    public function transferMoney(float $amount, User $from, User $to): bool;
}
