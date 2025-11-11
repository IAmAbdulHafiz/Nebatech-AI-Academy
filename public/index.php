<?php

/**
 * Nebatech AI Academy
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
if ($_ENV['APP_DEBUG'] === 'true') {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(0);
    ini_set('display_errors', '0');
}

// Set timezone
date_default_timezone_set('Africa/Lagos');

// Start session
session_start();

// CORS headers (adjust for production)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Initialize router
$router = new \Nebatech\Core\Router();

// Load routes
require_once __DIR__ . '/../routes/web.php';
require_once __DIR__ . '/../routes/api.php';

// Dispatch the request
try {
    $router->dispatch();
} catch (\Nebatech\Exceptions\AuthenticationException $e) {
    // Redirect to login for web requests, return JSON for API
    if (str_starts_with($_SERVER['REQUEST_URI'], '/api/')) {
        http_response_code(401);
        echo json_encode(['error' => $e->getMessage()]);
    } else {
        header('Location: ' . url('/login'));
    }
    exit;
} catch (\Nebatech\Exceptions\AuthorizationException $e) {
    http_response_code(403);
    if (str_starts_with($_SERVER['REQUEST_URI'], '/api/')) {
        echo json_encode(['error' => $e->getMessage()]);
    } else {
        echo '<h1>403 Forbidden</h1><p>' . htmlspecialchars($e->getMessage()) . '</p>';
    }
    exit;
} catch (\Nebatech\Exceptions\ValidationException $e) {
    http_response_code(422);
    echo json_encode([
        'error' => $e->getMessage(),
        'errors' => $e->getErrors()
    ]);
    exit;
} catch (\Nebatech\Exceptions\CsrfTokenException $e) {
    http_response_code(403);
    echo json_encode(['error' => $e->getMessage()]);
    exit;
} catch (\Nebatech\Exceptions\DatabaseConnectionException $e) {
    http_response_code(503);
    error_log('Database connection error: ' . $e->getMessage());
    
    if ($_ENV['APP_DEBUG'] === 'true') {
        echo json_encode(['error' => $e->getMessage()]);
    } else {
        echo json_encode(['error' => 'Service temporarily unavailable']);
    }
    exit;
} catch (\Exception $e) {
    http_response_code(500);
    error_log('Unhandled exception: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
    
    if ($_ENV['APP_DEBUG'] === 'true') {
        echo json_encode([
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
    } else {
        echo json_encode(['error' => 'Internal server error']);
    }
    exit;
}
