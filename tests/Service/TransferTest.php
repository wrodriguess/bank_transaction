<?php

namespace Service;

use App\Entity\Wallet;
Use Exception;
use App\DTO\TransferDTO;
use App\Entity\Transfer as TransferEntity;
use App\Entity\User;
use App\Exception\TransferAuthorizationException;
use App\Exception\UserException;
use App\Repository\Conctracts\NotificationServiceRepositoryInterface;
use App\Repository\Conctracts\TransferAuthorizationServiceRepositoryInterface;
use App\Repository\Conctracts\TransferRepositoryInterface;
use App\Repository\Conctracts\UserRepositoryInterface;
use App\Repository\Http\NotificationServiceRepository;
use App\Repository\Http\TransferAuthorizationServiceRepository;
use App\Service\Transfer;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class TransferTest extends TestCase
{
    use UserFactory;
    private UserRepositoryInterface $userRepository;
    private TransferRepositoryInterface $transferRepository;
    private TransferAuthorizationServiceRepositoryInterface $transferAuthorizationService;
    private NotificationServiceRepositoryInterface $notificationService;
    private Transfer $instance;
    private User $payer;
    private User $payee;

    public function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepositoryInterface::class);
        $this->transferRepository = $this->createMock(TransferRepositoryInterface::class);
        $this->transferAuthorizationService = $this->createMock(
            TransferAuthorizationServiceRepositoryInterface::class
        );
        $this->notificationService = $this->createMock(NotificationServiceRepositoryInterface::class);

        $this->instance = new Transfer(
            $this->userRepository,
            $this->transferRepository,
            $this->transferAuthorizationService,
            $this->notificationService
        );
    }

    /**
     * @throws Exception
     */
    public function testTransferWithTransferUnauthorizedShouldThrowAnException(): void
    {
        $this->transferAuthorizationService
            ->method('isAuthorized')
            ->willReturn(false);

        $this->expectException(TransferAuthorizationException::class);
        $this->expectExceptionMessage("Transação não autorizada.");

        $transferDto = new TransferDTO(1, 2, 150.00);

        $this->instance->execute($transferDto);
    }

    public function testTransferWithUserNotFoundShouldThrowAnException(): void
    {
        $this->transferAuthorizationService->method('isAuthorized')->willReturn(true);

        $this->userRepository
            ->method('findOrException')
            ->will($this->throwException(new \Exception('User not found')));

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('User not found');

        $transferDTO = new TransferDTO(1, 2, 150.00);

        $this->instance->execute($transferDTO);
    }

    public function testTransferWithPayerAndPayeeAreSamePersonThrowAnException(): void
    {
        $this->transferAuthorizationService
            ->method('isAuthorized')
            ->willReturn(true);

        $user = $this->createMock(User::class);

        $this->userRepository
            ->method('findOrException')
            ->willReturn($user);

        $transferDto = new TransferDTO(1, 1, 150.00);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Pagador e recebedor são a mesma pessoa');

        $this->instance->execute($transferDto);
    }

    public function testTransferWithValidDataShouldWork(): void
    {
        $this->transferAuthorizationService->method('isAuthorized')->willReturn(true);

        $payer = $this->createMock(User::class);
        $payee = $this->createMock(User::class);
        $transfer = $this->createMock(TransferEntity::class);

        $this->userRepository
            ->method('findOrException')
            ->willReturnOnConsecutiveCalls($payer, $payee);

        $this->transferRepository
            ->method('create')
            ->willReturn($transfer);

        $this->notificationService
            ->method('sendNotification')
            ->willReturn(null);

        $transferDto = new TransferDTO(1, 2, 150.00);

        $this->instance->execute($transferDto);

        $this->assertTrue(true);
    }
}

trait UserFactory
{
    public function factoryUser(): User
    {
        return new User(
            'William',
            1,
            'will@gmail.com',
        '123',
        '741852963',
        1,
        '11 974687946'
        );
    }
}