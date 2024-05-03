<?php

namespace App\Repository\Conctracts;

use App\Entity\Transfer;

interface TransferRepositoryInterface
{
    public function create(Transfer $transfer): Transfer;
}