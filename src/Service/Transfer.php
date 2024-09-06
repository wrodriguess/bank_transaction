<?php

namespace App\Service;

use App\Exception\TransferAuthorizationException;
use Exception;
use App\DTO\TransferDTO;
use App\Entity\Transfer as TransferEntity;
use App\Repository\Conctracts\TransferRepositoryInterface;
use App\Repository\Conctracts\UserRepositoryInterface;
use App\Repository\Conctracts\NotificationServiceRepositoryInterface;
use App\Repository\Conctracts\TransferAuthorizationServiceRepositoryInterface;
use DateTimeImmutable;

class Transfer
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly TransferRepositoryInterface $transferRepository,
        private readonly TransferAuthorizationServiceRepositoryInterface $transferAuthorizationService,
        private readonly NotificationServiceRepositoryInterface $notificationService
    ){}

    /**
     * @throws Exception
     */
    public function execute(TransferDTO $transferDTO): void
    {
        if (!$this->transferAuthorizationService->isAuthorized()) {
            throw TransferAuthorizationException::forUnauthorizedTransfer();
        }
        $payer = $this->userRepository->findOrException($transferDTO->payerId);
        $payee = $this->userRepository->findOrException($transferDTO->payeeId);
        $transfer = new TransferEntity(
            $payer,
            $payee,
            $transferDTO->value,
            DateTimeImmutable::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'))
        );
        $this->transferRepository->create($transfer);
        // TODO: Colocar em uma fila de disparos assincrono (impede a conclusão até ser disparado)
        $this->notificationService->sendNotification();
    }
}