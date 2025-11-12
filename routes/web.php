<?php

/**
 * Web Routes
 * Routes that return HTML views
 */

use Nebatech\Controllers\Public\PublicController;
use Nebatech\Controllers\Public\ServiceController;
use Nebatech\Controllers\Public\ProgrammeController;
use Nebatech\Controllers\User\AuthController;
use Nebatech\Controllers\Academic\CourseController;
use Nebatech\Controllers\Public\BlogController;
use Nebatech\Controllers\Public\ContactController;
use Nebatech\Controllers\Academic\DashboardController;
use Nebatech\Controllers\Admin\FacilitatorController;
use Nebatech\Controllers\System\AIController;
use Nebatech\Controllers\Admin\AdminController;
use Nebatech\Controllers\Academic\ApplicationController;
use Nebatech\Controllers\User\PortfolioController;
use Nebatech\Controllers\Academic\CertificateController;
use Nebatech\Controllers\System\CodeExecutionController;
use Nebatech\Controllers\Academic\SubmissionController;
use Nebatech\Controllers\Academic\ProgressController;
use Nebatech\Controllers\System\NotificationController;
use Nebatech\Controllers\System\SearchController;
use Nebatech\Middleware\AuthMiddleware;
use Nebatech\Middleware\RoleMiddleware;
use Nebatech\Middleware\CsrfMiddleware;
use Nebatech\Middleware\RateLimitMiddleware;

// Debug route
$router->get('/debug', function() {
    return '<h1>Debug Route Works!</h1><p>Router is functioning correctly.</p>';
});

// Public Pages
$router->get('/', [PublicController::class, 'home']);
$router->get('/about', [PublicController::class, 'about']);
$router->get('/projects', [PublicController::class, 'projects']);
$router->get('/faq', [PublicController::class, 'faq']);

// Services
$router->get('/services', [ServiceController::class, 'index']);
$router->get('/services/{slug}', [ServiceController::class, 'show']);
$router->get('/request-quote', [ServiceController::class, 'requestQuote']);
$router->post('/request-quote', [ServiceController::class, 'submitRequest'], [CsrfMiddleware::class, RateLimitMiddleware::class]);

// Training Programmes (Unified Navigation)
$router->get('/programmes', [ProgrammeController::class, 'index']);
$router->get('/training', function() { 
    // Alias for /programmes for unified navigation
    header('Location: ' . url('/programmes'), true, 301);
    exit;
});
$router->get('/academy', function() {
    // Academy homepage - redirect to dashboard if logged in, otherwise programmes
    if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
        header('Location: ' . url('/dashboard'), true, 302);
    } else {
        header('Location: ' . url('/programmes'), true, 302);
    }
    exit;
});
$router->get('/programmes/category/{category}', [ProgrammeController::class, 'category']);
$router->get('/programmes/{slug}', [ProgrammeController::class, 'show']);
$router->post('/programmes/{id}/enroll', [ProgrammeController::class, 'enroll'], [AuthMiddleware::class]);

// Blog
$router->get('/blog', [BlogController::class, 'index']);
$router->get('/blog/{slug}', [BlogController::class, 'show']);

// Contact
$router->get('/contact', [ContactController::class, 'index']);
$router->post('/contact', [ContactController::class, 'submit'], [CsrfMiddleware::class, RateLimitMiddleware::class]);

// Unified Search
$router->get('/search', [SearchController::class, 'index']);
$router->get('/search/suggestions', [SearchController::class, 'suggestions']);
$router->get('/search/ajax', [SearchController::class, 'ajax']);
$router->get('/search/related', [SearchController::class, 'related']);
$router->get('/search/category/{category}', [SearchController::class, 'category']);

// Authentication
$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login'], [RateLimitMiddleware::class]);
$router->get('/register', [AuthController::class, 'showRegister']);
$router->post('/register', [AuthController::class, 'register'], [RateLimitMiddleware::class]);
$router->get('/verify-email', [AuthController::class, 'verifyEmail']);
$router->get('/logout', [AuthController::class, 'logout'], [AuthMiddleware::class, CsrfMiddleware::class]);

// Dashboard (authenticated - role-based redirect in controller)
$router->get('/dashboard', [DashboardController::class, 'index'], [AuthMiddleware::class]);

