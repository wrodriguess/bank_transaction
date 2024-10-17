<?php

namespace App\Repository\Http;

use App\Entity\User;
use App\Exception\NotificationServiceException;
use App\Repository\Conctracts\UserRepositoryInterface;
use Exception;

class UserServiceRepository implements UserRepositoryInterface
{
    public function __construct(
        private HttpClient $httpClient
    ){}

    public function findOrException(string $id): User
    {
        try {
            $data = $this->httpClient->request('GET', "http://localhost:3030/users/$id");

            return new User(
                $data['name'],
                $data['type'],
                $data['email'],
                $data['password'],
                $data['document'],
                $data['documentType'],
                $data['phoneNumber']
            );
        } catch (Exception $e) {
            throw NotificationServiceException::forUnnotifiedUser();
        }
    }
}