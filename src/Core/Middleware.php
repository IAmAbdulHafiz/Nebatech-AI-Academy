<?php

namespace Nebatech\Core;

abstract class Middleware
{
    abstract public function handle(): void;

    protected function abort(int $code = 403, string $message = 'Forbidden'): void
    {
        http_response_code($code);
        echo json_encode(['error' => $message]);
        exit;
    }
}
