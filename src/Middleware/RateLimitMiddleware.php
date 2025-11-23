<?php

namespace Nebatech\Middleware;

use Nebatech\Core\Middleware;

class RateLimitMiddleware extends Middleware
{
    protected int $maxAttempts = 60; // Max requests per window
    protected int $decayMinutes = 1; // Time window in minutes

    public function handle(): void
    {
        $key = $this->resolveRequestSignature();
        $maxAttempts = $this->maxAttempts;
        $decayMinutes = $this->decayMinutes;

        // Initialize rate limit data in session if not exists
        if (!isset($_SESSION['rate_limit'])) {
            $_SESSION['rate_limit'] = [];
        }

        $now = time();
        $windowStart = $now - ($decayMinutes * 60);

        // Clean up old entries
        $_SESSION['rate_limit'] = array_filter(
            $_SESSION['rate_limit'],
            fn($timestamp) => $timestamp > $windowStart
        );

        // Count requests in current window
        $attempts = isset($_SESSION['rate_limit'][$key]) 
            ? count(array_filter($_SESSION['rate_limit'][$key], fn($t) => $t > $windowStart))
            : 0;

        if ($attempts >= $maxAttempts) {
            http_response_code(429);
            header('Retry-After: ' . ($decayMinutes * 60));
            die(json_encode([
                'error' => 'Too many requests. Please try again later.',
                'retry_after' => $decayMinutes * 60
            ]));
        }

        // Record this request
        if (!isset($_SESSION['rate_limit'][$key])) {
            $_SESSION['rate_limit'][$key] = [];
        }
        $_SESSION['rate_limit'][$key][] = $now;
    }

    /**
     * Generate unique signature for the request
     */
    protected function resolveRequestSignature(): string
    {
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $userId = $_SESSION['user_id'] ?? 'guest';
        $route = $_SERVER['REQUEST_URI'] ?? '/';
        
        return md5($ip . '|' . $userId . '|' . $route);
    }
}
