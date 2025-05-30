<?php

namespace App\Exception;

use DomainException;
use Throwable;

class HttpClientException extends DomainException
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

    public static function httpRequestError(): self
    {
        return new static('HttpRequestError', 'Erro ao realizar requisição.', 400);
    }
}
