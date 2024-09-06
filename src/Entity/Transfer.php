<?php

namespace App\Entity;

use App\Repository\MySql\TransferRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Exception;

#[ORM\Entity(repositoryClass: TransferRepository::class)]
class Transfer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\ManyToOne(inversedBy: 'transfers')]
    #[ORM\JoinColumn(nullable: false)]
    private User $payer;

    #[ORM\ManyToOne(inversedBy: 'transfers')]
    #[ORM\JoinColumn(nullable: false)]
    private User $payee;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private float $value;

    #[ORM\Column]
    private DateTimeImmutable $createdAt;

    public function __construct(
        User $payer,
        User $payee,
        float $value,
        DateTimeImmutable $createdAt
    )
    {
        if($payer === $payee) {
            // TODO: Adicionar exeção de dominio
            throw new Exception('Pagador e recebedor são a mesma pessoa');
        }

        $this->payer = $payer;
        $this->payee = $payee;
        $this->value = $value;
        $this->createdAt = $createdAt;

        $this->payer->getWallet()->withdraw($this->value);
        $this->payee->getWallet()->deposit($this->value);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function setValue(float $value): void
    {
        $this->value = $value;
    }

    public function getPayer(): ?User
    {
        return $this->payer;
    }

    public function setPayer(?User $payer): static
    {
        $this->payer = $payer;

        return $this;
    }

    public function getPayee(): ?User
    {
        return $this->payee;
    }

    public function setPayee(?User $payee): static
    {
        $this->payee = $payee;

        return $this;
    }
}
