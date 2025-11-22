<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$_SERVER['REQUEST_URI'] = '/community';
$_SERVER['REQUEST_METHOD'] = 'GET';

require 'public/index.php';
