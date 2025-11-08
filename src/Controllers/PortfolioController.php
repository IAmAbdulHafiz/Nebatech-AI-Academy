<?php

namespace Nebatech\Controllers;

use Nebatech\Core\Controller;
use Nebatech\Models\User;
use Nebatech\Models\Portfolio;
use Nebatech\Models\Badge;
use Nebatech\Models\Certificate;
use Nebatech\Models\Submission;
use Nebatech\Services\CertificateService;
use Nebatech\Services\EmailService;

class PortfolioController extends Controller
{
    private CertificateService $certificateService;
    
    public function __construct()
    {
        parent::__construct();
        $this->certificateService = new CertificateService();
    }
    
    /**
     * Show public portfolio
     */
    public function show(string $username)
    {
        // Find user by email (username)
        $user = User::findByEmail($username);
        
        if (!$user) {
            http_response_code(404);
            $this->render('errors/404', ['title' => 'Portfolio Not Found']);
            return;
        }
        
        // Get portfolio settings
        $settings = Portfolio::getSettings($user['id']);
        
        // Check if portfolio is public
        if (!$settings || !$settings['is_public']) {
            // Allow owner to view their own private portfolio
            if (!isset($_SESSION['user']) || $_SESSION['user']['id'] !== $user['id']) {
                http_response_code(403);
                $this->render('errors/403', ['title' => 'Portfolio Not Public']);
                return;
            }
        }
        
        // Get complete portfolio data
        $portfolio = Portfolio::getCompletePortfolio($user['id']);
        
        $this->render('portfolio/show', [
            'title' => $user['first_name'] . ' ' . $user['last_name'] . ' - Portfolio',
            'portfolio' => $portfolio,
            'is_owner' => isset($_SESSION['user']) && $_SESSION['user']['id'] === $user['id']
        ]);
    }
    
    /**
     * Show portfolio management dashboard
     */
    public function manage()
    {
        $this->requireAuth();
        
        $userId = $_SESSION['user']['id'];
        
        // Get portfolio data
        $settings = Portfolio::getSettings($userId);
        $items = Portfolio::getItems($userId, false); // Include private items
        $certificates = Certificate::getUserCertificates($userId);
        $badges = Badge::getUserBadges($userId);
        $badgeStats = Badge::getUserStats($userId);
        
        // Get graded submissions not in portfolio
        $availableSubmissions = $this->getAvailableSubmissions($userId);
        
        $this->render('portfolio/manage', [
            'title' => 'Manage Portfolio',
            'settings' => $settings,
            'items' => $items,
            'certificates' => $certificates,
            'badges' => $badges,
            'badge_stats' => $badgeStats,
            'available_submissions' => $availableSubmissions
        ]);
    }
    
    /**
     * Update portfolio settings
     */
    public function updateSettings()
    {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/portfolio/manage');
            return;
        }
        
        $userId = $_SESSION['user']['id'];
        
        $data = [
            'bio' => $_POST['bio'] ?? null,
            'tagline' => $_POST['tagline'] ?? null,
            'github_url' => $_POST['github_url'] ?? null,
            'linkedin_url' => $_POST['linkedin_url'] ?? null,
            'twitter_url' => $_POST['twitter_url'] ?? null,
            'website_url' => $_POST['website_url'] ?? null,
            'is_public' => isset($_POST['is_public']) ? 1 : 0,
            'show_badges' => isset($_POST['show_badges']) ? 1 : 0,
            'show_certificates' => isset($_POST['show_certificates']) ? 1 : 0,
            'show_contact' => isset($_POST['show_contact']) ? 1 : 0,
            'theme' => $_POST['theme'] ?? 'default'
        ];
        
        $success = Portfolio::updateSettings($userId, $data);
        
        if ($success) {
            $_SESSION['flash_message'] = 'Portfolio settings updated successfully!';
            $_SESSION['flash_type'] = 'success';
        } else {
            $_SESSION['flash_message'] = 'Failed to update settings.';
            $_SESSION['flash_type'] = 'error';
        }
        
