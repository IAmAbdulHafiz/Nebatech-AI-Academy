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
        
        // Build query with filters
        $where = ["status = 'published'"];
        $params = [];
        
        // Search filter
        if (!empty($_GET['search'])) {
            $where[] = "(title LIKE ? OR description LIKE ?)";
            $searchTerm = '%' . $_GET['search'] . '%';
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }
        
        // Category filter
        if (!empty($_GET['category'])) {
            $where[] = "category = ?";
            $params[] = $_GET['category'];
        }
        
        // Level filter
        if (!empty($_GET['level'])) {
            $where[] = "level = ?";
            $params[] = $_GET['level'];
        }
        
        // Get total count for pagination
        $countSql = "SELECT COUNT(*) FROM courses WHERE " . implode(" AND ", $where);
        $countStmt = $db->prepare($countSql);
        $countStmt->execute($params);
        $totalCourses = $countStmt->fetchColumn();
        $totalPages = ceil($totalCourses / $perPage);
        
        // Build ORDER BY
        $orderBy = "created_at DESC";
        if (!empty($_GET['sort'])) {
            switch ($_GET['sort']) {
                case 'popular':
                    $orderBy = "enrollment_count DESC";
                    break;
                case 'rating':
                    $orderBy = "rating DESC";
                    break;
                case 'newest':
                    $orderBy = "created_at DESC";
                    break;
                case 'title':
                    $orderBy = "title ASC";
                    break;
            }
        }
        
        $sql = "SELECT * FROM courses WHERE " . implode(" AND ", $where) . " ORDER BY " . $orderBy . " LIMIT ? OFFSET ?";
        $stmt = $db->prepare($sql);
        $stmt->execute(array_merge($params, [$perPage, $offset]));
        $courses = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
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
        
        // Get all categories
        $categoriesStmt = $db->query("SELECT DISTINCT category FROM courses WHERE status = 'published' ORDER BY category");
        $allCategories = $categoriesStmt->fetchAll(\PDO::FETCH_COLUMN);
        
        // Get stats
        $statsStmt = $db->query("SELECT 
            COUNT(*) as total_courses,
            SUM(enrollment_count) as total_enrollments,
            AVG(rating) as avg_rating
            FROM courses WHERE status = 'published'");
        $stats = $statsStmt->fetch(\PDO::FETCH_ASSOC);
        
        echo $this->render('courses/index', [
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
     * Show Frontend Development courses
     */
    public function frontend()
    {
        echo $this->render('courses/frontend', [], 'main');
    }

    /**
     * Show Backend Development courses
     */
    public function backend()
    {
        echo $this->render('courses/backend', [], 'main');
    }

    /**
     * Show Full Stack courses
     */
    public function fullstack()
    {
        echo $this->render('courses/fullstack', [], 'main');
    }

    /**
     * Show Mobile Development courses
     */
    public function mobile()
    {
        echo $this->render('courses/mobile', [], 'main');
    }

    /**
     * Show AI & Machine Learning courses
     */
    public function ai()
    {
        echo $this->render('courses/ai', [], 'main');
    }

    /**
     * Show Data Science courses
     */
    public function dataScience()
    {
        echo $this->render('courses/data-science', [], 'main');
    }

    /**
     * Show Cybersecurity courses
     */
    public function cybersecurity()
    {
        echo $this->render('courses/cybersecurity', [], 'main');
    }

    /**
     * Show Cloud Computing courses
     */
    public function cloud()
    {
        echo $this->render('courses/cloud', [], 'main');
    }

    /**
     * Show Database Design & Administration
     */
    public function database()
    {
        echo $this->render('courses/database', [], 'main');
    }

    /**
     * Show Microsoft Office Suite
     */
    public function microsoftOffice()
    {
        echo $this->render('courses/microsoft-office', [], 'main');
    }

    /**
     * Show Networking Engineering
     */
    public function networking()
    {
        echo $this->render('courses/networking', [], 'main');
    }

    /**
     * Show Computer Hardware
     */
    public function hardware()
    {
        echo $this->render('courses/hardware', [], 'main');
    }

    /**
     * Show Digital Literacy
     */
    public function digitalLiteracy()
    {
        echo $this->render('courses/digital-literacy', [], 'main');
    }

    /**
     * Show Video Editing & Production
     */
    public function videoEditing()
    {
        echo $this->render('courses/video-editing', [], 'main');
    }

    /**
     * Show Graphic Design & Digital Arts
     */
    public function graphicDesign()
    {
        echo $this->render('courses/graphic-design', [], 'main');
    }

    /**
     * Show individual course details
     */
    public function show(string $slug = '')
    {
        if (empty($slug)) {
            http_response_code(404);
            echo $this->render('errors/404', ['title' => 'Course Not Found']);
            return;
        }

        // Fetch course by slug
        $course = Course::findBySlug($slug);
        
        if (!$course) {
            http_response_code(404);
            echo $this->render('errors/404', ['title' => 'Course Not Found'], 'main');
            return;
        }

        // Get course modules with lessons
        $modules = Module::getByCourse($course['id'], 'published');

        // Check if user is enrolled (if logged in)
        $isEnrolled = false;
        if (isset($_SESSION['user_id'])) {
            $isEnrolled = Enrollment::isEnrolled($_SESSION['user_id'], $course['id']);
        }

        // Get related courses (same category, excluding current course)
        $relatedCourses = [];
        if (!empty($course['category'])) {
            $relatedCourses = Course::getAll([
                'category' => $course['category'],
                'status' => 'published',
                'limit' => 3
            ]);
            
            // Filter out current course
            $relatedCourses = array_filter($relatedCourses, function($c) use ($course) {
                return $c['id'] !== $course['id'];
            });
        }

        echo $this->render('courses/show', [
            'title' => $course['title'] . ' - Nebatech AI Academy',
            'course' => $course,
            'modules' => $modules,
            'isEnrolled' => $isEnrolled,
            'relatedCourses' => $relatedCourses
        ], 'main');
    }
}
