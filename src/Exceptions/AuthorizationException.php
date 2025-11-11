<?php

namespace Nebatech\Exceptions;

class AuthorizationException extends \Exception
{
    public function __construct(string $message = "Access denied. Insufficient permissions.", int $code = 403, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