// Student-specific routes
$router->get('/my-courses', [DashboardController::class, 'myCourses'], [RoleMiddleware::student()]);
$router->get('/my-cohorts', [DashboardController::class, 'myCohorts'], [RoleMiddleware::student()]);
$router->get('/cohorts/{id}', [DashboardController::class, 'viewCohort'], [RoleMiddleware::student()]);

// Profile & Settings (all authenticated users)
$router->get('/profile', [DashboardController::class, 'profile'], [RoleMiddleware::authenticated()]);
$router->post('/profile/update', [DashboardController::class, 'updateProfile'], [RoleMiddleware::authenticated(), CsrfMiddleware::class]);
$router->post('/profile/upload-avatar', [DashboardController::class, 'uploadAvatar'], [RoleMiddleware::authenticated(), CsrfMiddleware::class]);
$router->get('/settings', [DashboardController::class, 'settings'], [RoleMiddleware::authenticated()]);
$router->post('/settings/update', [DashboardController::class, 'updateSettings'], [RoleMiddleware::authenticated(), CsrfMiddleware::class]);
$router->post('/settings/update-editor', [DashboardController::class, 'updateEditorSettings'], [RoleMiddleware::authenticated(), CsrfMiddleware::class]);
$router->post('/settings/change-password', [DashboardController::class, 'changePassword'], [RoleMiddleware::authenticated(), CsrfMiddleware::class]);
$router->post('/settings/delete-account', [DashboardController::class, 'deleteAccount'], [RoleMiddleware::authenticated(), CsrfMiddleware::class]);

// Facilitator Routes (facilitator/admin only)
$router->get('/facilitator/dashboard', [FacilitatorController::class, 'dashboard'], [RoleMiddleware::facilitator()]);
$router->get('/facilitator/courses', [FacilitatorController::class, 'courses'], [RoleMiddleware::facilitator()]);
$router->get('/facilitator/courses/create', [FacilitatorController::class, 'createCourse'], [RoleMiddleware::facilitator()]);
$router->post('/facilitator/courses/create', [FacilitatorController::class, 'storeCourse'], [RoleMiddleware::facilitator(), CsrfMiddleware::class]);
$router->get('/facilitator/courses/{id}/edit', [FacilitatorController::class, 'editCourse'], [RoleMiddleware::facilitator()]);
$router->post('/facilitator/courses/{id}/edit', [FacilitatorController::class, 'updateCourse'], [RoleMiddleware::facilitator(), CsrfMiddleware::class]);
$router->post('/facilitator/courses/{id}/publish', [FacilitatorController::class, 'publishCourse'], [RoleMiddleware::facilitator(), CsrfMiddleware::class]);
$router->post('/facilitator/courses/{id}/modules', [FacilitatorController::class, 'addModule'], [RoleMiddleware::facilitator(), CsrfMiddleware::class]);
$router->post('/facilitator/modules/{id}/lessons', [FacilitatorController::class, 'addLesson'], [RoleMiddleware::facilitator(), CsrfMiddleware::class]);
$router->post('/facilitator/lessons/assignments', [FacilitatorController::class, 'addAssignment'], [RoleMiddleware::facilitator(), CsrfMiddleware::class]);

// Facilitator Submission Management
$router->get('/facilitator/submissions', [FacilitatorController::class, 'submissions'], [RoleMiddleware::facilitator()]);
$router->get('/facilitator/submissions/{id}', [FacilitatorController::class, 'viewSubmission'], [RoleMiddleware::facilitator()]);
$router->post('/facilitator/submissions/grade', [FacilitatorController::class, 'gradeSubmission'], [RoleMiddleware::facilitator(), CsrfMiddleware::class]);

// Facilitator Student Management
$router->get('/facilitator/students', [FacilitatorController::class, 'students'], [RoleMiddleware::facilitator()]);
$router->get('/facilitator/students/{id}', [FacilitatorController::class, 'viewStudent'], [RoleMiddleware::facilitator()]);

// Facilitator Cohort Management
$router->get('/facilitator/cohorts', [FacilitatorController::class, 'cohorts'], [RoleMiddleware::facilitator()]);
$router->get('/facilitator/cohorts/create', [FacilitatorController::class, 'createCohortForm'], [RoleMiddleware::facilitator()]);
$router->post('/facilitator/cohorts/create', [FacilitatorController::class, 'createCohort'], [RoleMiddleware::facilitator(), CsrfMiddleware::class]);
$router->post('/facilitator/cohorts/submit-approval', [FacilitatorController::class, 'submitCohortForApproval'], [RoleMiddleware::facilitator(), CsrfMiddleware::class]);
$router->post('/facilitator/cohorts/add-course', [FacilitatorController::class, 'addCourseToCohort'], [RoleMiddleware::facilitator(), CsrfMiddleware::class]);
$router->post('/facilitator/cohorts/remove-course', [FacilitatorController::class, 'removeCourseFromCohort'], [RoleMiddleware::facilitator(), CsrfMiddleware::class]);
$router->get('/facilitator/cohorts/{id}', [FacilitatorController::class, 'viewCohort'], [RoleMiddleware::facilitator()]);

