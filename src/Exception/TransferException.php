<?php

namespace App\Exception;

use DomainException;
use Throwable;

class TransferException extends DomainException
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

    public static function forCannotSaveEntity(): self
    {
        return new static('CannotSaveTransfer', 'Não foi possivel salvar a transferencia na base de dados', 400);
    }
}
