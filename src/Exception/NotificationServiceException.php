<?php

namespace App\Exception;

use DomainException;
use Throwable;

class NotificationServiceException extends DomainException
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

    public static function forUnnotifiedUser(): self
    {
        return new static('UnnotifiedUser', 'Não foi possível notificar o usuário.', 400);
    }
}
