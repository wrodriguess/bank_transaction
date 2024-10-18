<?php

namespace App\Repository\Conctracts;

use App\Entity\Wallet;

interface WalletRepositoryInterface
{
    public function findByUserId(string $userId): Wallet;
}