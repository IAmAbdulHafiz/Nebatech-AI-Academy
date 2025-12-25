<?php
// Test the URL helper function
chdir('c:/xampp/htdocs/Nebatech-AI-Academy/public');
$_SERVER['SCRIPT_NAME'] = '/Nebatech-AI-Academy/public/index.php';
require '../src/helpers.php';

echo "Generated URL: " . url('/ai-tutor/chat') . "\n";
