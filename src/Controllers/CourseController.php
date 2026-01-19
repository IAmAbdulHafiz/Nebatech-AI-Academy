<?php

namespace Nebatech\Controllers;

use Nebatech\Core\Controller;
use Nebatech\Models\Course;
use Nebatech\Models\Module;
use Nebatech\Models\Enrollment;

class CourseController extends Controller
{
    /**
     * Show all courses
     */
    public function index()
    {
        $db = \Nebatech\Core\Database::connect();
        
        // Pagination
        $perPage = 9;
        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $offset = ($page - 1) * $perPage;
        
        // Build query with filters - show only bundle/main courses (not sub-courses)
        $where = ["c.status = 'published'", "c.is_bundle = 1"];
        $params = [];
        
        // Search filter
        if (!empty($_GET['search'])) {
            $where[] = "(c.title LIKE ? OR c.description LIKE ?)";
            $searchTerm = '%' . $_GET['search'] . '%';
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }
        
        // Category filter
        if (!empty($_GET['category'])) {
            $where[] = "c.category = ?";
            $params[] = $_GET['category'];
        }
        
        // Level filter
        if (!empty($_GET['level'])) {
            $where[] = "c.level = ?";
            $params[] = $_GET['level'];
        }
        
        // Get total count for pagination
        $countSql = "SELECT COUNT(*) FROM courses c WHERE " . implode(" AND ", $where);
        $countStmt = $db->prepare($countSql);
        $countStmt->execute($params);
        $totalCourses = $countStmt->fetchColumn();
        $totalPages = ceil($totalCourses / $perPage);
        
        // Build ORDER BY
        $orderBy = "c.created_at DESC";
        if (!empty($_GET['sort'])) {
            switch ($_GET['sort']) {
                case 'popular':
                    $orderBy = "c.enrollment_count DESC";
                    break;
                case 'rating':
                    $orderBy = "c.rating DESC";
                    break;
                case 'newest':
                    $orderBy = "c.created_at DESC";
                    break;
                case 'title':
                    $orderBy = "c.title ASC";
                    break;
            }
        }
        
        // Fetch courses with real enrollment counts from enrollments table
        $sql = "SELECT c.*, 
                (SELECT COUNT(*) FROM courses sub WHERE sub.parent_course_id = c.id) as sub_course_count,
                (SELECT COUNT(*) FROM enrollments e WHERE e.course_id = c.id) as real_enrollment_count
                FROM courses c 
                WHERE " . implode(" AND ", $where) . " 
                ORDER BY " . $orderBy . " LIMIT ? OFFSET ?";
        $stmt = $db->prepare($sql);
        $stmt->execute(array_merge($params, [$perPage, $offset]));
        $courses = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        // Use real enrollment data if available, otherwise fall back to stored sample data
        foreach ($courses as &$course) {
            if ($course['real_enrollment_count'] > 0) {
                $course['enrollment_count'] = $course['real_enrollment_count'];
            }
            // Rating and review_count remain from database (no reviews table yet)
        }
        unset($course);
        
        // Check enrollment status if user is logged in
        if (isset($_SESSION['user_id'])) {
            $enrolledStmt = $db->prepare("SELECT course_id FROM enrollments WHERE user_id = ?");
            $enrolledStmt->execute([$_SESSION['user_id']]);
            $enrolledCourses = $enrolledStmt->fetchAll(\PDO::FETCH_COLUMN);
            
            // Add enrollment status to each course
            foreach ($courses as &$course) {
                $course['is_enrolled'] = in_array($course['id'], $enrolledCourses);
            }
            unset($course);
        }
        
        // Get all unique categories from courses table
        $categoriesStmt = $db->query("SELECT DISTINCT category as slug, category as name FROM courses WHERE category IS NOT NULL AND status = 'published' ORDER BY category");
        $allCategories = $categoriesStmt->fetchAll(\PDO::FETCH_ASSOC);
        
        // Get stats for bundle courses only
        $statsStmt = $db->query("SELECT 
            COUNT(*) as total_courses,
            COALESCE(SUM(enrollment_count), 0) as total_enrollments,
            COALESCE(AVG(rating), 0) as avg_rating
            FROM courses WHERE status = 'published' AND is_bundle = 1");
        $stats = $statsStmt->fetch(\PDO::FETCH_ASSOC);
        
        return $this->render('courses/index', [
            'courses' => $courses,
            'allCategories' => $allCategories,
            'totalCourses' => $stats['total_courses'],
            'totalEnrollments' => $stats['total_enrollments'],
            'avgRating' => $stats['avg_rating'],
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'perPage' => $perPage
        ], 'main');
    }

    /**
     * Show individual course details
     */
    public function show(string $slug = '')
    {
        if (empty($slug)) {
            http_response_code(404);
            return $this->render('errors/404', ['title' => 'Course Not Found']);
        }

        $db = \Nebatech\Core\Database::connect();

        // Fetch course by slug
        $course = Course::findBySlug($slug);
        
        if (!$course) {
            http_response_code(404);
            return $this->render('errors/404', ['title' => 'Course Not Found'], 'main');
        }

        // Get sub-courses if this is a bundle/main course
        $subCourses = [];
        if ($course['is_bundle']) {
            $subStmt = $db->prepare("
                SELECT * FROM courses 
                WHERE parent_course_id = ? AND status = 'published'
                ORDER BY level, title
            ");
            $subStmt->execute([$course['id']]);
            $subCourses = $subStmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        // Get course modules with lessons
        $modules = Module::getByCourse($course['id'], 'published');

        // Check if user is enrolled (if logged in)
        $isEnrolled = false;
        if (isset($_SESSION['user_id'])) {
            $isEnrolled = Enrollment::isEnrolled($_SESSION['user_id'], $course['id']);
        }

        // Get related courses (same category bundles, excluding current course)
        $relatedCourses = [];
        if (!empty($course['category'])) {
            $relatedStmt = $db->prepare("
                SELECT * FROM courses 
                WHERE category = ? AND is_bundle = 1 AND status = 'published' AND id != ?
                LIMIT 3
            ");
            $relatedStmt->execute([$course['category'], $course['id']]);
            $relatedCourses = $relatedStmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        return $this->render('courses/show', [
            'title' => $course['title'] . ' - Nebatech Software Solutions Ltd',
            'course' => $course,
            'subCourses' => $subCourses,
            'modules' => $modules,
            'isEnrolled' => $isEnrolled,
            'relatedCourses' => $relatedCourses
        ], 'main');
    }

    /**
     * Show course learning page (for enrolled students)
     */
    public function learn(string $slug = '')
    {
        if (empty($slug)) {
            http_response_code(404);
            return $this->render('errors/404', ['title' => 'Course Not Found'], 'main');
        }

        // Require authentication
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['redirect_after_login'] = "/courses/$slug/learn";
            header('Location: ' . url('/login'));
            exit;
        }

        $db = \Nebatech\Core\Database::connect();
        $userId = $_SESSION['user_id'];

        // Fetch course by slug
        $course = Course::findBySlug($slug);
        
        if (!$course) {
            http_response_code(404);
            return $this->render('errors/404', ['title' => 'Course Not Found'], 'main');
        }

        // Check enrollment
        $enrollment = Enrollment::getByUserAndCourse($userId, $course['id']);
        
        // If not enrolled, redirect to enrollment page
        if (!$enrollment) {
            $_SESSION['info_message'] = 'Please enroll in this course to access the lessons.';
            header('Location: ' . url("/courses/$slug/enroll"));
            exit;
        }

        // Get user data
        $user = \Nebatech\Models\User::findById($userId);

        // Get modules with lessons
        $modules = Module::getByCourse($course['id'], 'published');
        
        // Fetch lessons for each module
        foreach ($modules as &$module) {
            $module['lessons'] = \Nebatech\Models\Lesson::getByModule($module['id']);
        }
        unset($module);
        
        // Get lesson progress for this enrollment
        $lessonProgress = \Nebatech\Models\Academic\LessonProgress::getByEnrollment($enrollment['id']);
        $progressMap = [];
        foreach ($lessonProgress as $lp) {
            $progressMap[$lp['lesson_id']] = $lp;
        }

        // Add progress status to each lesson
        foreach ($modules as &$module) {
            if (!empty($module['lessons'])) {
                foreach ($module['lessons'] as &$lesson) {
                    $progress = $progressMap[$lesson['id']] ?? null;
                    $lesson['is_completed'] = $progress && $progress['status'] === 'completed';
                    $lesson['is_in_progress'] = $progress && $progress['status'] === 'in_progress';
                    $lesson['has_assignment'] = !empty($lesson['assignment_id']);
                    $lesson['progress'] = $progress;
                }
                unset($lesson);
            }
        }
        unset($module);

        // Find the resume lesson (first incomplete or in_progress lesson)
        $resumeLesson = null;
        foreach ($modules as $module) {
            if (!empty($module['lessons'])) {
                foreach ($module['lessons'] as $lesson) {
                    $progress = $progressMap[$lesson['id']] ?? null;
                    if (!$progress || $progress['status'] !== 'completed') {
                        $resumeLesson = array_merge($lesson, [
                            'status' => $progress['status'] ?? 'not_started',
                            'module_title' => $module['title']
                        ]);
                        break 2;
                    }
                }
            }
        }

        // If all lessons completed, set the first lesson as resume
        if (!$resumeLesson && !empty($modules) && !empty($modules[0]['lessons'])) {
            $resumeLesson = $modules[0]['lessons'][0];
        }

        return $this->render('courses/learn', [
            'title' => $course['title'] . ' - Learning',
            'course' => $course,
            'modules' => $modules,
            'enrollment' => $enrollment,
            'progressMap' => $progressMap,
            'resumeLesson' => $resumeLesson,
            'user' => $user
        ], 'student');
    }

    /**
     * Show individual lesson (for enrolled students)
     */
    public function lesson(string $slug = '', string $lessonId = '')
    {
        if (empty($slug) || empty($lessonId)) {
            http_response_code(404);
            return $this->render('errors/404', ['title' => 'Lesson Not Found'], 'main');
        }

        // Require authentication
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['redirect_after_login'] = "/courses/$slug/lesson/$lessonId";
            header('Location: ' . url('/login'));
            exit;
        }

        $db = \Nebatech\Core\Database::connect();
        $userId = $_SESSION['user_id'];

        // Fetch course by slug
        $course = Course::findBySlug($slug);
        
        if (!$course) {
            http_response_code(404);
            return $this->render('errors/404', ['title' => 'Course Not Found'], 'main');
        }

        // Check enrollment
        $enrollment = Enrollment::getByUserAndCourse($userId, $course['id']);
        
        // Allow facilitators to preview without enrollment
        $user = \Nebatech\Models\User::findById($userId);
        $isFacilitator = $user['role'] === 'facilitator' || $user['role'] === 'admin';
        
        if (!$enrollment && !$isFacilitator) {
            $_SESSION['info_message'] = 'Please enroll in this course to access the lessons.';
            header('Location: ' . url("/courses/$slug/enroll"));
            exit;
        }

        // Get the lesson
        $lesson = \Nebatech\Models\Lesson::findById((int)$lessonId);
        
        if (!$lesson) {
            http_response_code(404);
            return $this->render('errors/404', ['title' => 'Lesson Not Found'], 'main');
        }

        // Verify lesson belongs to this course
        if ($lesson['course_id'] != $course['id']) {
            http_response_code(404);
            return $this->render('errors/404', ['title' => 'Lesson Not Found'], 'main');
        }

        // Get modules with lessons for sidebar
        $modules = Module::getByCourse($course['id'], 'published');
        
        // Fetch lessons for each module
        foreach ($modules as &$module) {
            $module['lessons'] = \Nebatech\Models\Lesson::getByModule($module['id']);
        }
        unset($module);

        // Get current module
        $currentModule = null;
        foreach ($modules as $module) {
            if ($module['id'] == $lesson['module_id']) {
                $currentModule = $module;
                break;
            }
        }

        // Get lesson progress
        $lessonProgress = null;
        if ($enrollment) {
            $lessonProgress = \Nebatech\Models\Academic\LessonProgress::findByUserAndLesson($userId, (int)$lessonId);
            
            // Mark as started if not already
            if (!$lessonProgress) {
                \Nebatech\Models\Academic\LessonProgress::markAsStarted($userId, (int)$lessonId, $enrollment['id']);
                $lessonProgress = \Nebatech\Models\Academic\LessonProgress::findByUserAndLesson($userId, (int)$lessonId);
            }
        }

        // Get progress map for all lessons
        $progressMap = [];
        if ($enrollment) {
            $allProgress = \Nebatech\Models\Academic\LessonProgress::getByEnrollment($enrollment['id']);
            foreach ($allProgress as $lp) {
                $progressMap[$lp['lesson_id']] = $lp;
            }
        }

        // Add progress status to each lesson
        foreach ($modules as &$module) {
            if (!empty($module['lessons'])) {
                foreach ($module['lessons'] as &$l) {
                    $progress = $progressMap[$l['id']] ?? null;
                    $l['is_completed'] = $progress && $progress['status'] === 'completed';
                    $l['is_in_progress'] = $progress && $progress['status'] === 'in_progress';
                    $l['has_assignment'] = !empty($l['assignment_id']);
                    $l['progress'] = $progress;
                }
                unset($l);
            }
        }
        unset($module);

        // Find next and previous lessons
        $allLessons = [];
        foreach ($modules as $module) {
            if (!empty($module['lessons'])) {
                foreach ($module['lessons'] as $l) {
                    $allLessons[] = $l;
                }
            }
        }
        
        $currentIndex = null;
        foreach ($allLessons as $index => $l) {
            if ($l['id'] == $lessonId) {
                $currentIndex = $index;
                break;
            }
        }
        
        $prevLesson = $currentIndex > 0 ? $allLessons[$currentIndex - 1] : null;
        $nextLesson = isset($allLessons[$currentIndex + 1]) ? $allLessons[$currentIndex + 1] : null;

        // Get notes and bookmark status from lessonProgress
        $notes = $lessonProgress['notes'] ?? '';
        $isBookmarked = !empty($lessonProgress['bookmarked']);

        // Fetch CBT data for this lesson
        $cbtObjectives = [];
        $cbtPractical = null;
        $cbtQuiz = null;
        $cbtQuizAttempt = null;
        $cbtPracticalSubmission = null;
        $cbtHintCount = 0;

        try {
            // Learning Objectives
            $objStmt = $db->prepare("SELECT * FROM learning_objectives WHERE lesson_id = ? ORDER BY objective_number");
            $objStmt->execute([(int)$lessonId]);
            $cbtObjectives = $objStmt->fetchAll(\PDO::FETCH_ASSOC);

            // Quiz for this lesson
            $quizStmt = $db->prepare("SELECT * FROM quizzes WHERE lesson_id = ?");
            $quizStmt->execute([(int)$lessonId]);
            $cbtQuiz = $quizStmt->fetch(\PDO::FETCH_ASSOC);

            if ($cbtQuiz) {
                // Get question count
                $countStmt = $db->prepare("SELECT COUNT(*) FROM quiz_questions WHERE quiz_id = ?");
                $countStmt->execute([$cbtQuiz['id']]);
                $cbtQuiz['question_count'] = $countStmt->fetchColumn();

                // Get user's best/latest attempt
                if ($enrollment) {
                    $attemptStmt = $db->prepare("SELECT * FROM quiz_attempts 
                                                  WHERE quiz_id = ? AND user_id = ? 
                                                  ORDER BY score DESC, completed_at DESC LIMIT 1");
                    $attemptStmt->execute([$cbtQuiz['id'], $userId]);
                    $cbtQuizAttempt = $attemptStmt->fetch(\PDO::FETCH_ASSOC);
                }
            }

            // Practical exercise for this lesson
            $practStmt = $db->prepare("SELECT * FROM practicals WHERE lesson_id = ?");
            $practStmt->execute([(int)$lessonId]);
            $cbtPractical = $practStmt->fetch(\PDO::FETCH_ASSOC);

            if ($cbtPractical && $enrollment) {
                // Get user's submission
                $subStmt = $db->prepare("SELECT * FROM practical_submissions 
                                          WHERE practical_id = ? AND user_id = ? 
                                          ORDER BY submitted_at DESC LIMIT 1");
                $subStmt->execute([$cbtPractical['id'], $userId]);
                $cbtPracticalSubmission = $subStmt->fetch(\PDO::FETCH_ASSOC);

                // Get hint count
                $hintStmt = $db->prepare("SELECT hints_used FROM practical_hints 
                                           WHERE practical_id = ? AND user_id = ?");
                $hintStmt->execute([$cbtPractical['id'], $userId]);
                $hintRow = $hintStmt->fetch(\PDO::FETCH_ASSOC);
                $cbtHintCount = $hintRow ? (int)$hintRow['hints_used'] : 0;
            }
        } catch (\Exception $e) {
            // CBT tables might not exist yet, silently ignore
            error_log("CBT data fetch error: " . $e->getMessage());
        }

        return $this->render('courses/view', [
            'title' => $lesson['title'] . ' - ' . $course['title'],
            'course' => $course,
            'modules' => $modules,
            'currentModule' => $currentModule,
            'currentLesson' => $lesson,
            'enrollment' => $enrollment,
            'lessonProgress' => $lessonProgress,
            'progressMap' => $progressMap,
            'prevLesson' => $prevLesson,
            'nextLesson' => $nextLesson,
            'notes' => $notes,
            'isBookmarked' => $isBookmarked,
            'user' => $user,
            // CBT Data
            'cbtObjectives' => $cbtObjectives,
            'cbtQuiz' => $cbtQuiz,
            'cbtQuizAttempt' => $cbtQuizAttempt,
            'cbtPractical' => $cbtPractical,
            'cbtPracticalSubmission' => $cbtPracticalSubmission,
            'cbtHintCount' => $cbtHintCount
        ], 'student');
    }
}
