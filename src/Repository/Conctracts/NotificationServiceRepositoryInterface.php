<?php

namespace App\Repository\Conctracts;

interface NotificationServiceRepositoryInterface
{
    public function sendNotification(): void;
}