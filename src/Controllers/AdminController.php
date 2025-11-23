<?php

namespace Nebatech\Controllers;

use Nebatech\Core\Controller;
use Nebatech\Core\Database;
use PDO;

class AdminController extends Controller
{
    public function dashboard(): void
    {
        $this->requireAuth();
        $this->requireRole('admin');
        
        $db = Database::connect();
        
        // Get statistics
        $totalUsers = $db->query("SELECT COUNT(*) as count FROM users")->fetch(PDO::FETCH_ASSOC)['count'] ?? 0;
        $totalCourses = $db->query("SELECT COUNT(*) as count FROM courses")->fetch(PDO::FETCH_ASSOC)['count'] ?? 0;
        $totalEnrollments = $db->query("SELECT COUNT(*) as count FROM enrollments")->fetch(PDO::FETCH_ASSOC)['count'] ?? 0;
        $pendingApplications = $db->query("SELECT COUNT(*) as count FROM applications WHERE status = 'pending'")->fetch(PDO::FETCH_ASSOC)['count'] ?? 0;
        
        $stats = [
            'total_users' => $totalUsers,
            'total_courses' => $totalCourses,
            'total_enrollments' => $totalEnrollments,
            'pending_applications' => $pendingApplications
        ];
        
        echo $this->view('admin/dashboard', ['stats' => $stats]);
    }
    
    public function users(): void
    {
        $this->requireAuth();
        $this->requireRole('admin');
        
        $db = Database::connect();
        $stmt = $db->query("SELECT * FROM users ORDER BY created_at DESC LIMIT 50");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo $this->view('admin/users', ['users' => $users]);
    }
    
    public function courses(): void
    {
        $this->requireAuth();
        $this->requireRole('admin');
        
        $db = Database::connect();
        $stmt = $db->query("SELECT * FROM courses ORDER BY created_at DESC");
        $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo $this->view('admin/courses', ['courses' => $courses]);
    }
    
    public function enrollments(): void
    {
        $this->requireAuth();
        $this->requireRole('admin');
        
        $db = Database::connect();
        $stmt = $db->query("
            SELECT e.*, u.first_name, u.last_name, c.title as course_title 
            FROM enrollments e 
            JOIN users u ON e.user_id = u.id 
            JOIN courses c ON e.course_id = c.id 
            ORDER BY e.created_at DESC 
            LIMIT 50
        ");
        $enrollments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo $this->view('admin/enrollments', ['enrollments' => $enrollments]);
    }
    
    public function certificates(): void
    {
        $this->requireAuth();
        $this->requireRole('admin');
        
        $db = Database::connect();
        $stmt = $db->query("
            SELECT cert.*, u.first_name, u.last_name, c.title as course_title 
            FROM certificates cert 
            JOIN users u ON cert.user_id = u.id 
            JOIN courses c ON cert.course_id = c.id 
            ORDER BY cert.issued_at DESC 
            LIMIT 50
        ");
        $certificates = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo $this->view('admin/certificates', ['certificates' => $certificates]);
    }
    
    public function issueCertificate(): void
    {
        $this->requireAuth();
        $this->requireRole('admin');
        
        $db = Database::connect();
        
        $stmt = $db->query("
            SELECT id, first_name, last_name, email 
            FROM users 
            WHERE role = 'student' 
            ORDER BY first_name, last_name
        ");
        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $stmt = $db->query("
            SELECT id, title 
            FROM courses 
            WHERE status = 'published' 
            ORDER BY title
        ");
        $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo $this->view('admin/issue-certificate', [
            'students' => $students, 
            'courses' => $courses
        ]);
    }

    public function approvals(): void
    {
        $this->requireAuth();
        $this->requireRole('admin');
        
        $db = Database::connect();
        
        // Get pending cohorts - simplified query to avoid column errors
        try {
            $stmt = $db->query("
                SELECT * FROM cohorts 
                WHERE status = 'pending'
                ORDER BY created_at DESC
            ");
            $pendingCohorts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            // If cohorts table doesn't exist or has issues, use empty array
            $pendingCohorts = [];
        }
        
        // Get pending courses
        try {
            $stmt = $db->query("
                SELECT c.*,
                       u.first_name as creator_first_name,
                       u.last_name as creator_last_name
                FROM courses c
                LEFT JOIN users u ON c.created_by = u.id
                WHERE c.status = 'pending'
                ORDER BY c.created_at DESC
            ");
            $pendingCourses = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            $pendingCourses = [];
        }
        
        echo $this->view('admin/approvals-dashboard', [
            'pendingCohorts' => $pendingCohorts,
            'pendingCourses' => $pendingCourses
        ]);
    }
}

