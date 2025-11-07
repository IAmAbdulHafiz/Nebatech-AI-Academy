<?php

/**
 * API Routes
 * Routes that return JSON responses
 */

use Nebatech\Controllers\Api\AuthApiController;
use Nebatech\Controllers\Api\CourseApiController;
use Nebatech\Controllers\Api\SubmissionApiController;

// API Authentication
$router->post('/api/auth/login', [AuthApiController::class, 'login']);
$router->post('/api/auth/register', [AuthApiController::class, 'register']);
$router->post('/api/auth/refresh', [AuthApiController::class, 'refresh']);

// API Courses
$router->get('/api/courses', [CourseApiController::class, 'index']);
$router->get('/api/courses/{id}', [CourseApiController::class, 'show']);
$router->post('/api/courses', [CourseApiController::class, 'store']);
$router->put('/api/courses/{id}', [CourseApiController::class, 'update']);
$router->delete('/api/courses/{id}', [CourseApiController::class, 'destroy']);

// API Submissions
$router->post('/api/submissions', [SubmissionApiController::class, 'store']);
$router->get('/api/submissions/{id}', [SubmissionApiController::class, 'show']);
$router->post('/api/submissions/{id}/grade', [SubmissionApiController::class, 'grade']);
