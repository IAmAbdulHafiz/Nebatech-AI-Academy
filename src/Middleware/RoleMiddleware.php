<?php

namespace Nebatech\Middleware;

use Nebatech\Core\Middleware;

class RoleMiddleware extends Middleware
{
    private array $allowedRoles;

    /**
     * Constructor
     */
    public function __construct(array $allowedRoles)
    {
        $this->allowedRoles = $allowedRoles;
    }

    /**
     * Handle role-based authorization
     */
    public function handle(): void
    {
        // First check if user is authenticated
        if (!AuthMiddleware::check()) {
            $_SESSION['intended_url'] = $_SERVER['REQUEST_URI'];
            header('Location: /login');
            exit;
        }

        // Check if user has required role
        if (!AuthMiddleware::hasAnyRole($this->allowedRoles)) {
            // User is authenticated but doesn't have permission
            http_response_code(403);
            echo json_encode([
                'error' => 'Access denied. Insufficient permissions.',
                'required_roles' => $this->allowedRoles
            ]);
            exit;
        }
    }

    /**
     * Middleware for facilitator-only routes
     */
    public static function facilitator(): self
    {
        return new self(['facilitator', 'admin']);
    }

    /**
     * Middleware for admin-only routes
     */
    public static function admin(): self
    {
        return new self(['admin']);
    }

    /**
     * Middleware for student-only routes
     */
    public static function student(): self
    {
        return new self(['student']);
    }
    
    /**
     * Middleware for authenticated users (any role)
     */
    public static function authenticated(): self
    {
        return new self(['student', 'facilitator', 'admin']);
    }
}
