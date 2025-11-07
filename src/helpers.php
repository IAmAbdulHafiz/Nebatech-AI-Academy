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
        return $appBase . ($path ? '/' . $path : '');
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
