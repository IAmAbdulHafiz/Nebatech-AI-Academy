<?php
require_once __DIR__ . '/vendor/autoload.php';

use Nebatech\Core\Database;

// Generate correct password hash
$password = 'Password123!';
$hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

echo "Updating facilitator password...\n";
echo "New hash: $hash\n\n";

// Update the password
$sql = "UPDATE users SET password = :password WHERE email = :email";
$result = Database::query($sql, [
    'password' => $hash,
    'email' => 'facilitator@nebatech.com'
]);

if ($result) {
    echo "✅ Password updated successfully!\n";
    
    // Verify it works
    $user = Database::fetch("SELECT * FROM users WHERE email = 'facilitator@nebatech.com'");
    if ($user && password_verify($password, $user['password'])) {
        echo "✅ Password verification confirmed!\n";
    } else {
        echo "❌ Password verification failed!\n";
    }
} else {
    echo "❌ Failed to update password\n";
}

echo "\nYou can now login with:\n";
echo "Email: facilitator@nebatech.com\n";
echo "Password: Password123!\n";
