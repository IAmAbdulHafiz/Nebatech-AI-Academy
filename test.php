<?php
// Simple test to debug the issue

// Load Composer autoloader
require_once __DIR__ . '/vendor/autoload.php';

// Load helper functions
require_once __DIR__ . '/src/helpers.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Start session
session_start();

echo "<h1>Debug Test</h1>";

try {
    // Test database connection
    echo "<h2>Database Connection Test</h2>";
    $db = \Nebatech\Core\Database::connect();
    echo "✅ Database connected successfully<br>";
    
    // Test services table
    echo "<h2>Services Table Test</h2>";
    $stmt = $db->query("SELECT COUNT(*) FROM services");
    $count = $stmt->fetchColumn();
    echo "✅ Services table exists with {$count} records<br>";
    
    // Test PublicController
    echo "<h2>PublicController Test</h2>";
    $controller = new \Nebatech\Controllers\PublicController();
    echo "✅ PublicController instantiated<br>";
    
    // Test view method
    echo "<h2>View Method Test</h2>";
    ob_start();
    $result = $controller->home();
    $output = ob_get_clean();
    
    if (!empty($result)) {
        echo "✅ View method returned content (" . strlen($result) . " characters)<br>";
        echo "<h3>First 200 characters of output:</h3>";
        echo "<pre>" . htmlspecialchars(substr($result, 0, 200)) . "...</pre>";
    } else {
        echo "❌ View method returned empty content<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . "<br>";
    echo "Line: " . $e->getLine() . "<br>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
