<?php

namespace App\Repository\Http;

use Exception;

class NotificationService
{
    public function __construct(
        private HttpClient $httpClient
    ){}

    public function sendNotification(): void
    {
        try {
            $this->httpClient->request('POST', 'https://util.devi.tools/api/v1/notify');
        } catch (Exception $e) {
            throw new Exception("Não foi possível notificar o usuário.");
        }
    }
}