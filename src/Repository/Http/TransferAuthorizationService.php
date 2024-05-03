<?php

namespace App\Repository\Http;

use Exception;

class TransferAuthorizationService
{
    public function __construct(
        private HttpClient $httpClient
    ){}

    public function isAuthorized(): bool
    {
        try {
            $response = $this->httpClient->request('GET', 'https://util.devi.tools/api/v2/authorize');
            return $response['data']['authorization'];
        } catch (Exception $e) {
            throw new Exception('Transação não autorizada');
        }
    }

}