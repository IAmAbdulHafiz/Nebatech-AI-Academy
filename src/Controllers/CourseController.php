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
            'title' => $course['title'] . ' - Nebatech AI Academy',
            'course' => $course,
            'subCourses' => $subCourses,
            'modules' => $modules,
            'isEnrolled' => $isEnrolled,
            'relatedCourses' => $relatedCourses
        ], 'main');
    }
}
