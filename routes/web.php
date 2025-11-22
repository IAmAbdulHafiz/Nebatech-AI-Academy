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
use Nebatech\Controllers\NewsletterController;
use Nebatech\Controllers\SitemapController;
use Nebatech\Controllers\DashboardController;
use Nebatech\Controllers\FacilitatorController;
use Nebatech\Controllers\AIController;
use Nebatech\Controllers\CodeEditorController;
use Nebatech\Controllers\FeedbackController;
use Nebatech\Controllers\NotificationController;
use Nebatech\Controllers\ApplicationController;
use Nebatech\Controllers\CommunityController;
use Nebatech\Controllers\ResourceController;
use Nebatech\Controllers\EventController;

// Home
$router->get('/', [HomeController::class, 'index']);
$router->get('/about', [HomeController::class, 'about']);

// SEO
$router->get('/sitemap.xml', [SitemapController::class, 'generate']);
$router->get('/robots.txt', [SitemapController::class, 'robots']);

// Public Pages
$router->get('/team', [HomeController::class, 'team']);
$router->get('/services', [HomeController::class, 'services']);
$router->get('/portfolio', [HomeController::class, 'portfolio']);
$router->get('/faqs', [HomeController::class, 'faqs']);
$router->get('/testimonials', [HomeController::class, 'testimonials']);
$router->get('/sitemap', [HomeController::class, 'sitemap']);
$router->get('/corporate', [HomeController::class, 'corporate']);
$router->get('/career-services', [HomeController::class, 'careerServices']);
$router->get('/support', [HomeController::class, 'support']);
$router->get('/forum', [CommunityController::class, 'index']);
$router->get('/live-chat', [HomeController::class, 'liveChat']);
$router->get('/accessibility', [HomeController::class, 'accessibility']);

// Legal Pages
$router->get('/privacy', [HomeController::class, 'privacy']);
$router->get('/terms', [HomeController::class, 'terms']);
$router->get('/cookie-policy', [HomeController::class, 'cookiePolicy']);
$router->get('/refund-policy', [HomeController::class, 'refundPolicy']);
$router->get('/code-of-conduct', [HomeController::class, 'codeOfConduct']);

// Community Routes
$router->get('/community', [CommunityController::class, 'index']);
$router->get('/community/discussions', [CommunityController::class, 'discussions']);
$router->get('/community/guidelines', [CommunityController::class, 'guidelines']);
$router->get('/community/create', [CommunityController::class, 'create']);
$router->post('/community/create', [CommunityController::class, 'store']);
$router->get('/community/category/{slug}', [CommunityController::class, 'category']);
$router->get('/community/post/{uuid}', [CommunityController::class, 'show']);
$router->post('/community/post/{uuid}/comment', [CommunityController::class, 'addComment']);
$router->post('/community/post/{uuid}/like', [CommunityController::class, 'toggleLike']);
$router->post('/community/post/{uuid}/solution', [CommunityController::class, 'markSolution']);
$router->get('/community/search', [CommunityController::class, 'search']);
$router->get('/community/profile/{userId}', [CommunityController::class, 'profile']);
$router->post('/community/profile/{userId}/follow', [CommunityController::class, 'followUser']);
$router->get('/community/leaderboard', [CommunityController::class, 'leaderboard']);

// Resource Routes
$router->get('/community/resources', [ResourceController::class, 'index']);
$router->get('/community/resources/create', [ResourceController::class, 'create']);
$router->post('/community/resources/create', [ResourceController::class, 'store']);
$router->get('/community/resources/{uuid}', [ResourceController::class, 'show']);
$router->get('/community/resources/{uuid}/download', [ResourceController::class, 'download']);

// Event Routes
$router->get('/community/events', [EventController::class, 'index']);
$router->get('/community/events/create', [EventController::class, 'create']);
$router->post('/community/events/create', [EventController::class, 'store']);
$router->get('/community/events/{uuid}', [EventController::class, 'show']);
$router->post('/community/events/{uuid}/rsvp', [EventController::class, 'rsvp']);
$router->get('/faqs', [HomeController::class, 'faqs']);

// Blog
$router->get('/blog', [BlogController::class, 'index']);
$router->get('/blog/{slug}', [BlogController::class, 'show']);
$router->post('/blog/comment', [BlogController::class, 'comment']);

// Newsletter
$router->post('/newsletter/subscribe', [NewsletterController::class, 'subscribe']);
$router->get('/newsletter/unsubscribe', [NewsletterController::class, 'unsubscribe']);

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

// Application & Admissions Routes
// Student application routes
$router->get('/apply/{programSlug}', [ApplicationController::class, 'apply']);
$router->post('/applications/submit', [ApplicationController::class, 'submit']);
$router->get('/applications/my', [ApplicationController::class, 'myApplications']);
$router->get('/applications/{uuid}', [ApplicationController::class, 'view']);

// Admin application management routes
$router->get('/admin/applications', [ApplicationController::class, 'adminDashboard']);
$router->get('/admin/applications/{id}/review', [ApplicationController::class, 'review']);
$router->post('/admin/applications/approve', [ApplicationController::class, 'approve']);
$router->post('/admin/applications/reject', [ApplicationController::class, 'reject']);
$router->post('/admin/applications/waitlist', [ApplicationController::class, 'waitlist']);
$router->post('/admin/applications/priority', [ApplicationController::class, 'updatePriority']);

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
