<?php

namespace App\Repository\Http;

use App\Exception\TransferAuthorizationException;
use App\Repository\Conctracts\TransferAuthorizationServiceRepositoryInterface;
use Exception;

class TransferAuthorizationServiceRepository implements TransferAuthorizationServiceRepositoryInterface
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
            throw TransferAuthorizationException::forUnauthorizedTransfer();
        }
    }

}