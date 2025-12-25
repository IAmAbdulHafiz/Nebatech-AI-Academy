<?php
require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$pdo = new PDO('mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);

echo "milestones columns:\n";
$result = $pdo->query('SHOW COLUMNS FROM milestones');
while($row = $result->fetch()) { 
    echo "  " . $row['Field'] . "\n"; 
}
