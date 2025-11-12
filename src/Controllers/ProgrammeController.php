<?php

namespace Nebatech\Controllers;

use Nebatech\Core\Controller;
use Nebatech\Core\Database;

class ProgrammeController extends Controller
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    /**
     * Display all training programmes
     */
    public function index()
    {
        // Get all published courses (programmes)
        $stmt = $this->db->prepare("
            SELECT c.*, u.first_name, u.last_name,
                   c.duration_hours as duration,
                   (SELECT COUNT(*) FROM enrollments WHERE course_id = c.id) as enrollment_count
            FROM courses c
            LEFT JOIN users u ON c.facilitator_id = u.id
            WHERE c.status = 'published'
            ORDER BY c.created_at DESC
        ");
        $stmt->execute();
        $programmes = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Get categories
        $categories = [
            'all' => 'All Programmes',
            'ai-ml' => 'AI & Machine Learning',
            'development' => 'Software Development',
            'design' => 'Design & Multimedia',
            'business' => 'Business & Productivity',
            'hardware' => 'Hardware & Repair'
        ];

        return $this->view('public/programmes/index', [
            'title' => 'Competency-Based Training Programs',
            'description' => 'Enhance your skills with our specialized training programs and advance your career today',
            'programmes' => $programmes,
            'categories' => $categories
        ]);
    }

    /**
     * Display a single programme
     */
    public function show($slug)
    {
        // Get programme details
        $stmt = $this->db->prepare("
            SELECT c.*, u.first_name, u.last_name, u.email,
                   c.duration_hours as duration,
                   (SELECT COUNT(*) FROM enrollments WHERE course_id = c.id) as enrollment_count
            FROM courses c
            LEFT JOIN users u ON c.facilitator_id = u.id
            WHERE c.slug = ? AND c.status = 'published'
        ");
        $stmt->execute([$slug]);
        $programme = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$programme) {
            http_response_code(404);
            return $this->view('errors/404', ['title' => 'Programme Not Found']);
        }

        // Get modules and lessons
        $stmt = $this->db->prepare("
            SELECT m.*, 
                   (SELECT COUNT(*) FROM lessons WHERE module_id = m.id) as lesson_count
            FROM modules m
            WHERE m.course_id = ?
            ORDER BY m.order_index ASC
        ");
        $stmt->execute([$programme['id']]);
        $modules = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Get lessons for each module
        foreach ($modules as &$module) {
            $stmt = $this->db->prepare("
                SELECT id, title, type, duration_minutes, order_index
                FROM lessons
                WHERE module_id = ?
                ORDER BY order_index ASC
            ");
            $stmt->execute([$module['id']]);
            $module['lessons'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        // Check if user is enrolled
        $isEnrolled = false;
        if (isset($_SESSION['user_id'])) {
            $stmt = $this->db->prepare("
                SELECT id FROM enrollments 
                WHERE user_id = ? AND course_id = ?
            ");
            $stmt->execute([$_SESSION['user_id'], $programme['id']]);
            $isEnrolled = $stmt->fetch() !== false;
        }

        // Get related programmes
        $stmt = $this->db->prepare("
            SELECT *, duration_hours as duration FROM courses 
            WHERE id != ? AND status = 'published' 
            ORDER BY RAND() 
            LIMIT 3
        ");
        $stmt->execute([$programme['id']]);
        $relatedProgrammes = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $this->view('public/programmes/show', [
            'title' => $programme['title'],
            'description' => $programme['short_description'] ?? substr(strip_tags($programme['description']), 0, 160),
            'programme' => $programme,
            'modules' => $modules,
            'isEnrolled' => $isEnrolled,
            'relatedProgrammes' => $relatedProgrammes
        ]);
    }

    /**
     * Handle programme enrollment
     */
    public function enroll($id)
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['redirect_after_login'] = "/programmes/enroll/$id";
            redirect('/login');
            return;
        }

        // Check if user is a student
        if ($_SESSION['role'] !== 'student') {
            $_SESSION['errors'] = ['Only students can enroll in programmes'];
            redirect("/courses/$id");
            return;
        }

        try {
            // Check if already enrolled
            $stmt = $this->db->prepare("
                SELECT id FROM enrollments 
                WHERE user_id = ? AND course_id = ?
            ");
            $stmt->execute([$_SESSION['user_id'], $id]);
            
            if ($stmt->fetch()) {
                $_SESSION['info'] = 'You are already enrolled in this programme';
                redirect("/courses/$id");
                return;
            }

            // Get course slug for redirect
            $stmt = $this->db->prepare("SELECT slug FROM courses WHERE id = ?");
            $stmt->execute([$id]);
            $course = $stmt->fetch(\PDO::FETCH_ASSOC);

            if (!$course) {
                $_SESSION['errors'] = ['Programme not found'];
                redirect('/programmes');
                return;
            }

            // Create enrollment
            $stmt = $this->db->prepare("
                INSERT INTO enrollments 
                (user_id, course_id, status, progress, enrolled_at) 
                VALUES (?, ?, 'active', 0, NOW())
            ");
            $stmt->execute([$_SESSION['user_id'], $id]);

            $_SESSION['success'] = 'Successfully enrolled in the programme!';
            redirect("/courses/{$course['slug']}");

        } catch (\Exception $e) {
            error_log('Enrollment error: ' . $e->getMessage());
            $_SESSION['errors'] = ['An error occurred during enrollment. Please try again.'];
            redirect("/programmes");
        }
    }

    /**
     * Filter programmes by category
     */
    public function category($category)
    {
        // Use the new category system - filter by category slug
        $courses = \Nebatech\Models\Course::getByCategory($category);
        
        // Get category info for display
        $categoryInfo = \Nebatech\Models\CourseCategory::findBySlug($category);
        $categoryName = $categoryInfo ? $categoryInfo['name'] : ucfirst(str_replace('-', ' ', $category));
        
        // Get all categories for navigation
        $allCategories = \Nebatech\Models\CourseCategory::getActive();
        $categoryOptions = ['all' => 'All Programmes'];
        foreach ($allCategories as $cat) {
            $categoryOptions[$cat['slug']] = $cat['name'];
        }

        return $this->view('public/programmes/index', [
            'title' => $categoryName . ' Programmes',
            'description' => 'Browse our ' . strtolower($categoryName) . ' training programmes',
            'programmes' => $courses,
            'categories' => $categoryOptions,
            'selectedCategory' => $category
        ]);
    }
}
