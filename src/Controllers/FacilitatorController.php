<?php

namespace Nebatech\Controllers;

use Nebatech\Core\Controller;
use Nebatech\Models\User;
use Nebatech\Models\Course;
use Nebatech\Models\Module;
use Nebatech\Models\Lesson;
use Nebatech\Models\Submission;
use Nebatech\Models\Assignment;
use Nebatech\Models\Cohort;
use Nebatech\Models\Enrollment;
use Nebatech\Repositories\SubmissionRepository;
use Nebatech\Repositories\CohortRepository;
use Nebatech\Repositories\EnrollmentRepository;
use Nebatech\Repositories\CourseRepository;
use Nebatech\Repositories\UserRepository;
use Nebatech\Services\NotificationService;
use Nebatech\Services\EmailService;

class FacilitatorController extends Controller
{
    private SubmissionRepository $submissionRepo;
    private CohortRepository $cohortRepo;
    private EnrollmentRepository $enrollmentRepo;
    private CourseRepository $courseRepo;
    private UserRepository $userRepo;
    private NotificationService $notificationService;
    private EmailService $emailService;

    public function __construct()
    {
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Require authentication and facilitator role
        $this->requireAuth();
        $this->requireRole('facilitator');
        
        // Initialize repositories
        $this->submissionRepo = new SubmissionRepository();
        $this->cohortRepo = new CohortRepository();
        $this->enrollmentRepo = new EnrollmentRepository();
        $this->courseRepo = new CourseRepository();
        $this->userRepo = new UserRepository();
        $this->notificationService = new NotificationService();
        $this->emailService = new EmailService();
    }

    /**
     * Facilitator dashboard
     */
    public function dashboard()
    {
        $user = $this->getCurrentUser();
        
        // Get facilitator's courses
        $courses = $this->courseRepo->getByFacilitator($user['id']);
        
        // Get pending submissions for facilitator's courses
        $courseIds = array_column($courses, 'id');
        $pendingSubmissions = [];
        
        if (!empty($courseIds)) {
            $pendingSubmissions = $this->submissionRepo->getPendingForFacilitator($user['id']);
            // Limit to 10 for dashboard
            $pendingSubmissions = array_slice($pendingSubmissions, 0, 10);
        }

        // Get stats
        $stats = [
            'total_courses' => count($courses),
            'published_courses' => count(array_filter($courses, fn($c) => $c['status'] === 'published')),
            'draft_courses' => count(array_filter($courses, fn($c) => $c['status'] === 'draft')),
            'pending_submissions' => count($pendingSubmissions)
        ];

        echo $this->view('facilitator/dashboard', [
            'title' => 'Facilitator Dashboard',
            'user' => $user,
            'courses' => $courses,
            'pendingSubmissions' => $pendingSubmissions,
            'stats' => $stats
        ]);
    }

    /**
     * List all courses created by facilitator
     */
    public function courses()
    {
        $user = $this->getCurrentUser();
        
        // Get facilitator's courses
        $courses = $this->courseRepo->getByFacilitator($user['id']);
        
        // Get stats
        $stats = [
            'total_courses' => count($courses),
            'published_courses' => count(array_filter($courses, fn($c) => $c['status'] === 'published')),
            'draft_courses' => count(array_filter($courses, fn($c) => $c['status'] === 'draft'))
        ];

        echo $this->view('facilitator/courses', [
            'title' => 'My Courses',
            'user' => $user,
            'courses' => $courses,
            'stats' => $stats
        ]);
    }

    /**
     * Show course creation form
     */
    public function createCourse()
    {
        $user = $this->getCurrentUser();
        $errors = $_SESSION['errors'] ?? [];
        $oldInput = $_SESSION['old_input'] ?? [];
        
        unset($_SESSION['errors'], $_SESSION['old_input']);

        echo $this->view('facilitator/create-course', [
            'title' => 'Create Course',
            'user' => $user,
            'errors' => $errors,
            'oldInput' => $oldInput
        ]);
    }

