<?php

/**
 * API Routes
 * Routes that return JSON responses
 */

use Nebatech\Controllers\Api\AuthApiController;
use Nebatech\Controllers\Api\CourseApiController;
use Nebatech\Controllers\Api\SubmissionApiController;
use Nebatech\Controllers\API\DraftController;
use Nebatech\Controllers\API\PaymentController;
use Nebatech\Controllers\API\AITutorController;
use Nebatech\Controllers\Admin\ApplicationNotesController;

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

// Payment API - Hubtel Integration
$router->post('/api/payments/hubtel/callback', [PaymentController::class, 'hubtelCallback']);
$router->get('/api/payments/status', [PaymentController::class, 'checkStatus']);
$router->get('/api/payments/methods', [PaymentController::class, 'getMethods']);

// API Drafts (Community & Blog)
$router->post('/api/drafts/save', [DraftController::class, 'save']);
$router->get('/api/drafts', [DraftController::class, 'list']);
$router->delete('/api/drafts/{id}', [DraftController::class, 'delete']);
$router->post('/api/drafts/{id}/delete', [DraftController::class, 'delete']); // Alternative method

// Admin Application Notes
$router->post('/admin/applications/notes', [ApplicationNotesController::class, 'save']);
$router->get('/admin/applications/notes', [ApplicationNotesController::class, 'get']);

// ==========================================
// AI Tutor API Routes
// ==========================================

// Session Management
$router->post('/api/ai/session/start', [AITutorController::class, 'startSession']);
$router->post('/api/ai/session/end', [AITutorController::class, 'endSession']);

// Chat
$router->post('/api/ai/chat', [AITutorController::class, 'chat']);

// Code Review
$router->post('/api/ai/review-code', [AITutorController::class, 'reviewCode']);

// Practice Problems
$router->post('/api/ai/generate-practice', [AITutorController::class, 'generatePractice']);
$router->post('/api/ai/submit-practice', [AITutorController::class, 'submitPractice']);

// Learning Assistance
$router->get('/api/ai/recommendations', [AITutorController::class, 'getRecommendations']);
$router->post('/api/ai/explain', [AITutorController::class, 'explainConcept']);
$router->post('/api/ai/quick-action', [AITutorController::class, 'quickAction']);

// History & Profile
$router->get('/api/ai/history', [AITutorController::class, 'getHistory']);
$router->get('/api/ai/profile', [AITutorController::class, 'getProfile']);
$router->post('/api/ai/profile/update', [AITutorController::class, 'updateProfile']);
$router->get('/api/ai/usage', [AITutorController::class, 'getUsage']);
