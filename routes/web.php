<?php

/**
 * Web Routes
 * Routes that return HTML views
 */

use Nebatech\Controllers\HomeController;
use Nebatech\Controllers\AuthController;
use Nebatech\Controllers\CourseController;
use Nebatech\Controllers\BlogController;
use Nebatech\Controllers\ContactController;
use Nebatech\Controllers\DashboardController;
use Nebatech\Controllers\FacilitatorController;
use Nebatech\Controllers\AIController;
use Nebatech\Controllers\CodeEditorController;
use Nebatech\Controllers\FeedbackController;
use Nebatech\Controllers\NotificationController;

// Home
$router->get('/', [HomeController::class, 'index']);
$router->get('/about', [HomeController::class, 'about']);

// Blog
$router->get('/blog', [BlogController::class, 'index']);
$router->get('/blog/{slug}', [BlogController::class, 'show']);

// Contact
$router->get('/contact', [ContactController::class, 'index']);
$router->post('/contact', [ContactController::class, 'submit']);

// Authentication
$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/register', [AuthController::class, 'showRegister']);
$router->post('/register', [AuthController::class, 'register']);
$router->get('/logout', [AuthController::class, 'logout']);

// Dashboard (protected routes)
$router->get('/dashboard', [DashboardController::class, 'index']);

// Facilitator Routes (protected)
$router->get('/facilitator/dashboard', [FacilitatorController::class, 'dashboard']);
$router->get('/facilitator/courses/create', [FacilitatorController::class, 'createCourse']);
$router->post('/facilitator/courses/create', [FacilitatorController::class, 'storeCourse']);
$router->get('/facilitator/courses/{id}/edit', [FacilitatorController::class, 'editCourse']);
$router->post('/facilitator/courses/{id}/edit', [FacilitatorController::class, 'updateCourse']);
$router->post('/facilitator/courses/{id}/publish', [FacilitatorController::class, 'publishCourse']);
$router->post('/facilitator/courses/{id}/modules', [FacilitatorController::class, 'addModule']);
$router->post('/facilitator/modules/{id}/lessons', [FacilitatorController::class, 'addLesson']);

// Facilitator Submission Review Routes
$router->get('/facilitator/submissions', [FacilitatorController::class, 'submissions']);
$router->get('/facilitator/submissions/{id}/review', [FacilitatorController::class, 'reviewSubmission']);
$router->post('/facilitator/submissions/update', [FacilitatorController::class, 'updateSubmission']);

// AI Generation Routes (facilitator only)
$router->post('/ai/generate-course-outline', [AIController::class, 'generateCourseOutline']);
$router->post('/ai/generate-lesson-content', [AIController::class, 'generateLessonContent']);
$router->post('/ai/generate-project-brief', [AIController::class, 'generateProjectBrief']);
$router->post('/ai/generate-complete-course', [AIController::class, 'generateCompleteCourse']);
$router->post('/ai/generate-quiz', [AIController::class, 'generateQuiz']);

// Code Editor Routes (student access)
$router->get('/code-editor', [CodeEditorController::class, 'index']);
$router->get('/lessons/{id}/code-editor', [CodeEditorController::class, 'index']);
$router->get('/assignments/{id}/code-editor', [CodeEditorController::class, 'assignment']);
$router->post('/assignments/submit', [CodeEditorController::class, 'submitAssignment']);
$router->post('/assignments/save', [CodeEditorController::class, 'saveSubmission']);
$router->get('/assignments/{id}/load-code', [CodeEditorController::class, 'loadCode']);

// Feedback Routes
$router->get('/submissions/{id}/feedback', [FeedbackController::class, 'view']);
$router->get('/api/submissions/{id}/feedback', [FeedbackController::class, 'getFeedback']);
$router->post('/api/submissions/{id}/regenerate-feedback', [FeedbackController::class, 'regenerate']);
$router->post('/api/feedback/batch-generate', [FeedbackController::class, 'generateBatch']);

// Notification Routes
$router->get('/settings/notifications', [NotificationController::class, 'preferences']);
$router->post('/notifications/update', [NotificationController::class, 'updatePreferences']);
$router->post('/notifications/test-email', [NotificationController::class, 'testEmail']);
$router->post('/notifications/process-queue', [NotificationController::class, 'processQueue']);
$router->get('/admin/email-queue', [NotificationController::class, 'queueStatus']);
$router->post('/notifications/retry-email', [NotificationController::class, 'retryEmail']);

// Portfolio Routes
use Nebatech\Controllers\PortfolioController;

// Public portfolio view
$router->get('/portfolio/{username}', [PortfolioController::class, 'show']);

// Portfolio management (student access)
$router->get('/portfolio/manage', [PortfolioController::class, 'manage']);
$router->post('/portfolio/settings', [PortfolioController::class, 'updateSettings']);

// Portfolio items CRUD (AJAX)
$router->post('/portfolio/items/add', [PortfolioController::class, 'addItem']);
$router->post('/portfolio/items/update', [PortfolioController::class, 'updateItem']);
$router->post('/portfolio/items/delete', [PortfolioController::class, 'deleteItem']);

// Individual project view
$router->get('/portfolio/items/{id}', [PortfolioController::class, 'viewItem']);

// Certificate generation and management
$router->post('/certificates/generate', [PortfolioController::class, 'generateCertificate']);
$router->get('/certificates/{id}/download', [PortfolioController::class, 'downloadCertificate']);
$router->get('/certificates/verify/{code}', [PortfolioController::class, 'verifyCertificate']);

// Courses
$router->get('/courses', [CourseController::class, 'index']);

// Course Categories
$router->get('/courses/frontend', [CourseController::class, 'frontend']);
$router->get('/courses/backend', [CourseController::class, 'backend']);
$router->get('/courses/fullstack', [CourseController::class, 'fullstack']);
$router->get('/courses/mobile', [CourseController::class, 'mobile']);
$router->get('/courses/ai', [CourseController::class, 'ai']);
$router->get('/courses/data-science', [CourseController::class, 'dataScience']);
$router->get('/courses/cybersecurity', [CourseController::class, 'cybersecurity']);
$router->get('/courses/cloud', [CourseController::class, 'cloud']);

// Individual Course
$router->get('/courses/{slug}', [CourseController::class, 'show']);
