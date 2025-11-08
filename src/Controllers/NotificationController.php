<?php

namespace Nebatech\Controllers;

use Nebatech\Core\Controller;
use Nebatech\Core\Database;
use Nebatech\Services\EmailService;

class NotificationController extends Controller
{
    private EmailService $emailService;
    private Database $db;
    
    public function __construct()
    {
        parent::__construct();
        $this->emailService = new EmailService();
        $this->db = Database::getInstance();
    }
    
    /**
     * Show notification preferences page
     */
    public function preferences()
    {
        $this->requireAuth();
        
        $userId = $_SESSION['user']['id'];
        
        // Get current preferences
        $stmt = $this->db->prepare("
            SELECT * FROM notification_preferences 
            WHERE user_id = ?
        ");
        $stmt->execute([$userId]);
        $preferences = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        // Create default preferences if not exist
        if (!$preferences) {
            $this->createDefaultPreferences($userId);
            $stmt->execute([$userId]);
            $preferences = $stmt->fetch(\PDO::FETCH_ASSOC);
        }
        
        $this->render('notifications/preferences', [
            'title' => 'Notification Preferences',
            'preferences' => $preferences
        ]);
    }
    
    /**
     * Update notification preferences
     */
    public function updatePreferences()
    {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/settings/notifications');
            return;
        }
        
        $userId = $_SESSION['user']['id'];
        
        $emailEnabled = isset($_POST['email_enabled']) ? 1 : 0;
        $grades = isset($_POST['grades']) ? 1 : 0;
        $enrollment = isset($_POST['enrollment']) ? 1 : 0;
        $certificates = isset($_POST['certificates']) ? 1 : 0;
        $announcements = isset($_POST['announcements']) ? 1 : 0;
        $reminders = isset($_POST['reminders']) ? 1 : 0;
        $marketing = isset($_POST['marketing']) ? 1 : 0;
        $digestFrequency = $_POST['digest_frequency'] ?? 'immediate';
        
        try {
            $stmt = $this->db->prepare("
                UPDATE notification_preferences 
                SET 
                    email_enabled = ?,
                    grades = ?,
                    enrollment = ?,
                    certificates = ?,
                    announcements = ?,
                    reminders = ?,
                    marketing = ?,
                    digest_frequency = ?
                WHERE user_id = ?
            ");
            
            $stmt->execute([
                $emailEnabled,
                $grades,
                $enrollment,
                $certificates,
                $announcements,
                $reminders,
                $marketing,
                $digestFrequency,
                $userId
            ]);
            
            $_SESSION['flash_message'] = 'Notification preferences updated successfully!';
            $_SESSION['flash_type'] = 'success';
            
        } catch (\Exception $e) {
            error_log("Notification preferences update error: " . $e->getMessage());
            $_SESSION['flash_message'] = 'Failed to update preferences. Please try again.';
            $_SESSION['flash_type'] = 'error';
        }
        
        $this->redirect('/settings/notifications');
    }
    
    /**
     * Test email configuration
     */
    public function testEmail()
    {
        $this->requireAuth(['admin']);
        
        $user = $_SESSION['user'];
        
        try {
            $success = $this->emailService->sendCustomEmail(
                $user['email'],
                $user['first_name'] . ' ' . $user['last_name'],
                'Test Email - Nebatech AI Academy',
                '<h2>Email Configuration Test</h2><p>If you\'re reading this, your email configuration is working correctly!</p>'
            );
            
            if ($success) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Test email sent successfully! Check your inbox.'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Failed to send test email. Check error logs.'
                ]);
            }
            
        } catch (\Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Process email queue (can be called by cron job)
     */
    public function processQueue()
    {
        // This should ideally be protected and called only by cron or admin
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            if (php_sapi_name() !== 'cli') {
                http_response_code(403);
                echo json_encode(['error' => 'Unauthorized']);
                return;
            }
        }
        
        try {
            $processed = $this->emailService->processQueue(10);
            
            echo json_encode([
                'success' => true,
                'processed' => $processed,
                'message' => "Processed $processed emails from queue"
            ]);
            
        } catch (\Exception $e) {
            error_log("Email queue processing error: " . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => 'Error processing queue: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * View email queue status (admin only)
     */
    public function queueStatus()
    {
        $this->requireAuth(['admin']);
        
        try {
            // Get queue statistics
            $stmt = $this->db->query("
                SELECT 
                    status,
                    COUNT(*) as count
                FROM email_queue
                GROUP BY status
            ");
            $stats = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            
            // Get recent emails
            $stmt = $this->db->query("
                SELECT * FROM email_queue
                ORDER BY created_at DESC
                LIMIT 50
            ");
            $recentEmails = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            
            $this->render('admin/email-queue', [
                'title' => 'Email Queue Status',
                'stats' => $stats,
                'recent_emails' => $recentEmails
            ]);
            
        } catch (\Exception $e) {
            error_log("Email queue status error: " . $e->getMessage());
            $_SESSION['flash_message'] = 'Failed to load queue status.';
            $_SESSION['flash_type'] = 'error';
            $this->redirect('/admin/dashboard');
        }
    }
    
    /**
     * Retry failed email
     */
    public function retryEmail()
    {
        $this->requireAuth(['admin']);
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
            return;
        }
        
        $emailId = $_POST['email_id'] ?? null;
        
        if (!$emailId) {
            echo json_encode(['success' => false, 'message' => 'Email ID required']);
            return;
        }
        
        try {
            $stmt = $this->db->prepare("
                UPDATE email_queue 
                SET status = 'pending', attempts = 0, error_message = NULL
                WHERE id = ?
            ");
            $stmt->execute([$emailId]);
            
            echo json_encode([
                'success' => true,
                'message' => 'Email queued for retry'
            ]);
            
        } catch (\Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Create default notification preferences for user
     */
    private function createDefaultPreferences(string $userId): void
    {
        $stmt = $this->db->prepare("
            INSERT INTO notification_preferences 
            (user_id, email_enabled, grades, enrollment, certificates, announcements, reminders, marketing)
            VALUES (?, 1, 1, 1, 1, 1, 1, 0)
        ");
        $stmt->execute([$userId]);
    }
    
    /**
     * Check if user has notification type enabled
     */
    public function isNotificationEnabled(string $userId, string $type): bool
    {
        $stmt = $this->db->prepare("
            SELECT email_enabled, {$type}
            FROM notification_preferences
            WHERE user_id = ?
        ");
        $stmt->execute([$userId]);
        $prefs = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        if (!$prefs) {
            return true; // Default to enabled if no preferences set
        }
        
        return $prefs['email_enabled'] && $prefs[$type];
    }
}
