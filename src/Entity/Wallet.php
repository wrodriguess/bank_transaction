<?php

namespace App\Entity;

use App\Exception\WalletException;
use App\Repository\MySql\WalletRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Exception;

#[ORM\Entity(repositoryClass: WalletRepository::class)]
class Wallet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column]
    private int $userId;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private float $balance;

    #[ORM\OneToOne(inversedBy: 'wallet', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function __construct(int $id, int $userId, float $balance)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->balance = $balance;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getBalance(): float
    {
        return $this->balance;
    }

    public function setBalance(float $balance): void
    {
        $this->balance = $balance;
    }

    public function withdraw(float $amount): void
    {
        if($amount > $this->balance) {
            throw WalletException::forInsufficientBalance();
        }

        $this->setBalance($this->balance - $amount);
    }

    public function deposit(float $amount): void
    {
        $this->setBalance($this->balance + $amount);
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
