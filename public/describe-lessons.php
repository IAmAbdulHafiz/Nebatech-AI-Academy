<?php
require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();
$db = Nebatech\Core\Database::connect();

echo "<h2>Modules Table Structure</h2><pre>";
$stmt = $db->query("DESCRIBE modules");
$columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($columns as $col) {
    echo "{$col['Field']} - {$col['Type']}\n";
}
echo "</pre>";

echo "<h2>Lessons Table Structure</h2><pre>";
$stmt = $db->query("DESCRIBE lessons");
$columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($columns as $col) {
    echo "{$col['Field']} - {$col['Type']}\n";
}
echo "</pre>";
