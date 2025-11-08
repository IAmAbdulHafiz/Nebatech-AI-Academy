<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Nebatech\Core\Database;

Database::connect();

$stmt = Database::query('DESCRIBE users');
$columns = $stmt->fetchAll();

echo "Users table structure:\n";
echo str_repeat("=", 80) . "\n";
printf("%-30s %-20s %-10s %-10s\n", "Field", "Type", "Null", "Default");
echo str_repeat("=", 80) . "\n";

foreach ($columns as $col) {
    printf("%-30s %-20s %-10s %-10s\n", 
        $col['Field'], 
        $col['Type'], 
        $col['Null'],
        $col['Default'] ?? 'NULL'
    );
}
