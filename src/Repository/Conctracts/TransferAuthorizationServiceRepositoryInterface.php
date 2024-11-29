<?php

namespace App\Repository\Conctracts;

interface TransferAuthorizationServiceRepositoryInterface
{
    public function isAuthorized(): bool;
}