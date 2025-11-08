<?php
// Test password verification
$password = 'Password123!';
$hash = '$2y$12$LQv3c1yduTi6jW.PFKEqKOHKIvVh9jhQjKLfqYJkJqQdGKQXdYmTO';

echo "Testing password verification...\n";
echo "Password: $password\n";
echo "Hash: $hash\n\n";

if (password_verify($password, $hash)) {
    echo "✅ Password MATCHES!\n";
} else {
    echo "❌ Password DOES NOT match!\n";
    echo "\nGenerating new hash...\n";
    $newHash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    echo "New hash: $newHash\n";
}
