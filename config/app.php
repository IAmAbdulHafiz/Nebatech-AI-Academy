<?php

return [
    'name' => $_ENV['APP_NAME'] ?? 'Nebatech AI Academy',
    'env' => $_ENV['APP_ENV'] ?? 'production',
    'debug' => filter_var($_ENV['APP_DEBUG'] ?? false, FILTER_VALIDATE_BOOLEAN),
    'url' => $_ENV['APP_URL'] ?? 'http://localhost',
    'timezone' => 'Africa/Lagos',
    'locale' => 'en',
];
