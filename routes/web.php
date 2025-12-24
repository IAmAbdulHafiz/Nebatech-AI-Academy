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
use Nebatech\Controllers\AdminController;
use Nebatech\Controllers\AIController;
use Nebatech\Controllers\CodeEditorController;
use Nebatech\Controllers\FeedbackController;
use Nebatech\Controllers\NotificationController;
use Nebatech\Controllers\ApplicationController;
use Nebatech\Controllers\CommunityController;
use Nebatech\Controllers\ResourceController;
use Nebatech\Controllers\EventController;
use Nebatech\Controllers\EnrollmentController;
use Nebatech\Controllers\PortfolioController;
use Nebatech\Controllers\Academic;
use Nebatech\Controllers\User;

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

// Student Routes (protected)
$router->get('/my-courses', [DashboardController::class, 'myCourses']);
$router->get('/my-cohorts', [DashboardController::class, 'myCohorts']);
$router->get('/progress/dashboard', [Academic\ProgressController::class, 'dashboard']);
$router->get('/progress/bookmarks', [Academic\ProgressController::class, 'bookmarks']);

// Progress API Routes (AJAX endpoints for lesson tracking)
$router->post('/api/progress/mark-complete', [Academic\ProgressController::class, 'markLessonComplete']);
$router->post('/api/progress/update', [Academic\ProgressController::class, 'updateLessonProgress']);
$router->post('/api/progress/track-time', [Academic\ProgressController::class, 'trackTime']);
$router->post('/api/progress/toggle-bookmark', [Academic\ProgressController::class, 'toggleBookmark']);
$router->post('/api/progress/save-notes', [Academic\ProgressController::class, 'saveNotes']);
$router->get('/my-applications', [ApplicationController::class, 'myApplications']);
$router->get('/my-portfolio', [PortfolioController::class, 'myPortfolio']);
$router->get('/my-certificates', [PortfolioController::class, 'myCertificates']);
$router->get('/playground', [CodeEditorController::class, 'playground']);
$router->get('/showcase', [PortfolioController::class, 'showcase']);

// Profile, Settings & Notifications
$router->get('/profile', [Academic\DashboardController::class, 'profile']);
$router->post('/profile/update', [Academic\DashboardController::class, 'updateProfile']);
$router->post('/profile/avatar', [Academic\DashboardController::class, 'uploadAvatar']);
$router->get('/settings', [User\SettingsController::class, 'index']);
$router->post('/settings/update', [User\SettingsController::class, 'update']);
$router->post('/settings/password', [User\SettingsController::class, 'changePassword']);
$router->post('/settings/editor', [User\SettingsController::class, 'updateEditor']);
$router->get('/notifications', [NotificationController::class, 'index']);
$router->get('/help-center', [DashboardController::class, 'helpCenter']);

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

// Facilitator Cohort Routes
use Nebatech\Controllers\CohortController;

$router->get('/facilitator/cohorts', [CohortController::class, 'index']);
$router->get('/facilitator/cohorts/create', [CohortController::class, 'create']);
$router->post('/facilitator/cohorts/create', [CohortController::class, 'store']);
$router->get('/facilitator/cohorts/{id}', [CohortController::class, 'show']);
$router->post('/facilitator/cohorts/submit-approval', [CohortController::class, 'submitForApproval']);
$router->get('/facilitator/cohorts/{id}/invite', [CohortController::class, 'inviteForm']);
$router->post('/facilitator/cohorts/invite', [CohortController::class, 'sendInvitations']);
$router->post('/facilitator/cohorts/resend-invitation', [CohortController::class, 'resendInvitation']);
$router->post('/facilitator/cohorts/cancel-invitation', [CohortController::class, 'cancelInvitation']);
$router->post('/facilitator/cohorts/remove-member', [CohortController::class, 'removeMember']);
$router->post('/facilitator/cohorts/add-course', [CohortController::class, 'addCourse']);
$router->post('/facilitator/cohorts/remove-course', [CohortController::class, 'removeCourse']);

// Cohort Invitation Routes (Public/Student)
$router->get('/cohort/accept-invitation', [CohortController::class, 'acceptInvitation']);
$router->post('/cohort/decline-invitation', [CohortController::class, 'declineInvitation']);

// Admin Routes (protected)
$router->get('/admin/dashboard', [AdminController::class, 'dashboard']);
$router->get('/admin/users', [AdminController::class, 'users']);
$router->get('/admin/courses', [AdminController::class, 'courses']);
$router->get('/admin/enrollments', [AdminController::class, 'enrollments']);
$router->get('/admin/certificates', [AdminController::class, 'certificates']);
$router->get('/admin/certificates/issue', [AdminController::class, 'issueCertificate']);
$router->get('/admin/approvals', [AdminController::class, 'approvals']);

// AI Generation Routes (facilitator only)
$router->post('/ai/generate-course-outline', [AIController::class, 'generateCourseOutline']);
$router->post('/ai/generate-lesson-content', [AIController::class, 'generateLessonContent']);
$router->post('/ai/generate-project-brief', [AIController::class, 'generateProjectBrief']);
$router->post('/ai/generate-complete-course', [AIController::class, 'generateCompleteCourse']);
$router->post('/ai/generate-quiz', [AIController::class, 'generateQuiz']);

// Code Editor Routes (student access)
// Note: /code-editor is deprecated, use /playground instead which now has all features
// Redirect old code-editor URLs to playground
$router->get('/code-editor', function() {
    header('Location: /playground');
    exit;
});
$router->get('/lessons/{id}/code-editor', function($id) {
    header('Location: /playground?lesson=' . $id);
    exit;
});
$router->get('/assignments/{id}/code-editor', [CodeEditorController::class, 'assignment']);
$router->post('/assignments/submit', [CodeEditorController::class, 'submitAssignment']);
$router->post('/assignments/save', [CodeEditorController::class, 'saveSubmission']);
$router->get('/assignments/{id}/load-code', [CodeEditorController::class, 'loadCode']);
$router->post('/code/execute', [CodeEditorController::class, 'executeCode']);

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
$router->get('/applications/{uuid}', [ApplicationController::class, 'viewApplication']);

// Admin application management routes
$router->get('/admin/applications', [ApplicationController::class, 'adminDashboard']);
$router->get('/admin/applications/{id}/review', [ApplicationController::class, 'review']);
$router->post('/admin/applications/approve', [ApplicationController::class, 'approve']);
$router->post('/admin/applications/reject', [ApplicationController::class, 'reject']);
$router->post('/admin/applications/waitlist', [ApplicationController::class, 'waitlist']);
$router->post('/admin/applications/priority', [ApplicationController::class, 'updatePriority']);

// Courses
$router->get('/courses', [CourseController::class, 'index']);

// Course Enrollment Routes
$router->get('/courses/{slug}/enroll', [EnrollmentController::class, 'show']);
$router->post('/courses/{slug}/enroll', [EnrollmentController::class, 'process']);

// Course Learning Routes (for enrolled students)
$router->get('/courses/{slug}/learn', [CourseController::class, 'learn']);
$router->get('/courses/{slug}/lesson/{lessonId}', [CourseController::class, 'lesson']);

// Payment Routes (Hubtel Integration)
$router->get('/payments/success', [EnrollmentController::class, 'success']);
$router->get('/payments/cancelled', [EnrollmentController::class, 'cancelled']);
$router->get('/payments/status', [EnrollmentController::class, 'checkStatus']);

// Individual Course (dynamic from database)
$router->get('/courses/{slug}', [CourseController::class, 'show']);
