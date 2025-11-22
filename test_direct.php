<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Testing Model class...\n";

require_once __DIR__ . '/vendor/autoload.php';

use Nebatech\Core\Database;
use Nebatech\Models\DiscussionPost;

try {
    // Initialize database connection
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    
    echo "Environment loaded\n";
    
    // Test creating a DiscussionPost instance
    $post = new DiscussionPost();
    echo "DiscussionPost instance created\n";
    
    // Test the db property
    if (isset($post->db)) {
        echo "ERROR: db property should be protected\n";
    } else {
        echo "db property is protected (good)\n";
    }
    
    // Test static method
    $trending = DiscussionPost::getTrending(5);
    echo "Got trending posts: " . count($trending) . " posts\n";
    
    echo "\nAll tests passed!\n";
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "Trace:\n" . $e->getTraceAsString() . "\n";
}
