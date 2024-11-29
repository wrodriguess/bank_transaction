<?php

namespace App\Repository\Http;

use App\Exception\NotificationServiceException;
use App\Repository\Conctracts\NotificationServiceRepositoryInterface;
use Exception;

class NotificationServiceRepository implements NotificationServiceRepositoryInterface
{
    public function __construct(
        private HttpClient $httpClient
    ){}

    public function sendNotification(): void
    {
        try {
            $this->httpClient->request('POST', 'https://util.devi.tools/api/v1/notify');
        } catch (Exception $e) {
            throw NotificationServiceException::forUnnotifiedUser();
        }
    }
}