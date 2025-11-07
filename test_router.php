<?php

require_once __DIR__ . '/vendor/autoload.php';

$router = new \Nebatech\Core\Router();

// Add a test route
$router->get('/', function() {
    return 'Home route works!';
});

echo "Routes registered: " . var_export($router, true) . "\n";
