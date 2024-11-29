<?php

namespace App\MessageHandler;

use App\Message\TransferNotificationMessage;
use App\Repository\Conctracts\NotificationServiceRepositoryInterface;
use PHPUnit\Exception;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class TransferNotificationHandler
{
    public function __construct(private readonly NotificationServiceRepositoryInterface $notificationService)
    {}
    public function __invoke(TransferNotificationMessage $message)
    {
        $this->notificationService->sendNotification();
    }
}
