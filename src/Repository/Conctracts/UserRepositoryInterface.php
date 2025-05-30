<?php

namespace App\Repository\Conctracts;

use App\Entity\User;

interface UserRepositoryInterface
{
    public function findOrException(string $id): User;
}