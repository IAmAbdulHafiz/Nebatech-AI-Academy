<?php

namespace Nebatech\Controllers\Admin;

use Nebatech\Core\Controller;
use Nebatech\Repositories\ApplicationRepository;
use Nebatech\Repositories\UserRepository;
use Nebatech\Repositories\CourseRepository;
use Nebatech\Repositories\EnrollmentRepository;
use Nebatech\Repositories\CohortRepository;
use Nebatech\Repositories\CertificateRepository;
use Nebatech\Models\Academic\Enrollment;
use Nebatech\Models\Community\Cohort;
use Nebatech\Models\Community\User;
use Nebatech\Models\Academic\Course;
use Nebatech\Models\Academic\Module;
use Nebatech\Models\Academic\Lesson;
use Nebatech\Services\EmailService;
use Nebatech\Services\NotificationService;
use Nebatech\Middleware\AuthMiddleware;

class AdminController extends Controller
{
    private ApplicationRepository $applicationRepo;
    private UserRepository $userRepo;
    private CourseRepository $courseRepo;
    private EnrollmentRepository $enrollmentRepo;
    private CohortRepository $cohortRepo;
    private CertificateRepository $certificateRepo;
    private EmailService $emailService;
    private NotificationService $notificationService;

    public function __construct()
    {
        $this->applicationRepo = new ApplicationRepository();
        $this->userRepo = new UserRepository();
        $this->courseRepo = new CourseRepository();
        $this->enrollmentRepo = new EnrollmentRepository();
        $this->cohortRepo = new CohortRepository();
        $this->certificateRepo = new CertificateRepository();
        $this->emailService = new EmailService();
        $this->notificationService = new NotificationService();
    }

    /**
     * Admin dashboard
     */
    public function dashboard(): void
    {
        $user = $this->getCurrentUser();
        
        // Get statistics
        $stats = [
            'applications' => $this->applicationRepo->getStats(),
            'total_users' => $this->userRepo->count(),
            'total_students' => $this->userRepo->count(['role' => 'student']),
            'total_facilitators' => $this->userRepo->count(['role' => 'facilitator']),
            'total_courses' => $this->courseRepo->count(),
            'published_courses' => $this->courseRepo->count(['status' => 'published'])
        ];

        // Get recent applications
        $recentApplications = $this->applicationRepo->getAll(['limit' => 10]);

        echo $this->view('admin/dashboard', [
            'user' => $user,
            'stats' => $stats,
            'recentApplications' => $recentApplications
        ]);
    }

    /**
     * List all applications
     */
    public function applications(): void
    {
        $user = $this->getCurrentUser();
        $status = $_GET['status'] ?? null;
        $program = $_GET['program'] ?? null;

        $filters = [];
        if ($status) {
            $filters['status'] = $status;
        }
        if ($program) {
            $filters['program'] = $program;
        }

        $applications = $this->applicationRepo->getAll($filters);
        $stats = $this->applicationRepo->getStats();

        echo $this->view('admin/applications', [
            'user' => $user,
            'applications' => $applications,
            'stats' => $stats,
            'currentStatus' => $status,
            'currentProgram' => $program
        ]);
    }

    /**
     * View single application
     */
    public function viewApplication(int $id): void
    {
        $application = $this->applicationRepo->findById($id);

        if (!$application) {
            $this->redirect('/admin/applications?error=not_found');
            return;
        }

        // Get available courses and cohorts for approval
        $courses = $this->courseRepo->getAll(['status' => 'published']);
        $cohorts = $this->cohortRepo->getAll(['status' => 'active']);
        $facilitators = $this->userRepo->getAll(['role' => 'facilitator']);

        echo $this->view('admin/application-detail', [
            'user' => $this->getCurrentUser(),
            'application' => $application,
            'courses' => $courses,
            'cohorts' => $cohorts,
            'facilitators' => $facilitators
        ]);
    }

