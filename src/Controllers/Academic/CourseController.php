<?php

namespace Nebatech\Controllers\Academic;

use Nebatech\Core\Controller;
use Nebatech\Models\Academic\LessonProgress;
use Nebatech\Models\Academic\Lesson;
use Nebatech\Models\Academic\Course;
use Nebatech\Models\Academic\Module;
use Nebatech\Models\Academic\Assignment;
use Nebatech\Models\Academic\Enrollment;
use Nebatech\Models\Community\User;
use Nebatech\Services\ProgressService;

class CourseController extends Controller
{
    /**
     * Show all courses
     */
    public function index()
    {
        echo $this->view('courses/index');
    }

    /**
     * Show Frontend Development courses
     */
    public function frontend()
    {
        echo $this->view('courses/frontend');
    }

    /**
     * Show Backend Development courses
     */
    public function backend()
    {
        echo $this->view('courses/backend');
    }

    /**
     * Show Full Stack courses
     */
    public function fullstack()
    {
        echo $this->view('courses/fullstack');
    }

    /**
     * Show Mobile Development courses
     */
    public function mobile()
    {
        echo $this->view('courses/mobile');
    }

    /**
     * Show AI courses
     */
    public function ai()
    {
        echo $this->view('courses/ai');
    }

    /**
     * Show Data Science courses
     */
    public function dataScience()
    {
        echo $this->view('courses/data-science');
    }

    /**
     * Show Cybersecurity courses
     */
    public function cybersecurity()
    {
        echo $this->view('courses/cybersecurity');
    }

    /**
     * Show Cloud Computing courses
     */
    public function cloud()
    {
        echo $this->view('courses/cloud');
    }

    /**
     * Show individual course details with lessons
     */
    public function show(string $slug)
    {
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Check if user is authenticated
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
            header('Location: ' . url('/login'));
            exit;
        }

        $user = User::findById($_SESSION['user_id']);
        
        // Get course by slug
        $course = Course::findBySlug($slug);
        
        if (!$course) {
            http_response_code(404);
            echo "Course not found";
            exit;
        }

        // Check if user is enrolled
        $enrollment = Enrollment::findByUserAndCourse($user['id'], $course['id']);
        
        // Handle non-enrolled users
        if (!$enrollment) {
            // Facilitators can preview courses (read-only mode)
            if ($user['role'] === 'facilitator') {
                // Allow preview - enrollment will be null
            } elseif ($user['role'] === 'admin') {
                $_SESSION['info'] = 'You are not enrolled in this course. Manage courses from your admin dashboard.';
                header('Location: ' . url('/admin/dashboard'));
                exit;
            } else {
                // Students must be enrolled
                $_SESSION['error'] = 'You must be enrolled in this course to view it';
                header('Location: ' . url('/courses'));
                exit;
            }
        }

        // Get course modules with lessons
        $modules = Module::getByCourse($course['id']);
        
        // Get lessons for each module and check for assignments and progress
        foreach ($modules as &$module) {
            $lessons = Lesson::getByModule($module['id']);
            
            // Check if each lesson has an assignment and get progress
            foreach ($lessons as &$lesson) {
                $assignment = Assignment::findByLesson($lesson['id']);
                $lesson['has_assignment'] = !empty($assignment);
                
                // Get lesson progress
                $progress = LessonProgress::findByUserAndLesson($user['id'], $lesson['id']);
                $lesson['progress'] = $progress;
                $lesson['is_completed'] = $progress && $progress['status'] === 'completed';
                $lesson['is_in_progress'] = $progress && $progress['status'] === 'in_progress';
            }
            
            $module['lessons'] = $lessons;
        }

        // Get resume lesson (only if enrolled)
        $resumeLesson = null;
        if ($enrollment) {
            $resumeLesson = LessonProgress::getResumeLesson($enrollment['id']);
            if (!$resumeLesson) {
                $resumeLesson = LessonProgress::getNextLesson($enrollment['id']);
            }
        }

