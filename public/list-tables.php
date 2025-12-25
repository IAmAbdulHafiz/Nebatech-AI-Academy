<?php
require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$pdo = new PDO('mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);

echo "Tables containing 'progress' or 'enroll':\n";
$result = $pdo->query("SHOW TABLES");
while($row = $result->fetch(PDO::FETCH_NUM)) {
    $table = $row[0];
    if (stripos($table, 'progress') !== false || stripos($table, 'enroll') !== false) {
        echo "  " . $table . "\n";
    }
}

echo "\nAll tables:\n";
$result = $pdo->query("SHOW TABLES");
while($row = $result->fetch(PDO::FETCH_NUM)) {
    echo "  " . $row[0] . "\n";
}
