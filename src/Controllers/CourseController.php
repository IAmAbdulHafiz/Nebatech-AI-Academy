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
        echo $this->render('courses/index', [], 'main');
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
     * Show individual course details
     */
    public function show(array $params = [])
    {
        $slug = $params['slug'] ?? '';
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
        $relatedCourses = Course::getAll([
            'category' => $course['category'],
            'status' => 'published',
            'limit' => 3
        ]);
        
        // Filter out current course
        $relatedCourses = array_filter($relatedCourses, function($c) use ($course) {
            return $c['id'] !== $course['id'];
        });

        echo $this->render('courses/show', [
            'title' => $course['title'] . ' - Nebatech AI Academy',
            'course' => $course,
            'modules' => $modules,
            'isEnrolled' => $isEnrolled,
            'relatedCourses' => $relatedCourses
        ], 'main');
    }
}
