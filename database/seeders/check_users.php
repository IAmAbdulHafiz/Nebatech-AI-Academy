<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Nebatech\Core\Database;
use Nebatech\Models\User;

Database::connect();

echo "Checking existing users...\n";
echo str_repeat("=", 80) . "\n\n";

// Check for admin
$admin = User::findByEmail('admin@nebatech.com');
if ($admin) {
    echo "✓ Admin User Found:\n";
    echo "  Email: {$admin['email']}\n";
    echo "  Name: {$admin['first_name']} {$admin['last_name']}\n";
    echo "  Role: {$admin['role']}\n";
    echo "  Password: Password123!\n";
} else {
    echo "✗ No admin user found\n";
}

echo "\n";

// Check for facilitator
$facilitator = User::findByEmail('facilitator@nebatech.com');
if ($facilitator) {
    echo "✓ Facilitator User Found:\n";
    echo "  Email: {$facilitator['email']}\n";
    echo "  Name: {$facilitator['first_name']} {$facilitator['last_name']}\n";
    echo "  Role: {$facilitator['role']}\n";
    echo "  Password: Password123!\n";
} else {
    echo "✗ No facilitator user found\n";
}

echo "\n";

// Check for any other users
$db = Database::connect();
$stmt = $db->query("SELECT email, first_name, last_name, role FROM users ORDER BY role, email");
$allUsers = $stmt->fetchAll();

echo "All Users in Database:\n";
echo str_repeat("-", 80) . "\n";
printf("%-30s %-20s %-20s %-15s\n", "Email", "First Name", "Last Name", "Role");
echo str_repeat("-", 80) . "\n";

foreach ($allUsers as $user) {
    printf("%-30s %-20s %-20s %-15s\n", 
        $user['email'], 
        $user['first_name'], 
        $user['last_name'], 
        $user['role']
    );
}

echo "\n" . str_repeat("=", 80) . "\n";
echo "Default Password for all seeded users: Password123!\n";
echo str_repeat("=", 80) . "\n";