        echo $this->view('courses/view', [
            'title' => $course['title'],
            'user' => $user,
            'course' => $course,
            'enrollment' => $enrollment,
            'modules' => $modules,
            'resumeLesson' => $resumeLesson
        ]);
    }

    /**
     * Show individual lesson within a course
     */
    public function showLesson(string $slug, int $lessonId)
    {
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Check if user is authenticated
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
            header('Location: ' . url('/login'));
            exit;
        }

        $user = User::findById($_SESSION['user_id']);
        
        // Get course by slug
        $course = Course::findBySlug($slug);
        
        if (!$course) {
            http_response_code(404);
            echo "Course not found";
            exit;
        }

        // Check if user is enrolled
        $enrollment = Enrollment::findByUserAndCourse($user['id'], $course['id']);
        
        // Handle non-enrolled users
        if (!$enrollment) {
            // Facilitators can preview courses (read-only mode)
            if ($user['role'] === 'facilitator') {
                // Allow preview - enrollment will be null
            } elseif ($user['role'] === 'admin') {
                $_SESSION['info'] = 'You are not enrolled in this course. Manage courses from your admin dashboard.';
                header('Location: ' . url('/admin/dashboard'));
                exit;
            } else {
                // Students must be enrolled
                $_SESSION['error'] = 'You must be enrolled in this course to view it';
                header('Location: ' . url('/courses'));
                exit;
            }
        }

        // Get lesson with enhanced content blocks
        $lesson = Lesson::findByIdWithContent(
            $lessonId, 
            $user['id'], 
            $enrollment ? $enrollment['id'] : null
        );
        
        if (!$lesson) {
            http_response_code(404);
            echo "Lesson not found";
            exit;
        }

        // Mark lesson as started/in progress (only for enrolled users)
        if ($enrollment) {
            LessonProgress::markAsStarted($user['id'], $lessonId, $enrollment['id']);
            
            // TODO: Implement content block progress tracking
            // Mark first content block as started if not already
            // if (!empty($lesson['content_blocks'])) {
            //     $firstBlock = $lesson['content_blocks'][0];
            //     if ($firstBlock['progress_status'] === 'not_started') {
            //         LessonBlockProgress::markAsStarted(
            //             $user['id'], 
            //             $lessonId, 
            //             $firstBlock['id'], 
            //             $enrollment['id']
            //         );
            //     }
            // }
            
            // Update learning streak
            ProgressService::updateLearningStreak($user['id']);
        }

        // Get assignment for this lesson (if exists)
        $assignment = Assignment::findByLesson($lessonId);
        
        // Get lesson progress
        $lessonProgress = LessonProgress::findByUserAndLesson($user['id'], $lessonId);

        // Get course modules with lessons
        $modules = Module::getByCourse($course['id']);
        
        // Get lessons for each module and check for assignments and progress
        foreach ($modules as &$module) {
            $lessons = Lesson::getByModule($module['id']);
            
            // Check if each lesson has an assignment and get progress
            foreach ($lessons as &$lessonItem) {
                $assignmentCheck = Assignment::findByLesson($lessonItem['id']);
                $lessonItem['has_assignment'] = !empty($assignmentCheck);
                
                // Get lesson progress
                $progress = LessonProgress::findByUserAndLesson($user['id'], $lessonItem['id']);
                $lessonItem['progress'] = $progress;
                $lessonItem['is_completed'] = $progress && $progress['status'] === 'completed';
                $lessonItem['is_in_progress'] = $progress && $progress['status'] === 'in_progress';
            }
            
            $module['lessons'] = $lessons;
        }

        // Get next lesson navigation
        $nextLesson = null;
        if ($enrollment) {
            $nextLesson = LessonProgress::getNextLesson($enrollment['id']);
        }

        // Use enhanced course view for better lesson display
        echo $this->view('courses/enhanced-view', [
            'title' => $lesson['title'],
            'user' => $user,
            'course' => $course,
            'enrollment' => $enrollment,
            'currentLesson' => $lesson,
            'currentAssignment' => $assignment,
            'lessonProgress' => $lessonProgress,
            'modules' => $modules,
            'nextLesson' => $nextLesson,
            'contentBlocks' => $lesson['content_blocks'] ?? []
        ]);
    }
}
