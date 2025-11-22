<?php

namespace Nebatech\Controllers;

use Nebatech\Core\Controller;
use Nebatech\Core\Database;

class HomeController extends Controller
{
    public function index(): string
    {
        return $this->render('home.index', [
            'title' => 'Welcome to Nebatech AI Academy',
            'tagline' => 'Learn by Doing, Master by Practicing'
        ], 'main');
    }

    public function about(): string
    {
        return $this->render('home.about', [
            'title' => 'About Us'
        ], 'main');
    }

    public function team(): string
    {
        return $this->render('team.index', [
            'title' => 'Our Team'
        ], 'main');
    }

    public function services(): string
    {
        return $this->render('services.index', [
            'title' => 'Our Services'
        ], 'main');
    }

    public function portfolio(): string
    {
        return $this->render('portfolio.index', [
            'title' => 'Portfolio & Case Studies'
        ], 'main');
    }

    public function faqs(): string
    {
        return $this->render('home.faqs', [
            'title' => 'Frequently Asked Questions'
        ], 'main');
    }

    public function community(): string
    {
        // Fetch recent activity (enrollments, completions, certificates)
        $recentActivity = Database::fetchAll("
            SELECT 
                u.first_name,
                u.last_name,
                al.action,
                al.entity_type,
                c.title as course_title,
                al.created_at,
                CASE 
                    WHEN al.action = 'enrolled' THEN 'just enrolled in'
                    WHEN al.action = 'completed' THEN 'completed'
                    WHEN al.action = 'certificate_earned' THEN 'earned certificate in'
                    WHEN al.action = 'module_completed' THEN 'completed module in'
                    WHEN al.action = 'assignment_submitted' THEN 'submitted assignment in'
                    ELSE 'activity in'
                END as action_text,
                CASE 
                    WHEN TIMESTAMPDIFF(MINUTE, al.created_at, NOW()) < 1 THEN 'just now'
                    WHEN TIMESTAMPDIFF(MINUTE, al.created_at, NOW()) < 60 THEN CONCAT(TIMESTAMPDIFF(MINUTE, al.created_at, NOW()), ' mins ago')
                    WHEN TIMESTAMPDIFF(HOUR, al.created_at, NOW()) < 24 THEN CONCAT(TIMESTAMPDIFF(HOUR, al.created_at, NOW()), ' hours ago')
                    ELSE CONCAT(TIMESTAMPDIFF(DAY, al.created_at, NOW()), ' days ago')
                END as time_ago
            FROM activity_logs al
            LEFT JOIN users u ON al.user_id = u.id
            LEFT JOIN courses c ON al.entity_id = c.id AND al.entity_type = 'course'
            WHERE al.action IN ('enrolled', 'completed', 'certificate_earned', 'module_completed', 'assignment_submitted')
            AND al.created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
            ORDER BY al.created_at DESC
            LIMIT 20
        ");
        
        // Get today's enrollment count
        $todayEnrollmentsResult = Database::fetch("
            SELECT COUNT(*) as count
            FROM activity_logs
            WHERE action = 'enrolled'
            AND DATE(created_at) = CURDATE()
        ");
        $todayEnrollments = $todayEnrollmentsResult['count'] ?? 0;
        
        // Get community stats
        $totalStudentsResult = Database::fetch("SELECT COUNT(*) as count FROM users WHERE role = 'student'");
        $totalStudents = $totalStudentsResult['count'] ?? 0;
        
        $totalCoursesResult = Database::fetch("SELECT COUNT(*) as count FROM courses WHERE status = 'published'");
        $totalCourses = $totalCoursesResult['count'] ?? 0;
        
        $totalEnrollmentsResult = Database::fetch("SELECT COUNT(*) as count FROM enrollments");
        $totalEnrollments = $totalEnrollmentsResult['count'] ?? 0;
        
        $certificatesIssuedResult = Database::fetch("SELECT COUNT(*) as count FROM certificates");
        $certificatesIssued = $certificatesIssuedResult['count'] ?? 0;
        
        return $this->render('home.community', [
            'title' => 'Community - Nebatech AI Academy',
            'activities' => $recentActivity,
            'todayEnrollments' => $todayEnrollments,
            'stats' => [
                'totalStudents' => $totalStudents,
                'totalCourses' => $totalCourses,
                'totalEnrollments' => $totalEnrollments,
                'certificatesIssued' => $certificatesIssued
            ]
        ], 'main');
    }

    public function testimonials(): string
    {
        return $this->render('home.testimonials', [
            'title' => 'Success Stories & Testimonials'
        ], 'main');
    }

    public function sitemap(): string
    {
        return $this->render('home.sitemap', [
            'title' => 'Sitemap'
        ], 'main');
    }

    public function corporate(): string
    {
        return $this->render('home.corporate', [
            'title' => 'Corporate Training Solutions'
        ], 'main');
    }

    public function careerServices(): string
    {
        return $this->render('home.career-services', [
            'title' => 'Career Services & Job Placement'
        ], 'main');
    }

    public function support(): string
    {
        return $this->render('home.support', [
            'title' => 'Help Center & Support'
        ], 'main');
    }

    public function liveChat(): string
    {
        return $this->render('home.live-chat', [
            'title' => 'Live Chat Support'
        ], 'main');
    }

    public function accessibility(): string
    {
        return $this->render('home.accessibility', [
            'title' => 'Accessibility Statement'
        ], 'main');
    }

    public function privacy(): string
    {
        return $this->render('home.privacy', [
            'title' => 'Privacy Policy'
        ], 'main');
    }

    public function terms(): string
    {
        return $this->render('home.terms', [
            'title' => 'Terms of Service'
        ], 'main');
    }

    public function cookiePolicy(): string
    {
        return $this->render('home.cookie-policy', [
            'title' => 'Cookie Policy'
        ], 'main');
    }

    public function refundPolicy(): string
    {
        return $this->render('home.refund-policy', [
            'title' => 'Refund Policy'
        ], 'main');
    }

    public function codeOfConduct(): string
    {
        return $this->render('home.code-of-conduct', [
            'title' => 'Code of Conduct'
        ], 'main');
    }
}