    /**
     * Approve application
     */
    public function approveApplication(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['error' => 'Invalid request method'], 405);
            return;
        }

        $applicationId = (int)($_POST['application_id'] ?? 0);
        $notes = $_POST['notes'] ?? null;
        $courseId = (int)($_POST['course_id'] ?? 0);
        $cohortId = (int)($_POST['cohort_id'] ?? 0);
        $welcomeMessage = $_POST['welcome_message'] ?? '';

        if (!$applicationId) {
            $this->jsonResponse(['error' => 'Application ID required'], 400);
            return;
        }

        if (!$courseId) {
            $this->jsonResponse(['error' => 'Course selection required'], 400);
            return;
        }

        $application = $this->applicationRepo->findById($applicationId);
        if (!$application) {
            $this->jsonResponse(['error' => 'Application not found'], 404);
            return;
        }

        // Get user and course details
        $user = $this->userRepo->findById($application['user_id']);
        $course = $this->courseRepo->findById($courseId);
        
        if (!$user || !$course) {
            $this->jsonResponse(['error' => 'User or course not found'], 404);
            return;
        }

        // Approve the application
        $reviewerId = AuthMiddleware::userId();
        $success = $this->applicationRepo->approve($applicationId, $reviewerId, $notes);

        if ($success) {
            // Auto-enroll student in course
            $enrollmentId = $this->enrollmentRepo->create([
                'user_id' => $application['user_id'],
                'course_id' => $courseId,
                'status' => 'active',
                'enrolled_at' => date('Y-m-d H:i:s')
            ]);

            // Assign to cohort if selected
            $cohort = null;
            if ($cohortId) {
                $this->cohortRepo->addStudent($cohortId, $application['user_id']);
                $cohort = $this->cohortRepo->find($cohortId);
                
                // Send cohort assignment email
                if ($cohort && !empty($cohort['facilitator_id'])) {
                    $facilitator = $this->userRepo->findById((int)$cohort['facilitator_id']);
                    if ($facilitator) {
                        $this->emailService->sendCohortAssignment($user, $cohort, $facilitator);
                    }
                }
            }

            // Send approval email
            $this->emailService->sendApplicationApproved($application, $user, null, $cohort);
            
            // Send welcome email
            $this->emailService->sendWelcomeEmail($user, $course, $cohort);

            // Send notifications
            $this->notificationService->notifyApplicationApproved($application['user_id'], $application, $course);
            $this->notificationService->notifyEnrollmentCreated($application['user_id'], $course);
            
            if ($cohort && $facilitator) {
                $this->notificationService->notifyCohortAssigned($application['user_id'], $cohort, $facilitator);
            }

            $this->jsonResponse([
                'success' => true,
                'message' => 'Application approved and student enrolled successfully'
            ]);
        } else {
            $this->jsonResponse(['error' => 'Failed to approve application'], 500);
        }
    }

    /**
     * Reject application
     */
    public function rejectApplication(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['error' => 'Invalid request method'], 405);
            return;
        }

        $applicationId = (int)($_POST['application_id'] ?? 0);
        $notes = $_POST['notes'] ?? null;

        if (!$applicationId) {
            $this->jsonResponse(['error' => 'Application ID required'], 400);
            return;
        }

        $application = $this->applicationRepo->findById($applicationId);
        if (!$application) {
            $this->jsonResponse(['error' => 'Application not found'], 404);
            return;
        }

        $reviewerId = AuthMiddleware::userId();
        $success = $this->applicationRepo->reject($applicationId, $reviewerId, $notes);

        if ($success) {
            // Send rejection email to student
            $this->emailService->sendApplicationRejected($application, $notes ?? '');
            
            // Send notification
            $this->notificationService->notifyApplicationRejected($application['user_id'], $application, $notes ?? '');
            
            $this->jsonResponse([
                'success' => true,
                'message' => 'Application rejected'
            ]);
        } else {
            $this->jsonResponse(['error' => 'Failed to reject application'], 500);
        }
    }

    /**
     * Request more information
     */
    public function requestInfo(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['error' => 'Invalid request method'], 405);
            return;
        }

        $applicationId = (int)($_POST['application_id'] ?? 0);
        $notes = $_POST['notes'] ?? '';

        if (!$applicationId || empty($notes)) {
            $this->jsonResponse(['error' => 'Application ID and notes required'], 400);
            return;
        }

        $application = $this->applicationRepo->findById($applicationId);
        if (!$application) {
            $this->jsonResponse(['error' => 'Application not found'], 404);
            return;
        }

        $reviewerId = AuthMiddleware::userId();
        $success = $this->applicationRepo->requestInfo($applicationId, $reviewerId, $notes);

        if ($success) {
            // Send email to student requesting more info
            $this->emailService->sendInfoRequested($application, $notes);
            
            // Send notification
            $this->notificationService->notifyInfoRequested($application['user_id'], $application, $notes);
            
            $this->jsonResponse([
                'success' => true,
                'message' => 'Information request sent'
            ]);
        } else {
            $this->jsonResponse(['error' => 'Failed to send request'], 500);
        }
    }

    /**
     * List all users
     */
    public function users(): void
    {
        $role = $_GET['role'] ?? null;
        $status = $_GET['status'] ?? null;
        $search = $_GET['search'] ?? null;

        $filters = [];
        if ($role) {
            $filters['role'] = $role;
        }
        if ($status) {
            $filters['status'] = $status;
        }
        if ($search) {
            $filters['search'] = $search;
        }

        $users = $this->userRepo->getAll($filters);

        echo $this->view('admin/users', [
            'user' => $this->getCurrentUser(),
            'users' => $users,
            'currentRole' => $role,
            'currentStatus' => $status,
            'currentSearch' => $search
        ]);
    }

    /**
     * Update user status
     */
    public function updateUserStatus(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['error' => 'Invalid request method'], 405);
            return;
        }

        $userId = (int)($_POST['user_id'] ?? 0);
        $status = $_POST['status'] ?? '';

        if (!$userId || !in_array($status, ['active', 'inactive', 'suspended'])) {
            $this->jsonResponse(['error' => 'Invalid parameters'], 400);
            return;
        }

        $success = $this->userRepo->updateStatus($userId, $status);

        if ($success) {
            $this->jsonResponse([
                'success' => true,
                'message' => 'User status updated'
            ]);
        } else {
            $this->jsonResponse(['error' => 'Failed to update status'], 500);
        }
    }

    /**
     * List all cohorts
     */
    public function cohorts(): void
    {
        $status = $_GET['status'] ?? null;
        $program = $_GET['program'] ?? null;
        $approvalStatus = $_GET['approval_status'] ?? null;

        $filters = [];
        if ($status) {
            $filters['status'] = $status;
        }
        if ($program) {
            $filters['program'] = $program;
        }
        
        // Only show cohorts that have been submitted for approval (exclude drafts)
        if ($approvalStatus) {
            $filters['approval_status'] = $approvalStatus;
        } else {
            // By default, exclude draft cohorts - only show submitted ones
            $filters['exclude_draft'] = true;
        }

        $cohorts = $this->cohortRepo->getAll($filters);
        $programs = require dirname(__DIR__, 3) . '/config/programs.php';

        echo $this->view('admin/cohorts', [
            'user' => $this->getCurrentUser(),
            'cohorts' => $cohorts,
            'programs' => $programs,
            'currentStatus' => $status,
            'currentProgram' => $program,
            'currentApprovalStatus' => $approvalStatus
        ]);
    }

    /**
     * Show create cohort form
     */
    public function createCohortForm(): void
    {
        $programs = require dirname(__DIR__, 3) . '/config/programs.php';
        $facilitators = $this->userRepo->getAll(['role' => 'facilitator']);

        echo $this->view('admin/create-cohort', [
            'user' => $this->getCurrentUser(),
            'programs' => $programs,
            'facilitators' => $facilitators
        ]);
    }

    /**
     * Create new cohort
     */
    public function createCohort(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/cohorts/create');
            return;
        }

        $name = trim($_POST['name'] ?? '');
        $program = $_POST['program'] ?? '';
        $facilitatorId = (int)($_POST['facilitator_id'] ?? 0);
        $startDate = $_POST['start_date'] ?? '';
        $endDate = $_POST['end_date'] ?? '';
        $maxStudents = (int)($_POST['max_students'] ?? 30);
        $status = $_POST['status'] ?? 'upcoming';
        $description = trim($_POST['description'] ?? '');

        if (empty($name) || empty($program) || empty($startDate)) {
            $this->redirect('/admin/cohorts/create?error=missing_fields');
            return;
        }

        $cohortId = $this->cohortRepo->create([
            'name' => $name,
            'program' => $program,
            'facilitator_id' => $facilitatorId ?: null,
            'start_date' => $startDate,
            'end_date' => $endDate ?: null,
            'max_students' => $maxStudents,
            'status' => $status,
            'description' => $description
        ]);

        if ($cohortId) {
            $this->redirect('/admin/cohorts/' . $cohortId . '?success=created');
        } else {
            $this->redirect('/admin/cohorts/create?error=creation_failed');
        }
    }

    /**
     * View cohort details
     */
    public function viewCohort(int $id): void
    {
        $cohort = $this->cohortRepo->find($id);

        if (!$cohort) {
            $this->redirect('/admin/cohorts?error=not_found');
            return;
        }

        $students = $this->cohortRepo->getStudents($id);
        $programs = require dirname(__DIR__, 3) . '/config/programs.php';
        $facilitators = $this->userRepo->getAll(['role' => 'facilitator']);
        
        // Get available students (not in this cohort)
        $allStudents = $this->userRepo->getAll(['role' => 'student']);
        $cohortStudentIds = array_column($students, 'id');
        $availableStudents = array_filter($allStudents, function($student) use ($cohortStudentIds) {
            return !in_array($student['id'], $cohortStudentIds);
        });

        echo $this->view('admin/cohort-detail', [
            'user' => $this->getCurrentUser(),
            'cohort' => $cohort,
            'students' => $students,
            'programs' => $programs,
            'facilitators' => $facilitators,
            'availableStudents' => $availableStudents
        ]);
    }

    /**
     * Edit cohort
     */
    public function editCohort(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/cohorts/' . $id);
            return;
        }

        $name = trim($_POST['name'] ?? '');
        $program = $_POST['program'] ?? '';
        $facilitatorId = (int)($_POST['facilitator_id'] ?? 0);
        $startDate = $_POST['start_date'] ?? '';
        $endDate = $_POST['end_date'] ?? '';
        $maxStudents = (int)($_POST['max_students'] ?? 30);
        $status = $_POST['status'] ?? 'upcoming';
        $description = trim($_POST['description'] ?? '');

        $success = $this->cohortRepo->update($id, [
            'name' => $name,
            'program' => $program,
            'facilitator_id' => $facilitatorId ?: null,
            'start_date' => $startDate,
            'end_date' => $endDate ?: null,
            'max_students' => $maxStudents,
            'status' => $status,
            'description' => $description
        ]);

        if ($success) {
            $this->redirect('/admin/cohorts/' . $id . '?success=updated');
        } else {
            $this->redirect('/admin/cohorts/' . $id . '?error=update_failed');
        }
    }

    /**
     * Assign student to cohort
     */
    public function assignStudentToCohort(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['error' => 'Invalid request method'], 405);
            return;
        }

        $cohortId = (int)($_POST['cohort_id'] ?? 0);
        $userId = (int)($_POST['user_id'] ?? 0);

        if (!$cohortId || !$userId) {
            $this->jsonResponse(['error' => 'Cohort ID and User ID required'], 400);
            return;
        }

        $success = $this->cohortRepo->addStudent($cohortId, $userId);

        if ($success) {
            // Send cohort assignment email
            $user = $this->userRepo->findById($userId);
            $cohort = $this->cohortRepo->find($cohortId);
            
            if ($user && $cohort && !empty($cohort['facilitator_id'])) {
                $facilitator = $this->userRepo->findById((int)$cohort['facilitator_id']);
                if ($facilitator) {
                    $this->emailService->sendCohortAssignment($user, $cohort, $facilitator);
                }
            }

            $this->jsonResponse([
                'success' => true,
                'message' => 'Student assigned to cohort successfully'
            ]);
        } else {
            $this->jsonResponse(['error' => 'Failed to assign student. Cohort may be full.'], 500);
        }
    }

    /**
     * Remove student from cohort
     */
    public function removeStudentFromCohort(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['error' => 'Invalid request method'], 405);
            return;
        }

        $cohortId = (int)($_POST['cohort_id'] ?? 0);
        $userId = (int)($_POST['user_id'] ?? 0);

        if (!$cohortId || !$userId) {
            $this->jsonResponse(['error' => 'Cohort ID and User ID required'], 400);
            return;
        }

        $success = $this->cohortRepo->removeStudent($cohortId, $userId);

        if ($success) {
            $this->jsonResponse([
                'success' => true,
                'message' => 'Student removed from cohort'
            ]);
        } else {
            $this->jsonResponse(['error' => 'Failed to remove student'], 500);
        }
    }

    /**
     * Delete cohort
     */
    public function deleteCohort(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['error' => 'Invalid request method'], 405);
            return;
        }

        $cohortId = (int)($_POST['cohort_id'] ?? 0);

        if (!$cohortId) {
            $this->jsonResponse(['error' => 'Cohort ID required'], 400);
            return;
        }

        $success = $this->cohortRepo->delete($cohortId);

        if ($success) {
            $this->jsonResponse([
                'success' => true,
                'message' => 'Cohort deleted successfully'
            ]);
        } else {
            $this->jsonResponse(['error' => 'Failed to delete cohort'], 500);
        }
    }

    /**
     * Add course to cohort
     */
    public function addCourseToCohort(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['error' => 'Invalid request method'], 405);
            return;
        }

        $cohortId = (int)($_POST['cohort_id'] ?? 0);
        $courseId = (int)($_POST['course_id'] ?? 0);
        $startDate = $_POST['start_date'] ?? null;
        $endDate = $_POST['end_date'] ?? null;
        $orderIndex = (int)($_POST['order_index'] ?? 0);

        if (!$cohortId || !$courseId) {
            $this->jsonResponse(['error' => 'Cohort ID and Course ID required'], 400);
            return;
        }

        $success = $this->cohortRepo->addCourse($cohortId, $courseId, [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'order_index' => $orderIndex
        ]);

        if ($success) {
            $this->jsonResponse([
                'success' => true,
                'message' => 'Course added to cohort successfully'
            ]);
        } else {
            $this->jsonResponse(['error' => 'Failed to add course to cohort'], 500);
        }
    }

    /**
     * Remove course from cohort
     */
    public function removeCourseFromCohort(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['error' => 'Invalid request method'], 405);
            return;
        }

        $cohortId = (int)($_POST['cohort_id'] ?? 0);
        $courseId = (int)($_POST['course_id'] ?? 0);

        if (!$cohortId || !$courseId) {
            $this->jsonResponse(['error' => 'Cohort ID and Course ID required'], 400);
            return;
        }

        $success = $this->cohortRepo->removeCourse($cohortId, $courseId);

        if ($success) {
            $this->jsonResponse([
                'success' => true,
                'message' => 'Course removed from cohort successfully'
            ]);
        } else {
            $this->jsonResponse(['error' => 'Failed to remove course from cohort'], 500);
        }
    }

    /**
     * Enroll cohort students in all cohort courses
     */
    public function enrollCohortStudentsInCourses(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['error' => 'Invalid request method'], 405);
            return;
        }

        $cohortId = (int)($_POST['cohort_id'] ?? 0);
        $userId = (int)($_POST['user_id'] ?? 0);

        if (!$cohortId || !$userId) {
            $this->jsonResponse(['error' => 'Cohort ID and User ID required'], 400);
            return;
        }

        // Get cohort courses and enroll student in each
        $courses = $this->cohortRepo->getCourses($cohortId);
        $results = [];
        
        foreach ($courses as $course) {
            // Check if already enrolled
            $existing = $this->enrollmentRepo->findByUserAndCourse($userId, $course['id']);
            if (!$existing) {
                $enrollmentId = $this->enrollmentRepo->create([
                    'user_id' => $userId,
                    'course_id' => $course['id'],
                    'status' => 'active'
                ]);
                $results[] = ['course_id' => $course['id'], 'enrolled' => (bool)$enrollmentId];
            } else {
                $results[] = ['course_id' => $course['id'], 'enrolled' => false, 'reason' => 'already_enrolled'];
            }
        }

        $this->jsonResponse([
            'success' => true,
            'message' => 'Student enrolled in cohort courses',
            'results' => $results
        ]);
    }

    /**
     * Get available courses for cohort (AJAX)
     */
    public function getAvailableCoursesForCohort(): void
    {
        $cohortId = (int)($_GET['cohort_id'] ?? 0);

        if (!$cohortId) {
            $this->jsonResponse(['error' => 'Cohort ID required'], 400);
            return;
        }

        // Get all published courses
        $allCourses = $this->courseRepo->getAll(['status' => 'published']);
        
        // Get courses already in cohort
        $cohortCourses = $this->cohortRepo->getCourses($cohortId);
        $cohortCourseIds = array_column($cohortCourses, 'id');

        // Filter out courses already in cohort
        $availableCourses = array_filter($allCourses, function($course) use ($cohortCourseIds) {
            return !in_array($course['id'], $cohortCourseIds);
        });

        $this->jsonResponse([
            'success' => true,
            'courses' => array_values($availableCourses)
        ]);
    }

    /**
     * List all enrollments
     */
    public function enrollments(): void
    {
        $status = $_GET['status'] ?? null;
        $courseId = (int)($_GET['course_id'] ?? 0);

        $filters = [];
        if ($status) {
            $filters['status'] = $status;
        }
        if ($courseId) {
            $filters['course_id'] = $courseId;
        }

        // Get all enrollments with filters
        $sql = "SELECT e.*, u.first_name, u.last_name, u.email, c.title as course_title
                FROM enrollments e
                JOIN users u ON e.user_id = u.id
                JOIN courses c ON e.course_id = c.id
                WHERE 1=1";
        
        $params = [];
        
        if (!empty($filters['status'])) {
            $sql .= " AND e.status = :status";
            $params['status'] = $filters['status'];
        }
        
        if (!empty($filters['course_id'])) {
            $sql .= " AND e.course_id = :course_id";
            $params['course_id'] = $filters['course_id'];
        }
        
        $sql .= " ORDER BY e.enrolled_at DESC";
        
        $enrollments = \Nebatech\Core\Database::fetchAll($sql, $params);
        $courses = $this->courseRepo->getAll();

        echo $this->view('admin/enrollments', [
            'user' => $this->getCurrentUser(),
            'enrollments' => $enrollments,
            'courses' => $courses,
            'currentStatus' => $status,
            'currentCourseId' => $courseId
        ]);
    }

    /**
     * Manual enrollment form
     */
    public function manualEnrollmentForm(): void
    {
        $students = $this->userRepo->getAll(['role' => 'student']);
        $courses = $this->courseRepo->getAll(['status' => 'published']);
        $cohorts = $this->cohortRepo->getAll(['status' => 'active']);

        echo $this->view('admin/enroll-student', [
            'user' => $this->getCurrentUser(),
            'students' => $students,
            'courses' => $courses,
            'cohorts' => $cohorts
        ]);
    }

    /**
     * Manually enroll student
     */
    public function manualEnroll(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['error' => 'Invalid request method'], 405);
            return;
        }

        $userId = (int)($_POST['user_id'] ?? 0);
        $courseId = (int)($_POST['course_id'] ?? 0);
        $cohortId = (int)($_POST['cohort_id'] ?? 0);

        if (!$userId || !$courseId) {
            $this->jsonResponse(['error' => 'User ID and Course ID required'], 400);
            return;
        }

        // Check if already enrolled
        $existing = $this->enrollmentRepo->findByUserAndCourse($userId, $courseId);
        if ($existing) {
            $this->jsonResponse(['error' => 'Student already enrolled in this course'], 400);
            return;
        }

        $enrollmentId = $this->enrollmentRepo->create([
            'user_id' => $userId,
            'course_id' => $courseId,
            'status' => 'active',
            'enrolled_at' => date('Y-m-d H:i:s')
        ]);

        if ($enrollmentId) {
            // Assign to cohort if selected
            if ($cohortId) {
                $this->cohortRepo->addStudent($cohortId, $userId);
            }

            // Send welcome email
            $user = $this->userRepo->findById($userId);
            $course = $this->courseRepo->findById($courseId);
            $cohort = $cohortId ? $this->cohortRepo->find($cohortId) : null;
            
            if ($user && $course) {
                $this->emailService->sendWelcomeEmail($user, $course, $cohort);
            }

            $this->jsonResponse([
                'success' => true,
                'message' => 'Student enrolled successfully'
            ]);
        } else {
            $this->jsonResponse(['error' => 'Failed to enroll student'], 500);
        }
    }

    /**
     * Update enrollment status
     */
    public function updateEnrollmentStatus(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['error' => 'Invalid request method'], 405);
            return;
        }

        $enrollmentId = (int)($_POST['enrollment_id'] ?? 0);
        $status = $_POST['status'] ?? '';

        // Valid enrollment statuses according to schema: active, suspended, completed, cancelled, dropped
        if (!$enrollmentId || !in_array($status, ['active', 'suspended', 'completed', 'cancelled', 'dropped'])) {
            $this->jsonResponse(['error' => 'Invalid parameters'], 400);
            return;
        }

        $success = $this->enrollmentRepo->update($enrollmentId, ['status' => $status]);

        if ($success) {
            $this->jsonResponse([
                'success' => true,
                'message' => 'Enrollment status updated'
            ]);
        } else {
            $this->jsonResponse(['error' => 'Failed to update status'], 500);
        }
    }

    /**
     * List all courses (admin oversight)
     */
    public function courses(): void
    {
        $status = $_GET['status'] ?? null;
        $category = $_GET['category'] ?? null;
        $search = $_GET['search'] ?? null;

        $filters = [];
        if ($status) {
            $filters['status'] = $status;
        }
        if ($category) {
            $filters['category'] = $category; // This now uses category slug
        }
        if ($search) {
            $filters['search'] = $search;
        }

        $courses = $this->courseRepo->getAll($filters);

        // Get statistics
        $stats = [
            'total' => count($this->courseRepo->getAll()),
            'published' => count($this->courseRepo->getAll(['status' => 'published'])),
            'draft' => count($this->courseRepo->getAll(['status' => 'draft'])),
            'archived' => count($this->courseRepo->getAll(['status' => 'archived']))
        ];

        echo $this->view('admin/courses', [
            'user' => $this->getCurrentUser(),
            'courses' => $courses,
            'stats' => $stats,
            'currentStatus' => $status,
            'currentCategory' => $category,
            'currentSearch' => $search
        ]);
    }

    /**
     * View course details (admin)
     */
    public function viewCourse(int $id): void
    {
        $course = $this->courseRepo->findById($id);

        if (!$course) {
            $this->redirect('/admin/courses?error=not_found');
            return;
        }

        // Get course modules and lessons
        $modules = Module::getByCourse($id);
        foreach ($modules as &$module) {
            $module['lessons'] = Lesson::getByModule($module['id']);
        }

        // Get enrollments
        $enrollments = $this->enrollmentRepo->getByCourse($id);

        echo $this->view('admin/course-detail', [
            'user' => $this->getCurrentUser(),
            'course' => $course,
            'modules' => $modules,
            'enrollments' => $enrollments
        ]);
    }

    /**
     * Approve/publish course
     */
    public function approveCourse(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['error' => 'Invalid request method'], 405);
            return;
        }

        $course = $this->courseRepo->findById($id);
        if (!$course) {
            $this->jsonResponse(['error' => 'Course not found'], 404);
            return;
        }

        $success = $this->courseRepo->publish($id);

        if ($success) {
            $this->jsonResponse([
                'success' => true,
                'message' => 'Course approved and published successfully'
            ]);
        } else {
            $this->jsonResponse(['error' => 'Failed to approve course'], 500);
        }
    }

    /**
     * Unpublish course
     */
    public function unpublishCourse(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['error' => 'Invalid request method'], 405);
            return;
        }

        $course = $this->courseRepo->findById($id);
        if (!$course) {
            $this->jsonResponse(['error' => 'Course not found'], 404);
            return;
        }

        $success = $this->courseRepo->update($id, ['status' => 'draft']);

        if ($success) {
            $this->jsonResponse([
                'success' => true,
                'message' => 'Course unpublished successfully'
            ]);
        } else {
            $this->jsonResponse(['error' => 'Failed to unpublish course'], 500);
        }
    }

    /**
     * Delete course
     */
    public function deleteCourse(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['error' => 'Invalid request method'], 405);
            return;
        }

        $course = $this->courseRepo->findById($id);
        if (!$course) {
            $this->jsonResponse(['error' => 'Course not found'], 404);
            return;
        }

        // Check if course has enrollments
        $enrollments = $this->enrollmentRepo->getByCourse($id);
        if (count($enrollments) > 0) {
            $this->jsonResponse([
                'error' => 'Cannot delete course with active enrollments. Please archive it instead.'
            ], 400);
            return;
        }

        $success = $this->courseRepo->delete($id);

        if ($success) {
            $this->jsonResponse([
                'success' => true,
                'message' => 'Course deleted successfully'
            ]);
        } else {
            $this->jsonResponse(['error' => 'Failed to delete course'], 500);
        }
    }

    /**
     * List all certificates
     */
    public function certificates(): void
    {
        $status = $_GET['status'] ?? null;
        $search = $_GET['search'] ?? null;

        $sql = "SELECT c.*, 
                       u.first_name,
                       u.last_name,
                       u.email,
                       co.title as course_title,
                       cc.name as category_name,
                       cc.slug as category_slug
                FROM certificates c
                INNER JOIN users u ON c.user_id = u.id
                INNER JOIN courses co ON c.course_id = co.id
                LEFT JOIN course_categories cc ON co.category_id = cc.id
                WHERE 1=1";

        $params = [];

        if ($status === 'verified') {
            $sql .= " AND c.verified = 1";
        } elseif ($status === 'revoked') {
            $sql .= " AND c.verified = 0";
        }

        if ($search) {
            $sql .= " AND (u.first_name LIKE :search OR u.last_name LIKE :search OR u.email LIKE :search OR c.certificate_number LIKE :search)";
            $params['search'] = '%' . $search . '%';
        }

        $sql .= " ORDER BY c.issued_at DESC";

        $certificates = \Nebatech\Core\Database::fetchAll($sql, $params);

        // Get statistics
        $stats = $this->certificateRepo->getStatistics();
        $stats['verified'] = count(array_filter($certificates, fn($c) => $c['verified']));
        $stats['revoked'] = count(array_filter($certificates, fn($c) => !$c['verified']));

        echo $this->view('admin/certificates', [
            'user' => $this->getCurrentUser(),
            'certificates' => $certificates,
            'stats' => $stats,
            'currentStatus' => $status,
            'currentSearch' => $search
        ]);
    }

    /**
     * Show certificate issuance form
     */
    public function issueCertificateForm(): void
    {
        $students = $this->userRepo->getAll(['role' => 'student']);
        $courses = $this->courseRepo->getAll(['status' => 'published']);

        echo $this->view('admin/issue-certificate', [
            'user' => $this->getCurrentUser(),
            'students' => $students,
            'courses' => $courses
        ]);
    }

    /**
     * Issue certificate
     */
    public function issueCertificate(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['error' => 'Invalid request method'], 405);
            return;
        }

        $userId = (int)($_POST['user_id'] ?? 0);
        $courseId = (int)($_POST['course_id'] ?? 0);

        if (!$userId || !$courseId) {
            $this->jsonResponse(['error' => 'User ID and Course ID required'], 400);
            return;
        }

        // Check if certificate already exists
        $existing = $this->certificateRepo->userHasCertificate($userId, $courseId);
        if ($existing) {
            $this->jsonResponse(['error' => 'Certificate already issued for this user and course'], 400);
            return;
        }

        // Check if user completed the course
        $enrollment = $this->enrollmentRepo->findByUserAndCourse($userId, $courseId);
        if (!$enrollment) {
            $this->jsonResponse(['error' => 'User is not enrolled in this course'], 400);
            return;
        }

        $certificateId = $this->certificateRepo->create([
            'user_id' => $userId,
            'course_id' => $courseId,
            'issued_at' => date('Y-m-d H:i:s'),
            'verified' => 1  // Admin-issued certificates are automatically verified
        ]);

        if ($certificateId) {
            // Send certificate email
            try {
                $user = $this->userRepo->findById($userId);
                $course = $this->courseRepo->findById($courseId);
                $certificate = $this->certificateRepo->find($certificateId);
                
                if ($user && $course && $certificate) {
                    $emailService = new \Nebatech\Services\EmailService();
                    $emailService->sendCertificateIssued($user, $certificate, $course);
                }
            } catch (\Exception $e) {
                error_log("Failed to send certificate email: " . $e->getMessage());
            }

            $this->jsonResponse([
                'success' => true,
                'message' => 'Certificate issued successfully',
                'certificate_id' => $certificateId
            ]);
        } else {
            $this->jsonResponse(['error' => 'Failed to issue certificate'], 500);
        }
    }

    /**
     * View certificate details (admin)
     */
    public function viewCertificate(int $id): void
    {
        $sql = "SELECT c.*, 
                       u.first_name,
                       u.last_name,
                       u.email,
                       co.title as course_title,
                       cc.name as category_name,
                       cc.slug as category_slug,
                       co.level,
                       co.duration_hours
                FROM certificates c
                INNER JOIN users u ON c.user_id = u.id
                INNER JOIN courses co ON c.course_id = co.id
                LEFT JOIN course_categories cc ON co.category_id = cc.id
                WHERE c.id = :id
                LIMIT 1";

        $certificate = \Nebatech\Core\Database::fetch($sql, ['id' => $id]);

        if (!$certificate) {
            $this->redirect('/admin/certificates?error=not_found');
            return;
        }

        echo $this->view('admin/certificate-detail', [
            'user' => $this->getCurrentUser(),
            'certificate' => $certificate
        ]);
    }

    /**
     * Revoke certificate
     */
    public function revokeCertificate(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['error' => 'Invalid request method'], 405);
            return;
        }

        $currentUser = $this->getCurrentUser();
        $success = $this->certificateRepo->revoke($id, $currentUser['id'], 'Revoked by admin');

        if ($success) {
            $this->jsonResponse([
                'success' => true,
                'message' => 'Certificate revoked successfully'
            ]);
        } else {
            $this->jsonResponse(['error' => 'Failed to revoke certificate'], 500);
        }
    }

    /**
     * Restore revoked certificate
     */
    public function restoreCertificate(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['error' => 'Invalid request method'], 405);
            return;
        }

        $success = $this->certificateRepo->restore($id);

        if ($success) {
            $this->jsonResponse([
                'success' => true,
                'message' => 'Certificate restored successfully'
            ]);
        } else {
            $this->jsonResponse(['error' => 'Failed to restore certificate'], 500);
        }
    }

    /**
     * Approvals dashboard - shows pending courses and cohorts
     */
    public function approvalsDashboard(): void
    {
        $user = $this->getCurrentUser();
        
        // Get pending courses
        $pendingCourses = $this->courseRepo->getPendingApprovals();
        
        // Get pending cohorts
        $pendingCohorts = $this->cohortRepo->getAll(['approval_status' => 'pending_approval']);
        
        echo $this->view('admin/approvals-dashboard', [
            'title' => 'Pending Approvals',
            'user' => $user,
            'pendingCourses' => $pendingCourses,
            'pendingCohorts' => $pendingCohorts
        ]);
    }

    /**
     * List pending cohorts
     */
    public function pendingCohorts(): void
    {
        $user = $this->getCurrentUser();
        $cohorts = $this->cohortRepo->getAll(['approval_status' => 'pending_approval']);
        
        echo $this->view('admin/pending-cohorts', [
            'title' => 'Pending Cohorts',
            'user' => $user,
            'cohorts' => $cohorts
        ]);
    }

    /**
     * Review specific cohort for approval
     */
    public function reviewCohort(int $id): void
    {
        $user = $this->getCurrentUser();
        $cohort = $this->cohortRepo->find($id);
        
        if (!$cohort) {
            $this->redirect('/admin/approvals?error=not_found');
            return;
        }
        
        // Get courses in cohort
        $courses = $this->cohortRepo->getCourses($id);
        
        // Get approval history
        $history = \Nebatech\Core\Database::fetchAll(
            "SELECT ah.*, u.first_name, u.last_name 
             FROM approval_history ah
             LEFT JOIN users u ON ah.admin_id = u.id
             WHERE ah.entity_type = 'cohort' AND ah.entity_id = :id
             ORDER BY ah.created_at DESC",
            ['id' => $id]
        );
        
        echo $this->view('admin/review-cohort', [
            'title' => 'Review Cohort',
            'user' => $user,
            'cohort' => $cohort,
            'courses' => $courses,
            'history' => $history
        ]);
    }

    /**
     * Approve cohort
     */
    public function approveCohort(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/approvals/cohorts/' . $id);
            return;
        }

        $user = $this->getCurrentUser();
        $reason = trim($_POST['reason'] ?? '');

        // Approve cohort by updating status
        $success = $this->cohortRepo->update($id, ['approval_status' => 'approved']);
        
        // Log approval in history
        if ($success) {
            \Nebatech\Core\Database::insert('approval_history', [
                'entity_type' => 'cohort',
                'entity_id' => $id,
                'admin_id' => $user['id'],
                'action' => 'approved',
                'reason' => $reason,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }

        if ($success) {
            $this->redirect('/admin/approvals?success=cohort_approved');
        } else {
            $this->redirect('/admin/approvals/cohorts/' . $id . '?error=approval_failed');
        }
    }

    /**
     * Reject cohort
     */
    public function rejectCohort(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/approvals/cohorts/' . $id);
            return;
        }

        $user = $this->getCurrentUser();
        $reason = trim($_POST['reason'] ?? '');

        if (empty($reason)) {
            $this->redirect('/admin/approvals/cohorts/' . $id . '?error=reason_required');
            return;
        }

        // Reject cohort by updating status
        $success = $this->cohortRepo->update($id, ['approval_status' => 'rejected']);
        
        // Log rejection in history
        if ($success) {
            \Nebatech\Core\Database::insert('approval_history', [
                'entity_type' => 'cohort',
                'entity_id' => $id,
                'admin_id' => $user['id'],
                'action' => 'rejected',
                'reason' => $reason,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }

        if ($success) {
            $this->redirect('/admin/approvals?success=cohort_rejected');
        } else {
            $this->redirect('/admin/approvals/cohorts/' . $id . '?error=rejection_failed');
        }
    }

    /**
     * List pending courses
     */
    public function pendingCourses(): void
    {
        $user = $this->getCurrentUser();
        $courses = $this->courseRepo->getPendingApprovals();
        
        echo $this->view('admin/pending-courses', [
            'title' => 'Pending Courses',
            'user' => $user,
            'courses' => $courses
        ]);
    }

    /**
     * Review specific course for approval
     */
    public function reviewCourse(int $id): void
    {
        $user = $this->getCurrentUser();
        $course = $this->courseRepo->findById($id);
        
        if (!$course) {
            $this->redirect('/admin/approvals?error=not_found');
            return;
        }
        
        // Get course modules and lessons
        $modules = Module::getByCourse($id);
        
        // Get approval history
        $history = \Nebatech\Core\Database::fetchAll(
            "SELECT ah.*, u.first_name, u.last_name 
             FROM approval_history ah
             LEFT JOIN users u ON ah.admin_id = u.id
             WHERE ah.entity_type = 'course' AND ah.entity_id = :id
             ORDER BY ah.created_at DESC",
            ['id' => $id]
        );
        
        echo $this->view('admin/review-course', [
            'title' => 'Review Course',
            'user' => $user,
            'course' => $course,
            'modules' => $modules,
            'history' => $history
        ]);
    }

    /**
     * Approve course (approval workflow)
     */
    public function approveCourseSubmission(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/approvals/courses/' . $id);
            return;
        }

        $user = $this->getCurrentUser();
        $reason = trim($_POST['reason'] ?? '');

        $success = Course::approve($id, $user['id'], $reason);

        if ($success) {
            $this->redirect('/admin/approvals?success=course_approved');
        } else {
            $this->redirect('/admin/approvals/courses/' . $id . '?error=approval_failed');
        }
    }

    /**
     * Reject course (approval workflow)
     */
    public function rejectCourseSubmission(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/approvals/courses/' . $id);
            return;
        }

        $user = $this->getCurrentUser();
        $reason = trim($_POST['reason'] ?? '');

        if (empty($reason)) {
            $this->redirect('/admin/approvals/courses/' . $id . '?error=reason_required');
            return;
        }

        $success = Course::reject($id, $user['id'], $reason);

        if ($success) {
            $this->redirect('/admin/approvals?success=course_rejected');
        } else {
            $this->redirect('/admin/approvals/courses/' . $id . '?error=rejection_failed');
        }
    }

    /**
     * Approve cohort submission
     */
    public function approveCohortSubmission(): void
    {
        $cohortId = (int)($_POST['cohort_id'] ?? 0);
        $user = $this->getCurrentUser();

        if (!$cohortId) {
            $this->jsonResponse(['success' => false, 'error' => 'Invalid cohort ID'], 400);
            return;
        }

        $cohort = $this->cohortRepo->find($cohortId);
        if (!$cohort) {
            $this->jsonResponse(['success' => false, 'error' => 'Cohort not found'], 404);
            return;
        }

        if ($cohort['approval_status'] !== 'pending_approval') {
            $this->jsonResponse(['success' => false, 'error' => 'Cohort is not pending approval'], 400);
            return;
        }

        $success = $this->cohortRepo->update($cohortId, [
            'approval_status' => 'approved',
            'approved_by' => $user['id'],
            'approved_at' => date('Y-m-d H:i:s'),
            'rejection_reason' => null
        ]);

        if ($success) {
            // Send notification to facilitator
            if (!empty($cohort['facilitator_id'])) {
                $this->notificationService->notifyCohortApproved($cohort['facilitator_id'], $cohort);
            }

            $this->jsonResponse(['success' => true, 'message' => 'Cohort approved successfully']);
        } else {
            $this->jsonResponse(['success' => false, 'error' => 'Failed to approve cohort'], 500);
        }
    }

    /**
     * Reject cohort submission
     */
    public function rejectCohortSubmission(): void
    {
        $cohortId = (int)($_POST['cohort_id'] ?? 0);
        $reason = trim($_POST['reason'] ?? '');
        $user = $this->getCurrentUser();

        if (!$cohortId) {
            $this->jsonResponse(['success' => false, 'error' => 'Invalid cohort ID'], 400);
            return;
        }

        if (empty($reason)) {
            $this->jsonResponse(['success' => false, 'error' => 'Rejection reason is required'], 400);
            return;
        }

        $cohort = $this->cohortRepo->find($cohortId);
        if (!$cohort) {
            $this->jsonResponse(['success' => false, 'error' => 'Cohort not found'], 404);
            return;
        }

        if ($cohort['approval_status'] !== 'pending_approval') {
            $this->jsonResponse(['success' => false, 'error' => 'Cohort is not pending approval'], 400);
            return;
        }

        $success = $this->cohortRepo->update($cohortId, [
            'approval_status' => 'rejected',
            'rejection_reason' => $reason,
            'approved_by' => null,
            'approved_at' => null
        ]);

        if ($success) {
            // Send notification to facilitator
            if (!empty($cohort['facilitator_id'])) {
                $this->notificationService->notifyCohortRejected($cohort['facilitator_id'], $cohort, $reason);
            }

            $this->jsonResponse(['success' => true, 'message' => 'Cohort rejected successfully']);
        } else {
            $this->jsonResponse(['success' => false, 'error' => 'Failed to reject cohort'], 500);
        }
    }

    /**
     * JSON response helper
     */
    protected function jsonResponse(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
