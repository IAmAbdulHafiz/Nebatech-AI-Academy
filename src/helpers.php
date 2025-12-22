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

if (!function_exists('env')) {
    /**
     * Get environment variable value
     * 
     * @param string $key The environment variable key
     * @param mixed $default Default value if not found
     * @return mixed
     */
    function env(string $key, $default = null)
    {
        $value = getenv($key);
        
        if ($value === false) {
            return $default;
        }
        
        // Convert boolean strings
        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'empty':
            case '(empty)':
                return '';
            case 'null':
            case '(null)':
                return null;
        }
        
        return $value;
    }
}

if (!function_exists('config')) {
    /**
     * Get configuration value from config files
     * 
     * @param string $key The config key in format 'file.key' or just 'file'
     * @param mixed $default Default value if not found
     * @return mixed
     */
    function config(string $key, $default = null)
    {
        static $configCache = [];
        
        $parts = explode('.', $key, 2);
        $file = $parts[0];
        $configKey = $parts[1] ?? null;
        
        // Load config file if not cached
        if (!isset($configCache[$file])) {
            $configPath = dirname(__DIR__) . '/config/' . $file . '.php';
            if (file_exists($configPath)) {
                $configCache[$file] = require $configPath;
            } else {
                $configCache[$file] = [];
            }
        }
        
        // Return entire config file or specific key
        if ($configKey === null) {
            return !empty($configCache[$file]) ? $configCache[$file] : $default;
        }
        
        return $configCache[$file][$configKey] ?? $default;
    }
}

if (!function_exists('timeAgo')) {
    /**
     * Convert a datetime to a human-readable "time ago" string
     */
    function timeAgo(?string $datetime): string
    {
        if (empty($datetime)) {
            return 'Unknown';
        }
        
        $timestamp = strtotime($datetime);
        $now = time();
        $diff = $now - $timestamp;
        
        if ($diff < 0) {
            return 'Just now';
        }
        
        $intervals = [
            31536000 => 'year',
            2592000 => 'month',
            604800 => 'week',
            86400 => 'day',
            3600 => 'hour',
            60 => 'minute',
            1 => 'second'
        ];
        
        foreach ($intervals as $seconds => $label) {
            $count = floor($diff / $seconds);
            if ($count >= 1) {
                return $count . ' ' . $label . ($count > 1 ? 's' : '') . ' ago';
            }
        }
        
        return 'Just now';
    }
}
