<?php

namespace Nebatech\Middleware;

use Nebatech\Core\Middleware;
use Nebatech\Exceptions\CsrfTokenException;

class CsrfMiddleware extends Middleware
{
    /**
     * Excluded routes from CSRF protection (e.g., API endpoints with token auth)
     */
    protected array $except = [
        '/api/*',
    ];

    public function handle(): void
    {
        // Skip CSRF check for GET, HEAD, OPTIONS requests
        if (in_array($_SERVER['REQUEST_METHOD'], ['GET', 'HEAD', 'OPTIONS'])) {
            return;
        }

        // Check if route is excluded
        if ($this->isExcluded()) {
            return;
        }

        // Validate CSRF token
        $token = $_POST['_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
        $sessionToken = $_SESSION['_csrf_token'] ?? '';

        if (empty($sessionToken) || !hash_equals($sessionToken, $token)) {
            error_log('CSRF token mismatch - IP: ' . ($_SERVER['REMOTE_ADDR'] ?? 'unknown'));
            throw new CsrfTokenException();
        }
    }

    /**
     * Check if current route is excluded from CSRF protection
     */
    protected function isExcluded(): bool
    {
        $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        foreach ($this->except as $pattern) {
            // Convert wildcard pattern to regex
            $regex = '#^' . str_replace('\*', '.*', preg_quote($pattern, '#')) . '$#';
            if (preg_match($regex, $currentPath)) {
                return true;
            }
        }

        return false;
    }
}