        $this->redirect('/portfolio/manage');
    }
    
    /**
     * Add submission to portfolio
     */
    public function addItem()
    {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'error' => 'Invalid request'], 405);
            return;
        }
        
        $userId = $_SESSION['user']['id'];
        $submissionId = $_POST['submission_id'] ?? null;
        
        if (!$submissionId) {
            $this->jsonResponse(['success' => false, 'error' => 'Submission ID required'], 400);
            return;
        }
        
        // Verify submission belongs to user
        $submission = Submission::findById($submissionId);
        if (!$submission || $submission['user_id'] !== $userId) {
            $this->jsonResponse(['success' => false, 'error' => 'Invalid submission'], 403);
            return;
        }
        
        // Check if already in portfolio
        if (Portfolio::hasSubmission($userId, $submissionId)) {
            $this->jsonResponse(['success' => false, 'error' => 'Already in portfolio'], 400);
            return;
        }
        
        $data = [
            'title' => $_POST['title'] ?? 'Untitled Project',
            'description' => $_POST['description'] ?? null,
            'is_public' => isset($_POST['is_public']) ? 1 : 0,
            'is_featured' => isset($_POST['is_featured']) ? 1 : 0
        ];
        
        $itemId = Portfolio::addItem($userId, $submissionId, $data);
        
        if ($itemId) {
            $this->jsonResponse(['success' => true, 'item_id' => $itemId]);
        } else {
            $this->jsonResponse(['success' => false, 'error' => 'Failed to add item'], 500);
        }
    }
    
    /**
     * Update portfolio item
     */
    public function updateItem()
    {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'error' => 'Invalid request'], 405);
            return;
        }
        
        $userId = $_SESSION['user']['id'];
        $itemId = $_POST['item_id'] ?? null;
        
        if (!$itemId) {
            $this->jsonResponse(['success' => false, 'error' => 'Item ID required'], 400);
            return;
        }
        
        // Verify item belongs to user
        $item = Portfolio::getItemById($itemId);
        if (!$item || $item['user_id'] !== $userId) {
            $this->jsonResponse(['success' => false, 'error' => 'Invalid item'], 403);
            return;
        }
        
        $data = [
            'title' => $_POST['title'] ?? null,
            'description' => $_POST['description'] ?? null,
            'is_public' => isset($_POST['is_public']) ? 1 : 0,
            'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
            'display_order' => $_POST['display_order'] ?? null
        ];
        
        // Remove null values
        $data = array_filter($data, fn($v) => $v !== null);
        
        $success = Portfolio::updateItem($itemId, $data);
        
        if ($success) {
            $this->jsonResponse(['success' => true]);
        } else {
            $this->jsonResponse(['success' => false, 'error' => 'Failed to update item'], 500);
        }
    }
    
    /**
     * Delete portfolio item
     */
    public function deleteItem()
    {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'error' => 'Invalid request'], 405);
            return;
        }
        
        $userId = $_SESSION['user']['id'];
        $itemId = $_POST['item_id'] ?? null;
        
        if (!$itemId) {
            $this->jsonResponse(['success' => false, 'error' => 'Item ID required'], 400);
            return;
        }
        
        // Verify item belongs to user
        $item = Portfolio::getItemById($itemId);
        if (!$item || $item['user_id'] !== $userId) {
            $this->jsonResponse(['success' => false, 'error' => 'Invalid item'], 403);
            return;
        }
        
        $success = Portfolio::deleteItem($itemId);
        
        if ($success) {
            $this->jsonResponse(['success' => true]);
        } else {
            $this->jsonResponse(['success' => false, 'error' => 'Failed to delete item'], 500);
        }
    }
    
    /**
     * View portfolio item details
     */
    public function viewItem(string $itemId)
    {
        $item = Portfolio::getItemById($itemId);
        
        if (!$item) {
            http_response_code(404);
            $this->render('errors/404', ['title' => 'Project Not Found']);
            return;
        }
        
        // Check if public or owner
        $isOwner = isset($_SESSION['user']) && $_SESSION['user']['id'] === $item['user_id'];
        if (!$item['is_public'] && !$isOwner) {
            http_response_code(403);
            $this->render('errors/403', ['title' => 'Project Not Public']);
            return;
        }
        
        // Increment view count (only for non-owners)
        if (!$isOwner) {
            Portfolio::incrementViews($itemId);
        }
        
        $this->render('portfolio/item', [
            'title' => $item['title'],
            'item' => $item,
            'is_owner' => $isOwner
        ]);
    }
    
    /**
     * Generate certificate for completed course
     */
    public function generateCertificate()
    {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'error' => 'Invalid request'], 405);
            return;
        }
        
        $userId = $_SESSION['user']['id'];
        $courseId = $_POST['course_id'] ?? null;
        
        if (!$courseId) {
            $this->jsonResponse(['success' => false, 'error' => 'Course ID required'], 400);
            return;
        }
        
        // Check if user completed the course
        $completed = $this->checkCourseCompletion($userId, $courseId);
        
        if (!$completed) {
            $this->jsonResponse(['success' => false, 'error' => 'Course not completed'], 400);
            return;
        }
        
        // Check if certificate already exists
        if (Certificate::userHasCertificate($userId, $courseId)) {
            $this->jsonResponse(['success' => false, 'error' => 'Certificate already exists'], 400);
            return;
        }
        
        // Create certificate record
        $metadata = [
            'completion_date' => date('Y-m-d'),
            'final_score' => $this->calculateFinalScore($userId, $courseId)
        ];
        
        $certificateId = Certificate::create($userId, $courseId, $metadata);
        
        if (!$certificateId) {
            $this->jsonResponse(['success' => false, 'error' => 'Failed to create certificate'], 500);
            return;
        }
        
        // Generate PDF
        $filename = $this->certificateService->generateCertificate($certificateId);
        
        if (!$filename) {
            $this->jsonResponse(['success' => false, 'error' => 'Failed to generate PDF'], 500);
            return;
        }
        
        // Check and award badges
        $newBadges = Badge::checkAndAwardBadges($userId);
        
        // Send certificate email
        $user = User::findById($userId);
        $course = \Nebatech\Models\Course::findById($courseId);
        
        if ($user && $course) {
            $emailService = new EmailService();
            $pdfPath = $this->certificateService->getCertificatePath($filename);
            $emailService->sendCertificate($user, $course, $pdfPath);
        }
        
        $this->jsonResponse([
            'success' => true,
            'certificate_id' => $certificateId,
            'new_badges' => $newBadges
        ]);
    }
    
    /**
     * Download certificate
     */
    public function downloadCertificate(string $certificateId)
    {
        $certificate = Certificate::findById($certificateId);
        
        if (!$certificate) {
            http_response_code(404);
            echo "Certificate not found";
            return;
        }
        
        // Check if user owns certificate or is admin
        $isOwner = isset($_SESSION['user']) && $_SESSION['user']['id'] === $certificate['user_id'];
        $isAdmin = isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
        
        if (!$isOwner && !$isAdmin) {
            http_response_code(403);
            echo "Access denied";
            return;
        }
        
        if (!$certificate['pdf_path']) {
            // Generate PDF if not exists
            $filename = $this->certificateService->generateCertificate($certificateId);
            if (!$filename) {
                http_response_code(500);
                echo "Failed to generate certificate";
                return;
            }
            $certificate['pdf_path'] = $filename;
        }
        
        $this->certificateService->downloadCertificate($certificate['pdf_path']);
    }
    
    /**
     * Verify certificate
     */
    public function verifyCertificate(string $verificationCode)
    {
        $certificate = Certificate::verify($verificationCode);
        
        $this->render('portfolio/verify-certificate', [
            'title' => 'Verify Certificate',
            'certificate' => $certificate
        ]);
    }
    
    /**
     * Get available submissions for portfolio
     */
    private function getAvailableSubmissions(string $userId): array
    {
        $db = \Nebatech\Core\Database::getInstance();
        
        $stmt = $db->prepare("
            SELECT s.*, a.title as assignment_title, 
                   l.title as lesson_title, c.title as course_title
            FROM submissions s
            JOIN assignments a ON s.assignment_id = a.id
            JOIN lessons l ON a.lesson_id = l.id
            JOIN modules m ON l.module_id = m.id
            JOIN courses c ON m.course_id = c.id
            WHERE s.user_id = ? 
            AND s.status = 'graded'
            AND s.score >= (s.max_score * 0.7)
            AND s.id NOT IN (SELECT submission_id FROM portfolio_items WHERE user_id = ?)
            ORDER BY s.submitted_at DESC
        ");
        
        $stmt->execute([$userId, $userId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Check if user completed course
     */
    private function checkCourseCompletion(string $userId, string $courseId): bool
    {
        $db = \Nebatech\Core\Database::getInstance();
        
        // Count total lessons
        $stmt = $db->prepare("
            SELECT COUNT(*) FROM lessons l
            JOIN modules m ON l.module_id = m.id
            WHERE m.course_id = ?
        ");
        $stmt->execute([$courseId]);
        $totalLessons = $stmt->fetchColumn();
        
        // Count completed lessons
        $stmt = $db->prepare("
            SELECT COUNT(*) FROM lesson_progress lp
            JOIN lessons l ON lp.lesson_id = l.id
            JOIN modules m ON l.module_id = m.id
            WHERE m.course_id = ? AND lp.user_id = ? AND lp.completed = 1
        ");
        $stmt->execute([$courseId, $userId]);
        $completedLessons = $stmt->fetchColumn();
        
        return $totalLessons > 0 && $completedLessons >= $totalLessons;
    }
    
    /**
     * Calculate final score for course
     */
    private function calculateFinalScore(string $userId, string $courseId): int
    {
        $db = \Nebatech\Core\Database::getInstance();
        
        $stmt = $db->prepare("
            SELECT AVG((s.score / s.max_score) * 100) as avg_score
            FROM submissions s
            JOIN assignments a ON s.assignment_id = a.id
            JOIN lessons l ON a.lesson_id = l.id
            JOIN modules m ON l.module_id = m.id
            WHERE m.course_id = ? AND s.user_id = ? AND s.status = 'graded'
        ");
        
        $stmt->execute([$courseId, $userId]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        return $result ? round($result['avg_score']) : 0;
    }
    
    /**
     * JSON response helper
     */
    private function jsonResponse(array $data, int $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