// AI Generation Routes (facilitator/admin only)
$router->post('/ai/generate-course-outline', [AIController::class, 'generateCourseOutline'], [RoleMiddleware::facilitator(), CsrfMiddleware::class]);
$router->post('/ai/generate-lesson-content', [AIController::class, 'generateLessonContent'], [RoleMiddleware::facilitator(), CsrfMiddleware::class]);
$router->post('/ai/generate-project-brief', [AIController::class, 'generateProjectBrief'], [RoleMiddleware::facilitator(), CsrfMiddleware::class]);
$router->post('/ai/generate-complete-course', [AIController::class, 'generateCompleteCourse'], [RoleMiddleware::facilitator(), CsrfMiddleware::class, RateLimitMiddleware::class]);
$router->post('/ai/generate-quiz', [AIController::class, 'generateQuiz'], [RoleMiddleware::facilitator(), CsrfMiddleware::class]);

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
$router->get('/courses/{slug}/lesson/{id}', [CourseController::class, 'showLesson']);

// Application Routes (student only)
$router->get('/apply', [ApplicationController::class, 'showApplicationForm'], [RoleMiddleware::student()]);
$router->post('/apply', [ApplicationController::class, 'submitApplication'], [RoleMiddleware::student(), CsrfMiddleware::class]);
$router->get('/my-applications', [ApplicationController::class, 'myApplications'], [RoleMiddleware::student()]);
$router->get('/application/{uuid}', [ApplicationController::class, 'viewApplication'], [RoleMiddleware::student()]);
$router->get('/application/{uuid}/update', [ApplicationController::class, 'showUpdateForm'], [RoleMiddleware::student()]);
$router->post('/application/{uuid}/update', [ApplicationController::class, 'updateApplication'], [RoleMiddleware::student(), CsrfMiddleware::class]);

// Application Document Download (authenticated users with permission check)
$router->get('/storage/uploads/applications/{file}', [ApplicationController::class, 'downloadDocument'], [RoleMiddleware::authenticated()]);

// Admin Routes (admin only)
$router->get('/admin/dashboard', [AdminController::class, 'dashboard'], [RoleMiddleware::admin()]);

// Applications
$router->get('/admin/applications', [AdminController::class, 'applications'], [RoleMiddleware::admin()]);
$router->get('/admin/applications/{id}', [AdminController::class, 'viewApplication'], [RoleMiddleware::admin()]);
$router->post('/admin/applications/approve', [AdminController::class, 'approveApplication'], [RoleMiddleware::admin(), CsrfMiddleware::class]);
$router->post('/admin/applications/reject', [AdminController::class, 'rejectApplication'], [RoleMiddleware::admin(), CsrfMiddleware::class]);
$router->post('/admin/applications/request-info', [AdminController::class, 'requestInfo'], [RoleMiddleware::admin(), CsrfMiddleware::class]);

// Users
$router->get('/admin/users', [AdminController::class, 'users'], [RoleMiddleware::admin()]);
$router->post('/admin/users/update-status', [AdminController::class, 'updateUserStatus'], [RoleMiddleware::admin()]);

// Cohorts
$router->get('/admin/cohorts', [AdminController::class, 'cohorts'], [RoleMiddleware::admin()]);
$router->get('/admin/cohorts/create', [AdminController::class, 'createCohortForm'], [RoleMiddleware::admin()]);
$router->post('/admin/cohorts/create', [AdminController::class, 'createCohort'], [RoleMiddleware::admin()]);

