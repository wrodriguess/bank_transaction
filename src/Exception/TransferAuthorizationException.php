<?php

namespace App\Exception;

use DomainException;
use Throwable;

class TransferAuthorizationException extends DomainException
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

    public static function forUnauthorizedTransfer(): self
    {
        return new static('UnauthorizedTransfer', 'Transação não autorizada.', 400);
    }
}
