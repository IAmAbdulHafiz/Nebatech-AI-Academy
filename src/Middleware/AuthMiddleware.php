<?php

namespace Nebatech\Middleware;

use Nebatech\Core\Middleware;

class AuthMiddleware extends Middleware
{
    /**
     * Handle authentication check
     */
    public function handle(): void
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            // Store intended URL for redirect after login
            $_SESSION['intended_url'] = $_SERVER['REQUEST_URI'];
            
            // Redirect to login
            header('Location: /login');
            exit;
        }
    }

    /**
     * Check if user is authenticated
     */
    public static function check(): bool
    {
        return isset($_SESSION['user_id']);
    }

    /**
     * Get authenticated user ID
     */
    public static function userId(): ?int
    {
        return $_SESSION['user_id'] ?? null;
    }

    /**
     * Get authenticated user data
     */
    public static function user(): ?array
    {
        if (!isset($_SESSION['user_data'])) {
            return null;
        }

        return $_SESSION['user_data'];
    }

    /**
     * Check if user has specific role
     */
    public static function hasRole(string $role): bool
    {
        $user = self::user();
        return $user && $user['role'] === $role;
    }

    /**
     * Check if user has any of the specified roles
     */
    public static function hasAnyRole(array $roles): bool
    {
        $user = self::user();
        return $user && in_array($user['role'], $roles);
    }
}