// Cohort-Course Management (must come BEFORE {id} route)
$router->get('/admin/cohorts/available-courses', [AdminController::class, 'getAvailableCoursesForCohort'], [RoleMiddleware::admin()]);
$router->post('/admin/cohorts/add-course', [AdminController::class, 'addCourseToCohort'], [RoleMiddleware::admin()]);
$router->post('/admin/cohorts/remove-course', [AdminController::class, 'removeCourseFromCohort'], [RoleMiddleware::admin()]);
$router->post('/admin/cohorts/enroll-student-courses', [AdminController::class, 'enrollCohortStudentsInCourses'], [RoleMiddleware::admin()]);
$router->post('/admin/cohorts/assign-student', [AdminController::class, 'assignStudentToCohort'], [RoleMiddleware::admin()]);
$router->post('/admin/cohorts/remove-student', [AdminController::class, 'removeStudentFromCohort'], [RoleMiddleware::admin()]);
$router->post('/admin/cohorts/delete', [AdminController::class, 'deleteCohort'], [RoleMiddleware::admin()]);
$router->post('/admin/cohorts/approve', [AdminController::class, 'approveCohortSubmission'], [RoleMiddleware::admin(), CsrfMiddleware::class]);
$router->post('/admin/cohorts/reject', [AdminController::class, 'rejectCohortSubmission'], [RoleMiddleware::admin(), CsrfMiddleware::class]);

// Cohort detail and edit (parameterized routes come LAST)
$router->get('/admin/cohorts/{id}', [AdminController::class, 'viewCohort'], [RoleMiddleware::admin()]);
$router->post('/admin/cohorts/{id}/edit', [AdminController::class, 'editCohort'], [RoleMiddleware::admin()]);

// Enrollments
$router->get('/admin/enrollments', [AdminController::class, 'enrollments'], [RoleMiddleware::admin()]);
$router->get('/admin/enrollments/create', [AdminController::class, 'manualEnrollmentForm'], [RoleMiddleware::admin()]);
$router->post('/admin/enrollments/create', [AdminController::class, 'manualEnroll'], [RoleMiddleware::admin()]);
$router->post('/admin/enrollments/update-status', [AdminController::class, 'updateEnrollmentStatus'], [RoleMiddleware::admin()]);

// Admin Course Management
$router->get('/admin/courses', [AdminController::class, 'courses'], [RoleMiddleware::admin()]);
$router->get('/admin/courses/{id}', [AdminController::class, 'viewCourse'], [RoleMiddleware::admin()]);
$router->post('/admin/courses/{id}/approve', [AdminController::class, 'approveCourse'], [RoleMiddleware::admin()]);
$router->post('/admin/courses/{id}/unpublish', [AdminController::class, 'unpublishCourse'], [RoleMiddleware::admin()]);
$router->post('/admin/courses/{id}/delete', [AdminController::class, 'deleteCourse'], [RoleMiddleware::admin()]);

// Admin Approval Workflow
$router->get('/admin/approvals', [AdminController::class, 'approvalsDashboard'], [RoleMiddleware::admin()]);
$router->get('/admin/approvals/cohorts', [AdminController::class, 'pendingCohorts'], [RoleMiddleware::admin()]);
$router->get('/admin/approvals/cohorts/{id}', [AdminController::class, 'reviewCohort'], [RoleMiddleware::admin()]);
$router->post('/admin/approvals/cohorts/{id}/approve', [AdminController::class, 'approveCohort'], [RoleMiddleware::admin()]);
$router->post('/admin/approvals/cohorts/{id}/reject', [AdminController::class, 'rejectCohort'], [RoleMiddleware::admin()]);
$router->get('/admin/approvals/courses', [AdminController::class, 'pendingCourses'], [RoleMiddleware::admin()]);
$router->get('/admin/approvals/courses/{id}', [AdminController::class, 'reviewCourse'], [RoleMiddleware::admin()]);
$router->post('/admin/approvals/courses/{id}/approve', [AdminController::class, 'approveCourseSubmission'], [RoleMiddleware::admin()]);
$router->post('/admin/approvals/courses/{id}/reject', [AdminController::class, 'rejectCourseSubmission'], [RoleMiddleware::admin()]);

// Admin Certificate Management
$router->get('/admin/certificates', [AdminController::class, 'certificates'], [RoleMiddleware::admin()]);
$router->get('/admin/certificates/issue', [AdminController::class, 'issueCertificateForm'], [RoleMiddleware::admin()]);
$router->post('/admin/certificates/issue', [AdminController::class, 'issueCertificate'], [RoleMiddleware::admin()]);
$router->get('/admin/certificates/{id}', [AdminController::class, 'viewCertificate'], [RoleMiddleware::admin()]);
$router->post('/admin/certificates/{id}/revoke', [AdminController::class, 'revokeCertificate'], [RoleMiddleware::admin()]);
$router->post('/admin/certificates/{id}/restore', [AdminController::class, 'restoreCertificate'], [RoleMiddleware::admin()]);

