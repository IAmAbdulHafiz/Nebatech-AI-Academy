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
        '/payments/hubtel/callback', // Hubtel payment webhook
    ];

    public function handle(): void
    {
        // Ensure CSRF token exists in session (generate if not present)
        if (!isset($_SESSION['_csrf_token'])) {
            $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
        }

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

        if (empty($sessionToken) || empty($token) || !hash_equals($sessionToken, $token)) {
            error_log('CSRF token mismatch - IP: ' . ($_SERVER['REMOTE_ADDR'] ?? 'unknown') . ' - Session token exists: ' . (!empty($sessionToken) ? 'yes' : 'no') . ' - Posted token exists: ' . (!empty($token) ? 'yes' : 'no'));
            throw new CsrfTokenException();
        }
    }

    /**
     * Check if current route is excluded from CSRF protection
     */
    protected function isExcluded(): bool
    {
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // Strip the application base path if present
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
        $scriptDir = dirname($scriptName);
        $baseParts = explode('/', trim($scriptDir, '/'));
        array_pop($baseParts); // Remove 'public'
        $appBase = '/' . implode('/', $baseParts);
        
        $currentPath = $requestUri;
        if ($appBase !== '/' && $appBase !== '' && strpos($currentPath, $appBase) === 0) {
            $currentPath = substr($currentPath, strlen($appBase));
        }
        
        // Ensure path starts with /
        if (empty($currentPath) || $currentPath[0] !== '/') {
            $currentPath = '/' . $currentPath;
        }

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
