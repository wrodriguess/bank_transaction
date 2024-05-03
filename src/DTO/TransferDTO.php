<?php

namespace App\DTO;

class TransferDTO
{
    public function __construct(
        public string $payerId,
        public string $payeeId,
        public float $value
    ) {}
}