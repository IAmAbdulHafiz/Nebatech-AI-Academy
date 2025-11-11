<?php

namespace Nebatech\Exceptions;

class ValidationException extends \Exception
{
    protected array $errors;

    public function __construct(array $errors, string $message = "Validation failed", int $code = 422)
    {
        $this->errors = $errors;
        parent::__construct($message, $code);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
