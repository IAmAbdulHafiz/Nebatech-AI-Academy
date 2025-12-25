<?php
/**
 * Test the AI Tutor chat endpoint via a simulated authenticated request
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Check if there's an active session
if (!isset($_SESSION['user_id'])) {
    echo "<h2>No session found</h2>\n";
    echo "<p>Please <a href='/login'>log in</a> first, then visit this page again.</p>\n";
    echo "<pre>";
    print_r($_SESSION);
    echo "</pre>";
    exit;
}

echo "<h2>Session Found</h2>\n";
echo "<pre>";
echo "user_id: " . ($_SESSION['user_id'] ?? 'NOT SET') . "\n";
echo "user_role: " . ($_SESSION['user_role'] ?? 'NOT SET') . "\n";
echo "user_name: " . ($_SESSION['user_name'] ?? 'NOT SET') . "\n";
echo "</pre>";

echo "<h2>Testing Direct Service Call</h2>\n";

// Load autoload and dotenv
require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

try {
    $service = new \Nebatech\Services\AITutorService();
    echo "<p>✓ Service created</p>\n";
    
    $response = $service->askQuestion(
        $_SESSION['user_id'],
        "What is programming?",
        [],
        'mentor'
    );
    
    echo "<p>✓ Got response from AI</p>\n";
    echo "<pre>" . htmlspecialchars(print_r($response, true)) . "</pre>";
    
} catch (\Exception $e) {
    echo "<p>❌ Error: " . htmlspecialchars($e->getMessage()) . "</p>\n";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
}

echo "<h2>Now testing your chat...</h2>\n";
echo "<p>Go to <a href='/ai-tutor'>/ai-tutor</a> and try sending a message.</p>\n";
echo "<p>Open the browser's Developer Tools (F12) → Network tab to see the actual request/response.</p>\n";
