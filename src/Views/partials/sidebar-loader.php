<?php
/**
 * Smart Sidebar Loader
 * Loads the appropriate sidebar based on the current route and user role
 * This ensures consistent navigation across the platform
 */

// Get current path to determine context
$currentPath = $_SERVER['REQUEST_URI'] ?? '/';
$user = $user ?? $_SESSION['user_data'] ?? null;

// Determine which sidebar to load based on route context
// Admin routes take precedence over role-based detection
if (strpos($currentPath, '/admin/') !== false) {
    // Admin context - always show admin sidebar
    $sidebarFile = 'admin-sidebar.php';
} elseif (strpos($currentPath, '/facilitator/') !== false) {
    // Facilitator context - show facilitator sidebar
    $sidebarFile = 'facilitator-sidebar.php';
} elseif ($user) {
    // For other routes, use role-based detection
    $sidebarFile = match($user['role']) {
        'admin' => 'admin-sidebar.php',
        'facilitator' => 'facilitator-sidebar.php',
        default => 'student-sidebar.php'
    };
} else {
    // Fallback to student sidebar if no user
    $sidebarFile = 'student-sidebar.php';
}

// Include the determined sidebar
include __DIR__ . '/' . $sidebarFile;
