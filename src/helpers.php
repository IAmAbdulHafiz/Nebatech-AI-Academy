<?php

/**
 * Helper Functions
 */

if (!function_exists('base_url')) {
    /**
     * Get the base URL for the application
     */
    function base_url(string $path = ''): string
    {
        $scriptName = $_SERVER['SCRIPT_NAME'];
        $scriptDir = dirname($scriptName);
        
        // Get the application base (one level up from public)
        $baseParts = explode('/', trim($scriptDir, '/'));
        array_pop($baseParts); // Remove 'public'
        $appBase = '/' . implode('/', $baseParts);
        
        if ($appBase === '/') {
            $appBase = '';
        }
        
        $path = ltrim($path, '/');
        
        // If no path provided (root), ensure we return base with trailing slash
        if (empty($path)) {
            return $appBase . '/';
        }
        
        return $appBase . '/' . $path;
    }
}

if (!function_exists('asset')) {
    /**
     * Get the URL for an asset
     */
    function asset(string $path): string
    {
        return base_url('assets/' . ltrim($path, '/'));
    }
}

if (!function_exists('url')) {
    /**
     * Generate a URL for the application
     */
    function url(string $path = ''): string
    {
        // Normalize the path - treat '/' as empty (home)
        $path = trim($path);
        if ($path === '/') {
            $path = '';
        }
        return base_url($path);
    }
}

if (!function_exists('redirect')) {
    /**
     * Redirect to a URL
     */
    function redirect(string $path, int $statusCode = 302): void
    {
        header('Location: ' . url($path), true, $statusCode);
        exit;
    }
}

if (!function_exists('old')) {
    /**
     * Get old input value
     */
    function old(string $key, $default = '')
    {
        return $_SESSION['_old_input'][$key] ?? $default;
    }
}

if (!function_exists('csrf_token')) {
    /**
     * Generate CSRF token
     */
    function csrf_token(): string
    {
        if (!isset($_SESSION['_csrf_token'])) {
            $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['_csrf_token'];
    }
}

if (!function_exists('csrf_field')) {
    /**
     * Generate CSRF hidden input field
     */
    function csrf_field(): string
    {
        return '<input type="hidden" name="_token" value="' . csrf_token() . '">';
    }
}

if (!function_exists('current_user')) {
    /**
     * Get current authenticated user data
     */
    function current_user(): ?array
    {
        return $_SESSION['user_data'] ?? null;
    }
}

if (!function_exists('user_role')) {
    /**
     * Get current user's role
     */
    function user_role(): ?string
    {
        $user = current_user();
        return $user['role'] ?? null;
    }
}

if (!function_exists('is_student')) {
    /**
     * Check if current user is a student
     */
    function is_student(): bool
    {
        return user_role() === 'student';
    }
}

if (!function_exists('is_facilitator')) {
    /**
     * Check if current user is a facilitator
     */
    function is_facilitator(): bool
    {
        return user_role() === 'facilitator';
    }
}

if (!function_exists('is_admin')) {
    /**
     * Check if current user is an admin
     */
    function is_admin(): bool
    {
        return user_role() === 'admin';
    }
}

if (!function_exists('has_role')) {
    /**
     * Check if current user has specific role
     */
    function has_role(string $role): bool
    {
        return user_role() === $role;
    }
}

if (!function_exists('has_any_role')) {
    /**
     * Check if current user has any of the specified roles
     */
    function has_any_role(array $roles): bool
    {
        return in_array(user_role(), $roles);
    }
}

if (!function_exists('e')) {
    /**
     * Escape HTML entities for XSS protection
     */
    function e($value): string
    {
        if ($value === null) {
            return '';
        }
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('timeAgo')) {
    /**
     * Convert timestamp to "time ago" format
     */
    function timeAgo(string $datetime): string
    {
        $timestamp = strtotime($datetime);
        $diff = time() - $timestamp;

        if ($diff < 60) {
            return 'Just now';
        } elseif ($diff < 3600) {
            $mins = floor($diff / 60);
            return $mins . ' minute' . ($mins > 1 ? 's' : '') . ' ago';
        } elseif ($diff < 86400) {
            $hours = floor($diff / 3600);
            return $hours . ' hour' . ($hours > 1 ? 's' : '') . ' ago';
        } elseif ($diff < 604800) {
            $days = floor($diff / 86400);
            return $days . ' day' . ($days > 1 ? 's' : '') . ' ago';
        } else {
            return date('M j, Y', $timestamp);
        }
    }
}
