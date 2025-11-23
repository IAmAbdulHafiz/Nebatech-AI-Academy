<?php

/**
 * PHPUnit Bootstrap File
 */

// Load Composer autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Load helper functions
require_once __DIR__ . '/../src/helpers.php';

// Load environment variables for testing
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Set test environment
$_ENV['APP_ENV'] = 'testing';
$_ENV['APP_DEBUG'] = 'true';

// Set timezone
date_default_timezone_set('Africa/Lagos');
