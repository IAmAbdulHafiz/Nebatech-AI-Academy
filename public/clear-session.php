<?php
/**
 * Emergency Session Cleanup Script
 * Use this to clear corrupted sessions
 * Access via: http://localhost/Nebatech-AI-Academy/clear-session.php
 */

// Start session
session_start();

// Clear all session data
$_SESSION = [];

// Destroy session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 42000, '/');
}

// Clear any remember me cookies
if (isset($_COOKIE['remember_token'])) {
    setcookie('remember_token', '', time() - 42000, '/', '', false, true);
}

// Destroy the session
session_destroy();

// Clear the session ID
session_write_close();

// Start a fresh session
session_start();
session_regenerate_id(true);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session Cleared - Nebatech AI Academy</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md text-center">
        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Session Cleared Successfully!</h1>
        <p class="text-gray-600 mb-6">Your session has been completely cleared. All corrupted data has been removed.</p>
        
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6 text-left text-sm">
            <p class="font-semibold text-blue-900 mb-2">What was cleared:</p>
            <ul class="list-disc list-inside text-blue-800 space-y-1">
                <li>Session variables</li>
                <li>Session cookies</li>
                <li>Remember me tokens</li>
            </ul>
        </div>
        
        <div class="space-y-2">
            <a href="/Nebatech-AI-Academy/" 
               class="block bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-lg transition">
                Go to Homepage
            </a>
            <a href="/Nebatech-AI-Academy/login" 
               class="block bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-3 px-6 rounded-lg transition">
                Go to Login
            </a>
        </div>
        
        <p class="text-xs text-gray-500 mt-6">
            You can now login normally without redirect loops.
        </p>
    </div>
</body>
</html>
