<?php

/**
 * Web Routes
 * Routes that return HTML views
 */

use Nebatech\Controllers\HomeController;
use Nebatech\Controllers\AuthController;
use Nebatech\Controllers\CourseController;

// Home
$router->get('/', [HomeController::class, 'index']);
$router->get('/about', [HomeController::class, 'about']);

// Authentication
$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/register', [AuthController::class, 'showRegister']);
$router->post('/register', [AuthController::class, 'register']);
$router->get('/logout', [AuthController::class, 'logout']);

// Courses
$router->get('/courses', [CourseController::class, 'index']);
$router->get('/courses/{slug}', [CourseController::class, 'show']);
