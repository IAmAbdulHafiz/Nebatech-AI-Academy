<?php

/**
 * Admin User Seeder
 * Creates an admin user for the platform
 */

require_once __DIR__ . '/../../vendor/autoload.php';

use Nebatech\Core\Database;
use Nebatech\Models\User;

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

Database::connect();

echo "Creating Admin User...\n";
echo str_repeat("=", 80) . "\n\n";

// Check if admin already exists
$adminEmail = 'admin@nebatech.com';
$existingAdmin = User::findByEmail($adminEmail);

if ($existingAdmin) {
    echo "✓ Admin user already exists!\n";
    echo "  Email: {$existingAdmin['email']}\n";
    echo "  Name: {$existingAdmin['first_name']} {$existingAdmin['last_name']}\n";
    echo "  Role: {$existingAdmin['role']}\n";
} else {
    // Create admin user
    try {
        $adminId = User::createUser([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => $adminEmail,
            'password' => password_hash('Admin123!', PASSWORD_BCRYPT, ['cost' => 12]),
            'role' => 'admin',
            'email_verified_at' => date('Y-m-d H:i:s')
        ]);

        if ($adminId) {
            echo "✓ Admin user created successfully!\n\n";
            echo "Admin Credentials:\n";
            echo str_repeat("-", 80) . "\n";
            echo "Email: admin@nebatech.com\n";
            echo "Password: Admin123!\n";
            echo "Role: admin\n";
            echo str_repeat("-", 80) . "\n";
        } else {
            echo "✗ Failed to create admin user (returned null/false)\n";
            exit(1);
        }
    } catch (Exception $e) {
        echo "✗ Error creating admin user: " . $e->getMessage() . "\n";
        echo "Stack trace: " . $e->getTraceAsString() . "\n";
        exit(1);
    }
}

echo "\n" . str_repeat("=", 80) . "\n";
echo "User Credentials Summary:\n";
echo str_repeat("=", 80) . "\n\n";

echo "ADMIN:\n";
echo "  Email: admin@nebatech.com\n";
echo "  Password: Admin123!\n\n";

echo "FACILITATOR:\n";
echo "  Email: facilitator@nebatech.com\n";
echo "  Password: Password123!\n\n";

echo "STUDENT:\n";
echo "  Email: abdulhafiz@nebatech.com\n";
echo "  Password: Password123!\n\n";

echo str_repeat("=", 80) . "\n";
