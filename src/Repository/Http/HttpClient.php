<?php

namespace App\Repository\Http;

use Exception;
use GuzzleHttp\Client;

class HttpClient
{
    public function __construct(
        private Client $client
    ){}

    public function request(string $method, string $url)
    {
        try {
            $response = $this->client->request($method, $url);
            return json_decode($response->getBody()->getContents(), true);
        } catch (Exception $e) {
            throw new Exception('Erro ao realizar requisição');
        }
    }
}