    /**
     * Store new course
     */
    public function storeCourse()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . url('/facilitator/courses/create'));
            exit;
        }

        $user = $this->getCurrentUser();

        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $categorySlug = $_POST['category'] ?? '';
        $level = $_POST['level'] ?? 'beginner';
        $durationHours = (int)($_POST['duration_hours'] ?? 0);
        $status = $_POST['status'] ?? 'draft';

        $errors = [];

        // Validate input
        if (empty($title)) {
            $errors['title'] = 'Course title is required.';
        } elseif (strlen($title) < 5) {
            $errors['title'] = 'Course title must be at least 5 characters.';
        }

        if (empty($description)) {
            $errors['description'] = 'Course description is required.';
        } elseif (strlen($description) < 20) {
            $errors['description'] = 'Course description must be at least 20 characters.';
        }

        if (empty($categorySlug)) {
            $errors['category'] = 'Course category is required.';
        }
        
        // Get category ID from slug
        $categoryId = null;
        if (!empty($categorySlug)) {
            $categoryData = \Nebatech\Core\Database::fetch(
                "SELECT id FROM course_categories WHERE slug = :slug AND is_active = 1",
                ['slug' => $categorySlug]
            );
            if ($categoryData) {
                $categoryId = $categoryData['id'];
            } else {
                $errors['category'] = 'Invalid category selected.';
            }
        }

        if ($durationHours < 1) {
            $errors['duration_hours'] = 'Duration must be at least 1 hour.';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_input'] = $_POST;
            header('Location: ' . url('/facilitator/courses/create'));
            exit;
        }

        // Handle thumbnail upload
        $thumbnail = null;
        if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
            $thumbnail = $this->handleFileUpload($_FILES['thumbnail'], 'thumbnails');
        }

        // Create course
        $courseId = $this->courseRepo->create([
            'title' => $title,
            'description' => $description,
            'category_id' => $categoryId,
            'level' => $level,
            'duration_hours' => $durationHours,
            'thumbnail' => $thumbnail,
            'facilitator_id' => $user['id'],
            'status' => $status,
            'ai_generated' => false
        ]);

        if (!$courseId) {
            $_SESSION['errors'] = ['general' => 'Failed to create course. Please try again.'];
            $_SESSION['old_input'] = $_POST;
            header('Location: ' . url('/facilitator/courses/create'));
            exit;
        }

        $_SESSION['success'] = 'Course created successfully!';
        
        // Check if there's a redirect_to parameter
        $redirectTo = $_POST['redirect_to'] ?? null;
        if ($redirectTo) {
            header('Location: ' . $redirectTo);
        } else {
            header('Location: ' . url('/facilitator/courses/' . $courseId . '/edit'));
        }
        exit;
    }

    /**
     * Edit course
     */
    public function editCourse(int $courseId)
    {
        $user = $this->getCurrentUser();
        $course = $this->courseRepo->findById($courseId);

        if (!$course || $course['facilitator_id'] !== $user['id']) {
            $_SESSION['error'] = 'Course not found or access denied.';
            header('Location: ' . url('/facilitator/dashboard'));
            exit;
        }

        // Get course modules
        $modules = Module::getByCourse($courseId);

        // Get lessons and assignments for each module
        foreach ($modules as &$module) {
            $lessons = Lesson::getByModule($module['id']);
            
            // Get assignments for each lesson
            foreach ($lessons as &$lesson) {
                $lesson['assignments'] = Assignment::getByLesson($lesson['id']);
            }
            
            $module['lessons'] = $lessons;
        }

        $errors = $_SESSION['errors'] ?? [];
        $success = $_SESSION['success'] ?? '';
        
        unset($_SESSION['errors'], $_SESSION['success']);

        echo $this->view('facilitator/edit-course', [
            'title' => 'Edit Course',
            'user' => $user,
            'course' => $course,
            'modules' => $modules,
            'errors' => $errors,
            'success' => $success
        ]);
    }

    /**
     * Update course
     */
    public function updateCourse(int $courseId)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . url('/facilitator/courses/' . $courseId . '/edit'));
            exit;
        }

        $user = $this->getCurrentUser();
        $course = $this->courseRepo->findById($courseId);

        if (!$course || $course['facilitator_id'] !== $user['id']) {
            $_SESSION['error'] = 'Course not found or access denied.';
            header('Location: ' . url('/facilitator/dashboard'));
            exit;
        }

        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $categorySlug = $_POST['category'] ?? '';
        $level = $_POST['level'] ?? 'beginner';
        $durationHours = (int)($_POST['duration_hours'] ?? 0);
        
        // Get category ID from slug
        $categoryId = null;
        if (!empty($categorySlug)) {
            $categoryData = \Nebatech\Core\Database::fetch(
                "SELECT id FROM course_categories WHERE slug = :slug AND is_active = 1",
                ['slug' => $categorySlug]
            );
            if ($categoryData) {
                $categoryId = $categoryData['id'];
            }
        }

        $errors = [];

        if (empty($title)) {
            $errors['title'] = 'Course title is required.';
        }

        if (empty($description)) {
            $errors['description'] = 'Course description is required.';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: ' . url('/facilitator/courses/' . $courseId . '/edit'));
            exit;
        }

        $updateData = [
            'title' => $title,
            'description' => $description,
            'category_id' => $categoryId,
            'level' => $level,
            'duration_hours' => $durationHours
        ];

        // Handle thumbnail upload
        if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
            $thumbnail = $this->handleFileUpload($_FILES['thumbnail'], 'thumbnails');
            $updateData['thumbnail'] = $thumbnail;
        }

        $updated = $this->courseRepo->update($courseId, $updateData);

        if ($updated) {
            $_SESSION['success'] = 'Course updated successfully!';
        } else {
            $_SESSION['errors'] = ['general' => 'Failed to update course.'];
        }

        header('Location: ' . url('/facilitator/courses/' . $courseId . '/edit'));
        exit;
    }

    /**
     * Add module to course
     */
    public function addModule(int $courseId)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . url('/facilitator/courses/' . $courseId . '/edit'));
            exit;
        }

        $user = $this->getCurrentUser();
        $course = $this->courseRepo->findById($courseId);

        if (!$course || $course['facilitator_id'] !== $user['id']) {
            http_response_code(403);
            echo json_encode(['error' => 'Access denied']);
            exit;
        }

        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');

        if (empty($title)) {
            http_response_code(400);
            echo json_encode(['error' => 'Module title is required']);
            exit;
        }

        $moduleId = Module::create([
            'course_id' => $courseId,
            'title' => $title,
            'description' => $description,
            'status' => 'draft'
        ]);

        if ($moduleId) {
            echo json_encode(['success' => true, 'module_id' => $moduleId]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to create module']);
        }
        exit;
    }

    /**
     * Add lesson to module
     */
    public function addLesson(int $moduleId)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
            exit;
        }

        $user = $this->getCurrentUser();
        $module = Module::findById($moduleId);

        if (!$module) {
            http_response_code(404);
            echo json_encode(['error' => 'Module not found']);
            exit;
        }

        // Verify ownership
        $course = $this->courseRepo->findById($module['course_id']);
        if (!$course || $course['facilitator_id'] !== $user['id']) {
            http_response_code(403);
            echo json_encode(['error' => 'Access denied']);
            exit;
        }

        $title = trim($_POST['title'] ?? '');
        $type = $_POST['type'] ?? 'text';
        $content = $_POST['content'] ?? '';

        if (empty($title)) {
            http_response_code(400);
            echo json_encode(['error' => 'Lesson title is required']);
            exit;
        }

        $lessonId = Lesson::create([
            'module_id' => $moduleId,
            'title' => $title,
            'type' => $type,
            'content' => $content,
            'ai_generated' => false
        ]);

        if ($lessonId) {
            echo json_encode(['success' => true, 'lesson_id' => $lessonId]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to create lesson']);
        }
        exit;
    }

    /**
     * Add assignment to lesson
     */
    public function addAssignment()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                http_response_code(405);
                echo json_encode(['error' => 'Method not allowed']);
                exit;
            }

            $user = $this->getCurrentUser();
            
            if (!$user) {
                http_response_code(401);
                echo json_encode(['error' => 'Not authenticated']);
                exit;
            }

            $lessonId = (int)($_POST['lesson_id'] ?? 0);

            if (!$lessonId) {
                http_response_code(400);
                echo json_encode(['error' => 'Lesson ID is required', 'received' => $_POST]);
                exit;
            }

            // Get lesson and verify ownership
            $lesson = Lesson::findById($lessonId);
            if (!$lesson) {
                http_response_code(404);
                echo json_encode(['error' => 'Lesson not found', 'lesson_id' => $lessonId]);
                exit;
            }

            // Verify ownership through course
            $sql = "SELECT c.facilitator_id 
                    FROM courses c
                    INNER JOIN modules m ON c.id = m.course_id
                    WHERE m.id = :module_id";
            
            $courseData = \Nebatech\Core\Database::fetch($sql, ['module_id' => $lesson['module_id']]);
            
            if (!$courseData || $courseData['facilitator_id'] !== $user['id']) {
                http_response_code(403);
                echo json_encode(['error' => 'Access denied', 'user_id' => $user['id'], 'facilitator_id' => $courseData['facilitator_id'] ?? null]);
                exit;
            }

            $title = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $maxScore = (int)($_POST['max_score'] ?? 100);
            $aiFeedbackEnabled = isset($_POST['ai_feedback_enabled']) && $_POST['ai_feedback_enabled'] === '1' ? 1 : 0;

            if (empty($title)) {
                http_response_code(400);
                echo json_encode(['error' => 'Assignment title is required']);
                exit;
            }

            if (empty($description)) {
                http_response_code(400);
                echo json_encode(['error' => 'Assignment description is required']);
                exit;
            }

            // Handle rubric if provided
            $rubric = null;
            if (!empty($_POST['rubric'])) {
                $rubric = $_POST['rubric']; // Can be JSON string or array
            }

            $assignmentData = [
                'lesson_id' => $lessonId,
                'title' => $title,
                'description' => $description,
                'max_score' => $maxScore,
                'rubric' => $rubric,
                'ai_feedback_enabled' => $aiFeedbackEnabled
            ];

            error_log("Creating assignment with data: " . json_encode($assignmentData));

            $assignmentId = Assignment::create($assignmentData);

            if ($assignmentId) {
                echo json_encode(['success' => true, 'assignment_id' => $assignmentId]);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Failed to create assignment - database insert failed', 'data' => $assignmentData]);
            }
        } catch (\Exception $e) {
            error_log("Assignment creation exception: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => 'Exception: ' . $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        }
        exit;
    }

    /**
     * Publish course
     */
    public function publishCourse(int $courseId)
    {
        $user = $this->getCurrentUser();
        $course = $this->courseRepo->findById($courseId);

        if (!$course || $course['facilitator_id'] !== $user['id']) {
            $_SESSION['error'] = 'Course not found or access denied.';
            header('Location: ' . url('/facilitator/dashboard'));
            exit;
        }

        $this->courseRepo->publish($courseId);
        $_SESSION['success'] = 'Course published successfully!';
        
        header('Location: ' . url('/facilitator/courses/' . $courseId . '/edit'));
        exit;
    }

    /**
     * View all submissions for facilitator's courses
     */
    public function submissions()
    {
        $user = $this->getCurrentUser();
        
        // Get facilitator's courses
        $courses = $this->courseRepo->getByFacilitator($user['id']);
        $courseIds = array_column($courses, 'id');
        
        // Get filter parameters
        $status = $_GET['status'] ?? 'all';
        $courseId = isset($_GET['course_id']) ? (int)$_GET['course_id'] : null;
        
        // Build query for submissions
        $sql = "SELECT s.*, 
                       u.first_name,
                       u.last_name,
                       u.email,
                       u.avatar,
                       a.title as assignment_title,
                       a.max_score,
                       l.title as lesson_title,
                       m.title as module_title,
                       c.title as course_title,
                       c.id as course_id
                FROM submissions s
                INNER JOIN users u ON s.user_id = u.id
                INNER JOIN assignments a ON s.assignment_id = a.id
                INNER JOIN lessons l ON a.lesson_id = l.id
                INNER JOIN modules m ON l.module_id = m.id
                INNER JOIN courses c ON m.course_id = c.id
                WHERE c.facilitator_id = :facilitator_id";
        
        $params = ['facilitator_id' => $user['id']];
        
        if ($status !== 'all') {
            $sql .= " AND s.status = :status";
            $params['status'] = $status;
        }
        
        if ($courseId && in_array($courseId, $courseIds)) {
            $sql .= " AND c.id = :course_id";
            $params['course_id'] = $courseId;
        }
        
        $sql .= " ORDER BY s.submitted_at DESC";
        
        $submissions = \Nebatech\Core\Database::fetchAll($sql, $params);
        
        // Get stats
        $stats = $this->getSubmissionStats($user['id']);
        
        echo $this->view('facilitator/submissions', [
            'title' => 'Student Submissions',
            'user' => $user,
            'submissions' => $submissions,
            'courses' => $courses,
            'stats' => $stats,
            'currentStatus' => $status,
            'currentCourseId' => $courseId
        ]);
    }

    /**
     * View individual submission details
     */
    public function viewSubmission(int $submissionId)
    {
        $user = $this->getCurrentUser();
        $submission = $this->submissionRepo->find($submissionId);
        
        if (!$submission) {
            $_SESSION['error'] = 'Submission not found.';
            header('Location: ' . url('/facilitator/submissions'));
            exit;
        }
        
        // Verify facilitator owns the course
        $course = $this->courseRepo->findById($submission['course_id'] ?? 0);
        if (!$course || $course['facilitator_id'] !== $user['id']) {
            $_SESSION['error'] = 'Access denied.';
            header('Location: ' . url('/facilitator/submissions'));
            exit;
        }
        
        // Get student info
        $student = $this->userRepo->findById($submission['user_id']);
        
        // Get assignment details
        $assignment = Assignment::findById($submission['assignment_id']);
        
        echo $this->view('facilitator/view-submission', [
            'title' => 'Review Submission',
            'user' => $user,
            'submission' => $submission,
            'student' => $student,
            'assignment' => $assignment
        ]);
    }

    /**
     * Grade a submission
     */
    public function gradeSubmission()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . url('/facilitator/submissions'));
            exit;
        }
        
        $user = $this->getCurrentUser();
        $submissionId = (int)($_POST['submission_id'] ?? 0);
        $score = (float)($_POST['score'] ?? 0);
        $feedback = trim($_POST['feedback'] ?? '');
        $action = $_POST['action'] ?? 'grade';
        
        $submission = $this->submissionRepo->find($submissionId);
        
        if (!$submission) {
            http_response_code(404);
            echo json_encode(['error' => 'Submission not found']);
            exit;
        }
        
        // Verify facilitator owns the course
        $sql = "SELECT c.facilitator_id 
                FROM courses c
                INNER JOIN modules m ON c.id = m.course_id
                INNER JOIN lessons l ON m.id = l.module_id
                INNER JOIN assignments a ON l.id = a.lesson_id
                WHERE a.id = :assignment_id";
        
        $courseData = \Nebatech\Core\Database::fetch($sql, ['assignment_id' => $submission['assignment_id']]);
        
        if (!$courseData || $courseData['facilitator_id'] !== $user['id']) {
            http_response_code(403);
            echo json_encode(['error' => 'Access denied']);
            exit;
        }
        
        $success = false;
        
        switch ($action) {
            case 'grade':
                $success = $this->submissionRepo->grade($submissionId, [
                    'score' => $score,
                    'feedback' => $feedback,
                    'graded_by' => $user['id'],
                    'status' => 'graded'
                ]);
                break;
                
            case 'verify':
                $success = $this->submissionRepo->grade($submissionId, [
                    'score' => $score,
                    'feedback' => $feedback,
                    'graded_by' => $user['id'],
                    'status' => 'verified'
                ]);
                break;
                
            case 'request_revision':
                $success = $this->submissionRepo->requestRevision($submissionId, $feedback, $user['id']);
                break;
        }
        
        if ($success) {
            echo json_encode(['success' => true, 'message' => 'Submission updated successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to update submission']);
        }
        exit;
    }

    /**
     * View cohorts managed by facilitator
     */
    public function cohorts()
    {
        $user = $this->getCurrentUser();
        
        // Get facilitator's cohorts (all statuses)
        $cohorts = $this->cohortRepo->getAll(['facilitator_id' => $user['id']]);
        
        // Separate by approval status
        $approved = array_filter($cohorts, fn($c) => $c['approval_status'] === 'approved');
        $pending = array_filter($cohorts, fn($c) => $c['approval_status'] === 'pending_approval');
        $drafts = array_filter($cohorts, fn($c) => $c['approval_status'] === 'draft');
        $rejected = array_filter($cohorts, fn($c) => $c['approval_status'] === 'rejected');
        
        echo $this->view('facilitator/cohorts', [
            'title' => 'My Cohorts',
            'user' => $user,
            'cohorts' => $cohorts,
            'approved' => $approved,
            'pending' => $pending,
            'drafts' => $drafts,
            'rejected' => $rejected
        ]);
    }

    /**
     * Show create cohort form
     */
    public function createCohortForm()
    {
        $user = $this->getCurrentUser();
        $programs = require __DIR__ . '/../../config/programs.php';
        
        // Get facilitator's approved courses
        $courses = $this->courseRepo->getByFacilitator($user['id'], ['approval_status' => 'approved']);
        
        echo $this->view('facilitator/create-cohort', [
            'title' => 'Create Cohort',
            'user' => $user,
            'programs' => $programs,
            'courses' => $courses
        ]);
    }

    /**
     * Create new cohort
     */
    public function createCohort()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/facilitator/cohorts/create');
            return;
        }

        $user = $this->getCurrentUser();

        $name = trim($_POST['name'] ?? '');
        $program = trim($_POST['program'] ?? '');
        $startDate = $_POST['start_date'] ?? null;
        $endDate = $_POST['end_date'] ?? null;
        $maxStudents = (int)($_POST['max_students'] ?? 0);
        $description = trim($_POST['description'] ?? '');
        $courseIds = $_POST['course_ids'] ?? [];

        if (empty($name) || empty($program) || empty($startDate)) {
            $this->redirect('/facilitator/cohorts/create?error=missing_fields');
            return;
        }

        // Create cohort with draft status
        $cohortId = $this->cohortRepo->create([
            'name' => $name,
            'program' => $program,
            'facilitator_id' => $user['id'],
            'start_date' => $startDate,
            'end_date' => $endDate ?: null,
            'max_students' => $maxStudents,
            'description' => $description,
            'status' => 'upcoming',
            'approval_status' => 'draft'
        ]);

        if ($cohortId) {
            // Add selected courses to cohort
            if (!empty($courseIds)) {
                foreach ($courseIds as $index => $courseId) {
                    $this->cohortRepo->addCourse($cohortId, (int)$courseId, ['order_index' => $index]);
                }
            }

            $this->redirect('/facilitator/cohorts/' . $cohortId . '?success=created');
        } else {
            $this->redirect('/facilitator/cohorts/create?error=creation_failed');
        }
    }

    /**
     * Submit cohort for approval
     */
    public function submitCohortForApproval()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['error' => 'Invalid request method'], 405);
            return;
        }

        $user = $this->getCurrentUser();
        $cohortId = (int)($_POST['cohort_id'] ?? 0);

        if (!$cohortId) {
            $this->jsonResponse(['error' => 'Cohort ID required'], 400);
            return;
        }

        // Verify ownership
        $cohort = $this->cohortRepo->find($cohortId);
        if (!$cohort || $cohort['facilitator_id'] !== $user['id']) {
            $this->jsonResponse(['error' => 'Access denied'], 403);
            return;
        }

        // Check if cohort has courses
        $courses = $this->cohortRepo->getCourses($cohortId);
        if (empty($courses)) {
            $this->jsonResponse(['error' => 'Cohort must have at least one course before submitting for approval'], 400);
            return;
        }

        // Update approval status
        $success = $this->cohortRepo->update($cohortId, [
            'approval_status' => 'pending_approval',
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        if ($success) {
            // Log the submission in approval history
            \Nebatech\Core\Database::insert('approval_history', [
                'entity_type' => 'cohort',
                'entity_id' => $cohortId,
                'action' => 'submitted',
                'admin_id' => null,
                'reason' => 'Facilitator submitted cohort for approval',
                'created_at' => date('Y-m-d H:i:s')
            ]);

            // Notify all admins about the new submission
            $admins = $this->userRepo->getAll(['role' => 'admin']);
            foreach ($admins as $admin) {
                $this->notificationService->notifySystem(
                    $admin['id'],
                    'New Cohort Pending Approval',
                    "{$user['first_name']} {$user['last_name']} submitted cohort \"{$cohort['name']}\" for approval",
                    '/admin/approvals/cohorts/' . $cohortId
                );
            }

            // Send confirmation notification to facilitator
            $this->notificationService->notifySystem(
                $user['id'],
                'Cohort Submitted for Approval',
                "Your cohort \"{$cohort['name']}\" has been submitted for admin approval. You'll be notified once it's reviewed.",
                '/facilitator/cohorts/' . $cohortId
            );

            $this->jsonResponse([
                'success' => true,
                'message' => 'Cohort submitted for approval successfully'
            ]);
        } else {
            $this->jsonResponse(['error' => 'Failed to submit cohort'], 500);
        }
    }

    /**
     * Add course to facilitator's cohort
     */
    public function addCourseToCohort()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['error' => 'Invalid request method'], 405);
            return;
        }

        $user = $this->getCurrentUser();
        $cohortId = (int)($_POST['cohort_id'] ?? 0);
        $courseId = (int)($_POST['course_id'] ?? 0);
        $startDate = $_POST['start_date'] ?? null;
        $endDate = $_POST['end_date'] ?? null;
        $orderIndex = (int)($_POST['order_index'] ?? 0);

        if (!$cohortId || !$courseId) {
            $this->jsonResponse(['error' => 'Cohort ID and Course ID required'], 400);
            return;
        }

        // Verify cohort ownership
        $cohort = $this->cohortRepo->find($cohortId);
        if (!$cohort || $cohort['facilitator_id'] !== $user['id']) {
            $this->jsonResponse(['error' => 'Access denied'], 403);
            return;
        }

        // Verify course ownership
        $course = $this->courseRepo->findById($courseId);
        if (!$course || $course['facilitator_id'] !== $user['id']) {
            $this->jsonResponse(['error' => 'You can only add your own courses'], 403);
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
            $this->jsonResponse(['error' => 'Failed to add course. It may already be in the cohort.'], 500);
        }
    }

    /**
     * Remove course from facilitator's cohort
     */
    public function removeCourseFromCohort()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['error' => 'Invalid request method'], 405);
            return;
        }

        $user = $this->getCurrentUser();
        $cohortId = (int)($_POST['cohort_id'] ?? 0);
        $courseId = (int)($_POST['course_id'] ?? 0);

        if (!$cohortId || !$courseId) {
            $this->jsonResponse(['error' => 'Cohort ID and Course ID required'], 400);
            return;
        }

        // Verify cohort ownership
        $cohort = $this->cohortRepo->find($cohortId);
        if (!$cohort || $cohort['facilitator_id'] !== $user['id']) {
            $this->jsonResponse(['error' => 'Access denied'], 403);
            return;
        }

        $success = $this->cohortRepo->removeCourse($cohortId, $courseId);

        if ($success) {
            $this->jsonResponse([
                'success' => true,
                'message' => 'Course removed from cohort'
            ]);
        } else {
            $this->jsonResponse(['error' => 'Failed to remove course'], 500);
        }
    }

    /**
     * View cohort details
     */
    public function viewCohort(int $cohortId)
    {
        $user = $this->getCurrentUser();
        $cohort = $this->cohortRepo->find($cohortId);
        
        if (!$cohort || $cohort['facilitator_id'] !== $user['id']) {
            $_SESSION['error'] = 'Cohort not found or access denied.';
            header('Location: ' . url('/facilitator/cohorts'));
            exit;
        }
        
        // Get cohort students with progress
        $students = $this->cohortRepo->getStudents($cohortId);
        
        // Get progress for each student
        foreach ($students as &$student) {
            $enrollments = $this->enrollmentRepo->getByUser($student['id']);
            $student['enrollments'] = $enrollments;
            $student['total_progress'] = 0;
            
            if (!empty($enrollments)) {
                $totalProgress = array_sum(array_column($enrollments, 'progress'));
                $student['total_progress'] = round($totalProgress / count($enrollments), 1);
            }
        }
        
        // Get facilitator's approved courses for the add course modal
        $availableCourses = $this->courseRepo->getByFacilitator($user['id'], [
            'approval_status' => 'approved',
            'status' => 'published'
        ]);
        
        echo $this->view('facilitator/view-cohort', [
            'title' => $cohort['name'],
            'user' => $user,
            'cohort' => $cohort,
            'students' => $students,
            'availableCourses' => $availableCourses
        ]);
    }

    /**
     * View all students enrolled in facilitator's courses
     */
    public function students()
    {
        $user = $this->getCurrentUser();
        
        // Get facilitator's courses
        $courses = $this->courseRepo->getByFacilitator($user['id']);
        $courseIds = array_column($courses, 'id');
        
        if (empty($courseIds)) {
            echo $this->view('facilitator/students', [
                'title' => 'My Students',
                'user' => $user,
                'students' => [],
                'courses' => []
            ]);
            return;
        }
        
        // Get all enrolled students
        $placeholders = implode(',', array_fill(0, count($courseIds), '?'));
        $sql = "SELECT DISTINCT u.*, 
                       COUNT(DISTINCT e.course_id) as enrolled_courses,
                       AVG(e.progress) as average_progress
                FROM users u
                INNER JOIN enrollments e ON u.id = e.user_id
                WHERE e.course_id IN ($placeholders)
                  AND u.role = 'student'
                GROUP BY u.id
                ORDER BY u.first_name, u.last_name";
        
        $students = \Nebatech\Core\Database::fetchAll($sql, $courseIds);
        
        echo $this->view('facilitator/students', [
            'title' => 'My Students',
            'user' => $user,
            'students' => $students,
            'courses' => $courses
        ]);
    }

    /**
     * View individual student progress
     */
    public function viewStudent(int $studentId)
    {
        $user = $this->getCurrentUser();
        $student = $this->userRepo->findById($studentId);
        
        if (!$student || $student['role'] !== 'student') {
            $_SESSION['error'] = 'Student not found.';
            header('Location: ' . url('/facilitator/students'));
            exit;
        }
        
        // Get facilitator's courses
        $courses = $this->courseRepo->getByFacilitator($user['id']);
        $courseIds = array_column($courses, 'id');
        
        // Get student enrollments in facilitator's courses
        $enrollments = [];
        if (!empty($courseIds)) {
            $placeholders = implode(',', array_fill(0, count($courseIds), '?'));
            $sql = "SELECT e.*, c.title as course_title, c.thumbnail
                    FROM enrollments e
                    INNER JOIN courses c ON e.course_id = c.id
                    WHERE e.user_id = ? AND e.course_id IN ($placeholders)
                    ORDER BY e.enrolled_at DESC";
            
            $params = array_merge([$studentId], $courseIds);
            $enrollments = \Nebatech\Core\Database::fetchAll($sql, $params);
        }
        
        // Get student submissions
        $submissions = $this->submissionRepo->getByUser($studentId);
        
        // Get student cohorts
        $cohorts = $this->cohortRepo->getByStudent($studentId);
        
        echo $this->view('facilitator/view-student', [
            'title' => $student['first_name'] . ' ' . $student['last_name'],
            'user' => $user,
            'student' => $student,
            'enrollments' => $enrollments,
            'submissions' => $submissions,
            'cohorts' => $cohorts
        ]);
    }

    /**
     * Get submission statistics for facilitator
     */
    private function getSubmissionStats(int $facilitatorId): array
    {
        $sql = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN s.status = 'pending' THEN 1 ELSE 0 END) as pending,
                    SUM(CASE WHEN s.status = 'graded' THEN 1 ELSE 0 END) as graded,
                    SUM(CASE WHEN s.status = 'verified' THEN 1 ELSE 0 END) as verified,
                    SUM(CASE WHEN s.status = 'revision_needed' THEN 1 ELSE 0 END) as revision_needed,
                    AVG(s.facilitator_score) as average_score
                FROM submissions s
                INNER JOIN assignments a ON s.assignment_id = a.id
                INNER JOIN lessons l ON a.lesson_id = l.id
                INNER JOIN modules m ON l.module_id = m.id
                INNER JOIN courses c ON m.course_id = c.id
                WHERE c.facilitator_id = :facilitator_id";
        
        return \Nebatech\Core\Database::fetch($sql, ['facilitator_id' => $facilitatorId]) ?? [
            'total' => 0,
            'pending' => 0,
            'graded' => 0,
            'verified' => 0,
            'revision_needed' => 0,
            'average_score' => 0
        ];
    }

    /**
     * Handle file upload
     */
    private function handleFileUpload(array $file, string $subfolder = ''): ?string
    {
        $uploadDir = __DIR__ . '/../../storage/uploads/' . $subfolder;
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '_' . time() . '.' . $extension;
        $filepath = $uploadDir . '/' . $filename;

        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            return 'uploads/' . $subfolder . '/' . $filename;
        }

        return null;
    }

    /**
     * Check if user is authenticated
     */
    protected function requireAuth(): void
    {
        if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
            $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
            header('Location: ' . url('/login'));
            exit;
        }
    }

    /**
     * Require specific role
     */
    protected function requireRole(string $role): void
    {
        if ($_SESSION['user_role'] !== $role) {
            header('Location: ' . url('/dashboard'));
            exit;
        }
    }

    /**
     * Get current authenticated user
     */
    protected function getCurrentUser(): ?array
    {
        if (!isset($_SESSION['user_id'])) {
            return null;
        }

        return $this->userRepo->findById($_SESSION['user_id']);
    }
}
