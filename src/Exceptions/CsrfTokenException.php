<?php

namespace Nebatech\Exceptions;

class CsrfTokenException extends \Exception
{
    public function __construct(string $message = "CSRF token mismatch", int $code = 403, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
