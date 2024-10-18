<?php

namespace App\Exception;

use DomainException;
use Throwable;

class WalletException extends DomainException
{
    private string $type;

    public function __construct($type = "", $message = "", $code = 0, Throwable $previous = null)
    {
        $this->type = $type;
        parent::__construct($message, $code, $previous);
    }

    public function getType(): string
    {
        return $this->type;
    }

    public static function forWalletNotFound(): self
    {
        return new static('WalletNotFound', 'Carteira não encontrada.', 400);
    }

    public static function forInsufficientBalance(): self
    {
        return new static(
            'InsufficientBalance',
            'Saldo insuficiente para realizar a transferencia.',
            400
        );
    }
}
