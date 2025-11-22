<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$_SERVER['REQUEST_URI'] = '/community';
$_SERVER['REQUEST_METHOD'] = 'GET';

$router = new \Nebatech\Core\Router();

// Load routes
require_once __DIR__ . '/routes/web.php';

echo "REQUEST_URI: " . $_SERVER['REQUEST_URI'] . "\n";
echo "REQUEST_METHOD: " . $_SERVER['REQUEST_METHOD'] . "\n\n";

// Use reflection to see registered routes
$reflection = new ReflectionClass($router);
$property = $reflection->getProperty('routes');
$property->setAccessible(true);
$routes = $property->getValue($router);

echo "Registered routes (first 10):\n";
$count = 0;
foreach ($routes as $route) {
    echo "- {$route['method']} {$route['pattern']} -> ";
    if (is_array($route['handler'])) {
        echo $route['handler'][0] . '::' . $route['handler'][1];
    }
    echo "\n";
    if (++$count >= 10) break;
}

echo "\nTotal routes: " . count($routes) . "\n";
echo "\nDispatching...\n";
$router->dispatch();
