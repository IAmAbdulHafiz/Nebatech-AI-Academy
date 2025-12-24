<?php
/**
 * Debug URL Generation - simulating router behavior
 */

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/helpers.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Simulate router URI parsing (copy of logic from Router.php)
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$scriptName = $_SERVER['SCRIPT_NAME']; 
$scriptDir = dirname($scriptName); 

// Get the application base (one level up from public)
$baseParts = explode('/', trim($scriptDir, '/'));
array_pop($baseParts); // Remove 'public'
$appBase = '/' . implode('/', $baseParts); 

// Strip the application base from the request URI
$uri = $requestUri;
if ($appBase !== '/' && $appBase !== '' && strpos($uri, $appBase) === 0) {
    $uri = substr($uri, strlen($appBase));
}

// Also strip /public from the URI if present
if (strpos($uri, '/public') === 0) {
    $uri = substr($uri, 7);
}

// Ensure the URI starts with /
if (empty($uri) || $uri[0] !== '/') {
    $uri = '/' . $uri;
}

// Remove trailing slash (except for root)
if ($uri !== '/' && substr($uri, -1) === '/') {
    $uri = rtrim($uri, '/');
}

echo "=== Router Debug ===\n";
echo "REQUEST_URI: " . $requestUri . "\n";
echo "SCRIPT_NAME: " . $scriptName . "\n";
echo "scriptDir: " . $scriptDir . "\n";
echo "appBase: " . $appBase . "\n";
echo "Final URI: " . $uri . "\n";
echo "\n";
echo "--- URL Helper Debug ---\n";
echo "base_url(): " . base_url() . "\n";
echo "url('/courses/frontend/learn'): " . url('/courses/frontend/learn') . "\n";
