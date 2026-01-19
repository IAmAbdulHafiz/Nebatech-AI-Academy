<?php

/**
 * Nebatech Software Solutions Ltd
 * Main Entry Point
 */

// Load Composer autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Load helper functions
require_once __DIR__ . '/../src/helpers.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Error handling based on environment
$isProduction = ($_ENV['APP_ENV'] ?? 'production') === 'production';
$isDebug = ($_ENV['APP_DEBUG'] ?? 'false') === 'true';

if ($isProduction || !$isDebug) {
    // Production: Hide errors from users, log them instead
    error_reporting(E_ALL);
    ini_set('display_errors', '0');
    ini_set('display_startup_errors', '0');
    ini_set('log_errors', '1');
    ini_set('error_log', __DIR__ . '/../storage/logs/php_errors.log');
} else {
    // Development: Show all errors
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    ini_set('log_errors', '1');
    ini_set('error_log', __DIR__ . '/../storage/logs/php_errors.log');
}

// Set timezone
date_default_timezone_set('Africa/Lagos');

// Session security settings
ini_set('session.cookie_httponly', '1');
ini_set('session.cookie_secure', $isProduction ? '1' : '0');
ini_set('session.use_strict_mode', '1');
ini_set('session.cookie_samesite', 'Strict');

// Start session
session_start();

// CORS headers - Restrict in production
$allowedOrigins = $isProduction 
    ? ['https://nebatechacademy.com', 'https://www.nebatechacademy.com'] 
    : ['http://localhost', 'http://localhost:8080', 'http://127.0.0.1'];

$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
if (in_array($origin, $allowedOrigins)) {
    header('Access-Control-Allow-Origin: ' . $origin);
} elseif (!$isProduction) {
    header('Access-Control-Allow-Origin: *');
}

header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-CSRF-TOKEN');
header('Access-Control-Allow-Credentials: true');

// Security headers
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');

if ($isProduction) {
    header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
}

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Initialize router
$router = new \Nebatech\Core\Router();

// Register global middleware
$router->useGlobalMiddleware(\Nebatech\Middleware\CsrfMiddleware::class);

// Load routes
require_once __DIR__ . '/../routes/web.php';
require_once __DIR__ . '/../routes/api.php';

// Dispatch the request
try {
    $router->dispatch();
} catch (\Nebatech\Exceptions\CsrfTokenException $e) {
    // Handle CSRF token mismatch
    http_response_code(403);
    
    // Check if it's an AJAX request
    $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    
    if ($isAjax || strpos($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json') !== false) {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'CSRF token mismatch. Please refresh the page and try again.']);
    } else {
        // Redirect back with error message
        $_SESSION['error'] = 'Your session has expired. Please try again.';
        $referer = $_SERVER['HTTP_REFERER'] ?? '/';
        header('Location: ' . $referer);
    }
} catch (\Exception $e) {
    file_put_contents(__DIR__ . '/../storage/logs/dispatch.log', date('Y-m-d H:i:s') . " - Exception: " . $e->getMessage() . "\n" . $e->getTraceAsString() . "\n", FILE_APPEND);
    
    http_response_code(500);
    
    if ($_ENV['APP_DEBUG'] === 'true') {
        echo json_encode([
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
    } else {
        echo json_encode(['error' => 'Internal server error']);
    }
}