// Submission Routes (student only)
$router->get('/assignment/{id}/submit', [SubmissionController::class, 'create'], [RoleMiddleware::student()]);
$router->post('/assignment/submit', [SubmissionController::class, 'store'], [RoleMiddleware::student()]);
$router->get('/submission/{id}', [SubmissionController::class, 'viewSubmission'], [RoleMiddleware::authenticated()]);
$router->post('/submission/{id}/update', [SubmissionController::class, 'update'], [RoleMiddleware::student()]);
$router->get('/submission/{id}/download', [SubmissionController::class, 'download'], [RoleMiddleware::authenticated()]);

// Portfolio Routes (student only)
$router->get('/my-portfolio', [PortfolioController::class, 'myPortfolio'], [RoleMiddleware::student()]);
$router->get('/portfolio/{userId}', [PortfolioController::class, 'viewUserPortfolio']);
$router->get('/showcase', [PortfolioController::class, 'showcase']);
$router->post('/portfolio/create', [PortfolioController::class, 'create'], [RoleMiddleware::student()]);
$router->post('/portfolio/update', [PortfolioController::class, 'update'], [RoleMiddleware::student()]);
$router->post('/portfolio/delete', [PortfolioController::class, 'delete'], [RoleMiddleware::student()]);

// Certificate Routes
$router->get('/my-certificates', [CertificateController::class, 'myCertificates'], [RoleMiddleware::authenticated()]);
$router->get('/certificate/{uuid}', [CertificateController::class, 'viewCertificate']);
$router->get('/verify-certificate', [CertificateController::class, 'verify']);
$router->post('/certificate/issue', [CertificateController::class, 'issue'], [RoleMiddleware::facilitator()]);
$router->get('/certificate/{uuid}/download', [CertificateController::class, 'download'], [RoleMiddleware::authenticated()]);

// Code Execution Routes (authenticated users)
$router->get('/playground', [CodeExecutionController::class, 'playground'], [RoleMiddleware::authenticated()]);
$router->post('/code/execute', [CodeExecutionController::class, 'execute'], [RoleMiddleware::authenticated()]);
$router->post('/code/run-tests', [CodeExecutionController::class, 'runTests'], [RoleMiddleware::authenticated()]);
$router->get('/code/languages', [CodeExecutionController::class, 'getSupportedLanguages'], [RoleMiddleware::authenticated()]);

// Progress Tracking Routes (student only)
$router->get('/progress/dashboard', [ProgressController::class, 'dashboard'], [RoleMiddleware::student()]);
$router->get('/progress/bookmarks', [ProgressController::class, 'bookmarks'], [RoleMiddleware::student()]);
$router->post('/api/progress/mark-complete', [ProgressController::class, 'markLessonComplete'], [RoleMiddleware::student()]);
$router->post('/api/progress/update-progress', [ProgressController::class, 'updateLessonProgress'], [RoleMiddleware::student()]);
$router->post('/api/progress/track-time', [ProgressController::class, 'trackTime'], [RoleMiddleware::student()]);
$router->post('/api/progress/toggle-bookmark', [ProgressController::class, 'toggleBookmark'], [RoleMiddleware::student()]);
$router->post('/api/progress/save-notes', [ProgressController::class, 'saveNotes'], [RoleMiddleware::student()]);

// Notification Routes (authenticated users)
$router->get('/notifications', [NotificationController::class, 'index'], [RoleMiddleware::authenticated()]);
$router->get('/api/notifications', [NotificationController::class, 'getNotifications'], [RoleMiddleware::authenticated()]);
$router->get('/api/notifications/unread-count', [NotificationController::class, 'getUnreadCount'], [RoleMiddleware::authenticated()]);
$router->post('/api/notifications/mark-read', [NotificationController::class, 'markAsRead'], [RoleMiddleware::authenticated()]);
$router->post('/api/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'], [RoleMiddleware::authenticated()]);
$router->post('/api/notifications/delete', [NotificationController::class, 'delete'], [RoleMiddleware::authenticated()]);
$router->post('/api/notifications/delete-all', [NotificationController::class, 'deleteAll'], [RoleMiddleware::authenticated()]);
