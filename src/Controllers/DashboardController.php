<?php

namespace Nebatech\Controllers;

use Nebatech\Core\Controller;
use Nebatech\Models\User;

class DashboardController extends Controller
{
    public function __construct()
    {
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Require authentication
        $this->requireAuth();
    }

    public function index()
    {
        $user = $this->getCurrentUser();
        
        // Redirect based on role
        if ($user['role'] === 'facilitator') {
            header('Location: ' . url('/facilitator/dashboard'));
            exit;
        } elseif ($user['role'] === 'admin') {
            header('Location: ' . url('/admin/dashboard'));
            exit;
        }

        // Student dashboard with student layout
        echo $this->render('dashboard/index', [
            'title' => 'Dashboard',
            'pageTitle' => 'Dashboard',
            'user' => $user
        ]);
    }

    /**
     * Display student's enrolled courses
     */
    public function myCourses()
    {
        $user = $this->getCurrentUser();
        
        echo $this->render('courses/my-courses', [
            'title' => 'My Courses',
            'pageTitle' => 'My Courses',
            'user' => $user
        ]);
    }

    /**
     * Display student's cohorts
     */
    public function myCohorts()
    {
        $user = $this->getCurrentUser();
        
        echo $this->render('cohorts/my-cohorts', [
            'title' => 'My Cohorts',
            'pageTitle' => 'My Cohorts',
            'user' => $user
        ]);
    }

    /**
     * Display student's progress dashboard
     */
    public function progressDashboard()
    {
        $user = $this->getCurrentUser();
        
        echo $this->render('progress/dashboard', [
            'title' => 'My Progress',
            'pageTitle' => 'My Progress',
            'user' => $user
        ]);
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
     * Get current authenticated user
     */
    protected function getCurrentUser(): ?array
    {
        if (!isset($_SESSION['user_id'])) {
            return null;
        }

        return User::findById($_SESSION['user_id']);
    }
}
