<?php

namespace Nebatech\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailService
{
    private PHPMailer $mailer;
    private array $config;
    
    public function __construct()
    {
        $this->config = require __DIR__ . '/../../config/mail.php';
        $this->mailer = new PHPMailer(true);
        $this->configureSMTP();
    }
    
    /**
     * Configure SMTP settings
     */
    private function configureSMTP(): void
    {
        try {
            // Server settings
            $this->mailer->isSMTP();
            $this->mailer->Host = $this->config['smtp']['host'];
            $this->mailer->SMTPAuth = true;
            $this->mailer->Username = $this->config['smtp']['username'];
            $this->mailer->Password = $this->config['smtp']['password'];
            $this->mailer->SMTPSecure = $this->config['smtp']['encryption'] ?? PHPMailer::ENCRYPTION_STARTTLS;
            $this->mailer->Port = $this->config['smtp']['port'];
            
            // Default sender
            $this->mailer->setFrom(
                $this->config['from']['address'],
                $this->config['from']['name']
            );
            
            // Character encoding
            $this->mailer->CharSet = 'UTF-8';
            $this->mailer->isHTML(true);
            
        } catch (Exception $e) {
            error_log("Email configuration error: " . $e->getMessage());
        }
    }
    
    /**
     * Send welcome email to new users
     */
    public function sendWelcomeEmail(array $user): bool
    {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($user['email'], $user['first_name'] . ' ' . $user['last_name']);
            
            $this->mailer->Subject = 'Welcome to Nebatech AI Academy!';
            
            $template = $this->loadTemplate('welcome', [
                'first_name' => $user['first_name'],
                'email' => $user['email'],
                'dashboard_url' => url('/dashboard'),
                'courses_url' => url('/courses')
            ]);
            
            $this->mailer->Body = $template;
            $this->mailer->AltBody = $this->stripHtml($template);
            
            return $this->mailer->send();
            
        } catch (Exception $e) {
            error_log("Welcome email error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Send grade notification email
     */
    public function sendGradeNotification(array $submission, array $user): bool
    {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($user['email'], $user['first_name'] . ' ' . $user['last_name']);
            
            $this->mailer->Subject = 'Your Assignment Has Been Graded';
            
            $feedback = is_string($submission['ai_feedback']) 
                ? json_decode($submission['ai_feedback'], true) 
                : $submission['ai_feedback'];
            
            $percentage = $submission['score'] && $submission['max_score']
                ? round(($submission['score'] / $submission['max_score']) * 100, 1)
                : 0;
            
            $template = $this->loadTemplate('grade-notification', [
                'first_name' => $user['first_name'],
                'assignment_title' => $submission['assignment_title'],
                'course_title' => $submission['course_title'],
                'score' => $submission['score'],
                'max_score' => $submission['max_score'],
                'percentage' => $percentage,
                'grade_level' => $feedback['grade_level'] ?? 'N/A',
                'feedback_url' => url('/submissions/' . $submission['id'] . '/feedback'),
                'facilitator_comments' => $submission['facilitator_comments'] ?? ''
            ]);
            
            $this->mailer->Body = $template;
            $this->mailer->AltBody = $this->stripHtml($template);
            
            return $this->mailer->send();
            
        } catch (Exception $e) {
            error_log("Grade notification error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Send revision request email
     */
    public function sendRevisionRequest(array $submission, array $user): bool
    {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($user['email'], $user['first_name'] . ' ' . $user['last_name']);
            
            $this->mailer->Subject = 'Assignment Revision Requested';
            
            $template = $this->loadTemplate('revision-request', [
                'first_name' => $user['first_name'],
                'assignment_title' => $submission['assignment_title'],
                'course_title' => $submission['course_title'],
                'facilitator_comments' => $submission['facilitator_comments'] ?? 'Please review the feedback and resubmit.',
                'assignment_url' => url('/assignments/' . $submission['assignment_id'] . '/code-editor'),
                'feedback_url' => url('/submissions/' . $submission['id'] . '/feedback')
            ]);
            
            $this->mailer->Body = $template;
            $this->mailer->AltBody = $this->stripHtml($template);
            
            return $this->mailer->send();
            
        } catch (Exception $e) {
            error_log("Revision request error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Send course enrollment confirmation
     */
    public function sendEnrollmentConfirmation(array $enrollment, array $user, array $course): bool
    {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($user['email'], $user['first_name'] . ' ' . $user['last_name']);
            
            $this->mailer->Subject = 'Course Enrollment Confirmed - ' . $course['title'];
            
            $template = $this->loadTemplate('enrollment-confirmation', [
                'first_name' => $user['first_name'],
                'course_title' => $course['title'],
                'course_description' => $course['description'],
                'course_url' => url('/courses/' . $course['slug']),
                'dashboard_url' => url('/dashboard')
            ]);
            
            $this->mailer->Body = $template;
            $this->mailer->AltBody = $this->stripHtml($template);
            
            return $this->mailer->send();
            
        } catch (Exception $e) {
            error_log("Enrollment confirmation error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Send application status email
     */
    public function sendApplicationStatus(array $application, array $user, string $status): bool
    {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($user['email'], $user['first_name'] . ' ' . $user['last_name']);
            
            $statusTitle = $status === 'approved' ? 'Approved' : 'Update on Your Application';
            $this->mailer->Subject = 'Application ' . $statusTitle . ' - Nebatech AI Academy';
            
            $templateName = $status === 'approved' ? 'application-approved' : 'application-rejected';
            
            $template = $this->loadTemplate($templateName, [
                'first_name' => $user['first_name'],
                'program' => $application['program'] ?? 'AI Academy Program',
                'dashboard_url' => url('/dashboard'),
                'courses_url' => url('/courses'),
                'rejection_reason' => $application['rejection_reason'] ?? ''
            ]);
            
            $this->mailer->Body = $template;
            $this->mailer->AltBody = $this->stripHtml($template);
            
            return $this->mailer->send();
            
        } catch (Exception $e) {
            error_log("Application status error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Send certificate delivery email
     */
    public function sendCertificate(array $user, array $course, string $certificatePath): bool
    {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($user['email'], $user['first_name'] . ' ' . $user['last_name']);
            
            $this->mailer->Subject = 'Your Certificate of Completion - ' . $course['title'];
            
            $template = $this->loadTemplate('certificate-delivery', [
                'first_name' => $user['first_name'],
                'course_title' => $course['title'],
                'portfolio_url' => url('/portfolio/' . $user['email']),
                'dashboard_url' => url('/dashboard')
            ]);
            
            $this->mailer->Body = $template;
            $this->mailer->AltBody = $this->stripHtml($template);
            
            // Attach certificate PDF
            if (file_exists($certificatePath)) {
                $this->mailer->addAttachment($certificatePath, 'Certificate.pdf');
            }
            
            return $this->mailer->send();
            
        } catch (Exception $e) {
            error_log("Certificate delivery error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Send password reset email
     */
    public function sendPasswordReset(array $user, string $resetToken): bool
    {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($user['email'], $user['first_name'] . ' ' . $user['last_name']);
            
            $this->mailer->Subject = 'Password Reset Request - Nebatech AI Academy';
            
            $resetUrl = url('/reset-password?token=' . $resetToken);
            
            $template = $this->loadTemplate('password-reset', [
                'first_name' => $user['first_name'],
                'reset_url' => $resetUrl,
                'expires_in' => '1 hour'
            ]);
            
            $this->mailer->Body = $template;
            $this->mailer->AltBody = $this->stripHtml($template);
            
            return $this->mailer->send();
            
        } catch (Exception $e) {
            error_log("Password reset error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Send custom email
     */
    public function sendCustomEmail(
        string $toEmail,
        string $toName,
        string $subject,
        string $body,
        ?string $altBody = null
    ): bool {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($toEmail, $toName);
            
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $body;
            $this->mailer->AltBody = $altBody ?? $this->stripHtml($body);
            
            return $this->mailer->send();
            
        } catch (Exception $e) {
            error_log("Custom email error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Queue email for later delivery
     */
    public function queueEmail(
        string $type,
        array $recipient,
        array $data = []
    ): bool {
        try {
            $db = \Nebatech\Core\Database::getInstance();
            
            $stmt = $db->prepare("
                INSERT INTO email_queue (type, recipient_email, recipient_name, data, status, created_at)
                VALUES (?, ?, ?, ?, 'pending', NOW())
            ");
            
            return $stmt->execute([
                $type,
                $recipient['email'],
                $recipient['first_name'] . ' ' . $recipient['last_name'],
                json_encode($data)
            ]);
            
        } catch (\Exception $e) {
            error_log("Email queue error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Process queued emails
     */
    public function processQueue(int $limit = 10): int
    {
        try {
            $db = \Nebatech\Core\Database::getInstance();
            
            $stmt = $db->prepare("
                SELECT * FROM email_queue 
                WHERE status = 'pending' 
                ORDER BY created_at ASC 
                LIMIT ?
            ");
            $stmt->execute([$limit]);
            $emails = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            
            $processed = 0;
            
            foreach ($emails as $email) {
                $data = json_decode($email['data'], true);
                $sent = false;
                
                // Route to appropriate send method
                switch ($email['type']) {
                    case 'welcome':
                        $sent = $this->sendWelcomeEmail($data['user']);
                        break;
                    case 'grade_notification':
                        $sent = $this->sendGradeNotification($data['submission'], $data['user']);
                        break;
                    case 'revision_request':
                        $sent = $this->sendRevisionRequest($data['submission'], $data['user']);
                        break;
                    // Add more types as needed
                }
                
                // Update queue status
                $status = $sent ? 'sent' : 'failed';
                $updateStmt = $db->prepare("
                    UPDATE email_queue 
                    SET status = ?, sent_at = NOW(), attempts = attempts + 1 
                    WHERE id = ?
                ");
                $updateStmt->execute([$status, $email['id']]);
                
                if ($sent) {
                    $processed++;
                }
            }
            
            return $processed;
            
        } catch (\Exception $e) {
            error_log("Queue processing error: " . $e->getMessage());
            return 0;
        }
    }
    
    /**
     * Load email template
     */
    private function loadTemplate(string $templateName, array $data = []): string
    {
        $templatePath = __DIR__ . '/../../src/Views/emails/' . $templateName . '.php';
        
        if (!file_exists($templatePath)) {
            throw new \Exception("Email template not found: $templateName");
        }
        
        // Extract data to variables
        extract($data);
        
        // Start output buffering
        ob_start();
        include $templatePath;
        $content = ob_get_clean();
        
        return $content;
    }
    
    /**
     * Strip HTML for plain text version
     */
    private function stripHtml(string $html): string
    {
        $text = strip_tags($html);
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = preg_replace('/\s+/', ' ', $text);
        return trim($text);
    }
    
    /**
     * Test email configuration
     */
    public function testConnection(): bool
    {
        try {
            return $this->mailer->smtpConnect();
        } catch (Exception $e) {
            error_log("SMTP connection test failed: " . $e->getMessage());
            return false;
        }
    }
}
