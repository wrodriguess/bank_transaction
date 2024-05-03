<?php

namespace App\Service;

use App\DTO\TransferDTO;
use App\Entity\Transfer as TransferEntity;
use App\Repository\Http\NotificationService;
use App\Repository\Http\TransferAuthorizationService;
use App\Repository\MySql\TransferRepository;
use App\Repository\MySql\UserRepository;
use DateTimeImmutable;

class Transfer
{
    public function __construct(
        private UserRepository $userRepository,
        private TransferRepository $transferRepository,
        private TransferAuthorizationService $transferAuthorizationService,
        private NotificationService $notificationService
    ){}

    public function execute(TransferDTO $transferDTO): void
    {
        $this->transferAuthorizationService->isAuthorized();
        $payer = $this->userRepository->findOrException($transferDTO->payerId);
        $payee = $this->userRepository->findOrException($transferDTO->payeeId);
        $transfer = new TransferEntity(
            $payer,
            $payee,
            $transferDTO->value,
            DateTimeImmutable::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'))
        );
        $this->transferRepository->create($transfer);
        $this->notificationService->sendNotification();
    }
}