<?php

namespace App\Service;

use App\Exception\TransferAuthorizationException;
use App\Repository\MySql\WalletRepository;
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
        private readonly WalletRepository $walletRepository,
        private readonly TransferRepositoryInterface $transferRepository,
        private readonly TransferAuthorizationServiceRepositoryInterface $transferAuthorizationService,
        private readonly NotificationServiceRepositoryInterface $notificationService
    ){}

    /**
     * @throws Exception
     */
    public function execute(TransferDTO $transferDTO): void
    {
//        if (!$this->transferAuthorizationService->isAuthorized()) {
//            throw TransferAuthorizationException::forUnauthorizedTransfer();
//        }

        $payer = $this->userRepository->findOrException($transferDTO->payerId);
        $payerWallet = $this->walletRepository->findByUserId($payer->getId());

        $payee = $this->userRepository->findOrException($transferDTO->payeeId);
        $payeeWallet = $this->walletRepository->findByUserId($payee->getId());

        $transfer = new TransferEntity(
            $payer,
            $payee,
            $transferDTO->value,
            DateTimeImmutable::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'))
        );

        $payerWallet->withdraw($transferDTO->value);
        $payeeWallet->deposit($transferDTO->value);

        $this->transferRepository->create($transfer);

        // TODO: Colocar em uma fila de disparos assincrono
//        $this->notificationService->sendNotification();
    }
}