<?php

namespace Nebatech\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailService
{
    private PHPMailer $mailer;
    private string $fromEmail;
    private string $fromName;
    private bool $isEnabled;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);
        $this->fromEmail = $_ENV['MAIL_FROM_ADDRESS'] ?? 'noreply@nebatech.com';
        $this->fromName = $_ENV['MAIL_FROM_NAME'] ?? 'Nebatech AI Academy';
        $this->isEnabled = ($_ENV['MAIL_ENABLED'] ?? 'true') === 'true';

        $this->configureSMTP();
    }

    /**
     * Configure SMTP settings
     */
    private function configureSMTP(): void
    {
        try {
            $this->mailer->isSMTP();
            $this->mailer->Host = $_ENV['MAIL_HOST'] ?? 'smtp.gmail.com';
            $this->mailer->SMTPAuth = true;
            $this->mailer->Username = $_ENV['MAIL_USERNAME'] ?? '';
            $this->mailer->Password = $_ENV['MAIL_PASSWORD'] ?? '';
            $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mailer->Port = (int)($_ENV['MAIL_PORT'] ?? 587);
            $this->mailer->setFrom($this->fromEmail, $this->fromName);
            $this->mailer->isHTML(true);
        } catch (Exception $e) {
            error_log("SMTP Configuration Error: " . $e->getMessage());
        }
    }

    /**
     * Send application received notification
     */
    public function sendApplicationReceived(array $application): bool
    {
        if (!$this->isEnabled) {
            return $this->logEmail('application_received', $application['email']);
        }

        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($application['email'], $application['first_name'] . ' ' . $application['last_name']);
            
            $this->mailer->Subject = 'Application Received - Nebatech AI Academy';
            $this->mailer->Body = $this->renderTemplate('application-received', [
                'name' => $application['first_name'],
                'program' => ucwords(str_replace('-', ' ', $application['program'])),
                'application_id' => $application['uuid']
            ]);

            $this->mailer->send();
            $this->logEmail('application_received', $application['email'], true);
            return true;
        } catch (Exception $e) {
            error_log("Email Error (Application Received): " . $e->getMessage());
            $this->logEmail('application_received', $application['email'], false, $e->getMessage());
            return false;
        }
    }

    /**
     * Send application approved notification with login credentials
     */
    public function sendApplicationApproved(array $application, array $user, ?string $temporaryPassword = null, ?array $cohort = null): bool
    {
        if (!$this->isEnabled) {
            return $this->logEmail('application_approved', $application['email']);
        }

        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($application['email'], $application['first_name'] . ' ' . $application['last_name']);
            
            $this->mailer->Subject = '🎉 Congratulations! Your Application Has Been Approved';
            $this->mailer->Body = $this->renderTemplate('application-approved', [
                'name' => $application['first_name'],
                'program' => ucwords(str_replace('-', ' ', $application['program'])),
                'email' => $user['email'],
                'temporary_password' => $temporaryPassword,
                'login_url' => url('/login'),
                'dashboard_url' => url('/dashboard'),
                'cohort' => $cohort
            ]);

            $this->mailer->send();
            $this->logEmail('application_approved', $application['email'], true);
            return true;
        } catch (Exception $e) {
            error_log("Email Error (Application Approved): " . $e->getMessage());
            $this->logEmail('application_approved', $application['email'], false, $e->getMessage());
            return false;
        }
    }

    /**
     * Send application rejected notification
     */
    public function sendApplicationRejected(array $application, string $reason = ''): bool
    {
        if (!$this->isEnabled) {
            return $this->logEmail('application_rejected', $application['email']);
        }

        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($application['email'], $application['first_name'] . ' ' . $application['last_name']);
            
            $this->mailer->Subject = 'Application Status Update - Nebatech AI Academy';
            $this->mailer->Body = $this->renderTemplate('application-rejected', [
                'name' => $application['first_name'],
                'program' => ucwords(str_replace('-', ' ', $application['program'])),
                'reason' => $reason,
                'apply_url' => url('/apply')
            ]);

            $this->mailer->send();
            $this->logEmail('application_rejected', $application['email'], true);
            return true;
        } catch (Exception $e) {
            error_log("Email Error (Application Rejected): " . $e->getMessage());
            $this->logEmail('application_rejected', $application['email'], false, $e->getMessage());
            return false;
        }
    }

    /**
     * Send information request notification
     */
    public function sendInfoRequested(array $application, string $requestedInfo): bool
    {
        if (!$this->isEnabled) {
            return $this->logEmail('info_requested', $application['email']);
        }

        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($application['email'], $application['first_name'] . ' ' . $application['last_name']);
            
            $this->mailer->Subject = 'Additional Information Required - Nebatech AI Academy';
            $this->mailer->Body = $this->renderTemplate('info-requested', [
                'name' => $application['first_name'],
                'program' => ucwords(str_replace('-', ' ', $application['program'])),
                'requested_info' => $requestedInfo,
                'application_url' => url('/application/' . $application['uuid'])
            ]);

            $this->mailer->send();
            $this->logEmail('info_requested', $application['email'], true);
            return true;
        } catch (Exception $e) {
            error_log("Email Error (Info Requested): " . $e->getMessage());
            $this->logEmail('info_requested', $application['email'], false, $e->getMessage());
            return false;
        }
    }

    /**
     * Send welcome email with course access
     */
    public function sendWelcomeEmail(array $user, array $course, ?array $cohort = null): bool
    {
        if (!$this->isEnabled) {
            return $this->logEmail('welcome', $user['email']);
        }

        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($user['email'], $user['first_name'] . ' ' . $user['last_name']);
            
            $this->mailer->Subject = 'Welcome to Nebatech AI Academy! 🚀';
            $this->mailer->Body = $this->renderTemplate('welcome', [
                'name' => $user['first_name'],
                'course_name' => $course['title'],
                'course_url' => url('/courses/' . $course['slug']),
                'dashboard_url' => url('/dashboard'),
                'cohort' => $cohort,
                'support_email' => 'support@nebatech.com'
            ]);

            $this->mailer->send();
            $this->logEmail('welcome', $user['email'], true);
            return true;
        } catch (Exception $e) {
            error_log("Email Error (Welcome): " . $e->getMessage());
            $this->logEmail('welcome', $user['email'], false, $e->getMessage());
            return false;
        }
    }

    /**
     * Send cohort assignment notification
     */
    public function sendCohortAssignment(array $user, array $cohort, array $facilitator): bool
    {
        if (!$this->isEnabled) {
            return $this->logEmail('cohort_assignment', $user['email']);
        }

        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($user['email'], $user['first_name'] . ' ' . $user['last_name']);
            
            $this->mailer->Subject = 'You\'ve Been Assigned to a Cohort!';
            $this->mailer->Body = $this->renderTemplate('cohort-assignment', [
                'name' => $user['first_name'],
                'cohort_name' => $cohort['name'],
                'program' => ucwords(str_replace('-', ' ', $cohort['program'])),
                'start_date' => date('F d, Y', strtotime($cohort['start_date'])),
                'facilitator_name' => $facilitator['first_name'] . ' ' . $facilitator['last_name'],
                'dashboard_url' => url('/dashboard')
            ]);

            $this->mailer->send();
            $this->logEmail('cohort_assignment', $user['email'], true);
            return true;
        } catch (Exception $e) {
            error_log("Email Error (Cohort Assignment): " . $e->getMessage());
            $this->logEmail('cohort_assignment', $user['email'], false, $e->getMessage());
            return false;
        }
    }

    /**
     * Send welcome email to new registered user
     */
    public function sendWelcomeEmailNewUser(array $user): bool
    {
        if (!$this->isEnabled) {
            return $this->logEmail('welcome_new_user', $user['email']);
        }

        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($user['email'], $user['first_name'] . ' ' . $user['last_name']);
            
            $this->mailer->Subject = 'Welcome to Nebatech AI Academy! 🚀';
            $this->mailer->Body = $this->renderTemplate('welcome-new-user', [
                'name' => $user['first_name'],
                'email' => $user['email'],
                'dashboard_url' => url('/dashboard'),
                'courses_url' => url('/courses'),
                'support_email' => 'support@nebatech.com'
            ]);

            $this->mailer->send();
            $this->logEmail('welcome_new_user', $user['email'], true);
            return true;
        } catch (Exception $e) {
            error_log("Email Error (Welcome New User): " . $e->getMessage());
            $this->logEmail('welcome_new_user', $user['email'], false, $e->getMessage());
            return false;
        }
    }

    /**
     * Send email verification
     */
    public function sendEmailVerification(array $user): bool
    {
        if (!$this->isEnabled) {
            return $this->logEmail('email_verification', $user['email']);
        }

        try {
            // Generate verification token
            $token = bin2hex(random_bytes(32));
            $expiresAt = date('Y-m-d H:i:s', time() + (86400 * 1)); // 24 hours
            
            // Store verification token in database
            \Nebatech\Core\Database::insert('email_verifications', [
                'user_id' => $user['id'],
                'token' => $token,
                'expires_at' => $expiresAt
            ]);

            $this->mailer->clearAddresses();
            $this->mailer->addAddress($user['email'], $user['first_name'] . ' ' . $user['last_name']);
            
            $this->mailer->Subject = 'Verify Your Email Address';
            $this->mailer->Body = $this->renderTemplate('email-verification', [
                'name' => $user['first_name'],
                'verification_url' => url('/verify-email?token=' . $token),
                'support_email' => 'support@nebatech.com'
            ]);

            $this->mailer->send();
            $this->logEmail('email_verification', $user['email'], true);
            return true;
        } catch (Exception $e) {
            error_log("Email Error (Email Verification): " . $e->getMessage());
            $this->logEmail('email_verification', $user['email'], false, $e->getMessage());
            return false;
        }
    }

    /**
     * Send contact form notification to admin
     */
    public function sendContactNotification(array $contact): bool
    {
        if (!$this->isEnabled) {
            return $this->logEmail('contact_notification', $_ENV['ADMIN_EMAIL'] ?? 'muhammadkamaldeen92@gmail.com');
        }

        try {
            $this->mailer->clearAddresses();
            $adminEmail = $_ENV['ADMIN_EMAIL'] ?? 'muhammadkamaldeen92@gmail.com';
            $this->mailer->addAddress($adminEmail, 'Admin');
            
            $this->mailer->Subject = 'New Contact Form Submission - ' . ($contact['subject'] ?? 'No Subject');
            $this->mailer->Body = $this->renderTemplate('contact-notification', [
                'name' => $contact['name'],
                'email' => $contact['email'],
                'subject' => $contact['subject'] ?? 'No Subject',
                'message' => $contact['message'],
                'phone' => $contact['phone'] ?? 'Not provided',
                'contact_id' => $contact['id']
            ]);

            $this->mailer->send();
            $this->logEmail('contact_notification', $adminEmail, true);
            return true;
        } catch (Exception $e) {
            error_log("Email Error (Contact Notification): " . $e->getMessage());
            $this->logEmail('contact_notification', $adminEmail ?? 'muhammadkamaldeen92@gmail.com', false, $e->getMessage());
            return false;
        }
    }

    /**
     * Send certificate issued notification
     */
    public function sendCertificateIssued(array $user, array $certificate, array $course): bool
    {
        if (!$this->isEnabled) {
            return $this->logEmail('certificate_issued', $user['email']);
        }

        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($user['email'], $user['first_name'] . ' ' . $user['last_name']);
            
            $this->mailer->Subject = '🎓 Congratulations! Your Certificate is Ready';
            $this->mailer->Body = $this->renderTemplate('certificate-issued', [
                'name' => $user['first_name'],
                'course_name' => $course['title'],
                'certificate_number' => $certificate['certificate_number'],
                'certificate_url' => url('/certificate/' . $certificate['uuid']),
                'download_url' => url('/certificate/' . $certificate['uuid'] . '/download'),
                'verify_url' => url('/verify-certificate?id=' . $certificate['certificate_number'])
            ]);

            $this->mailer->send();
            $this->logEmail('certificate_issued', $user['email'], true);
            return true;
        } catch (Exception $e) {
            error_log("Email Error (Certificate Issued): " . $e->getMessage());
            $this->logEmail('certificate_issued', $user['email'], false, $e->getMessage());
            return false;
        }
    }

    /**
     * Render email template
     */
    private function renderTemplate(string $template, array $data): string
    {
        $templatePath = __DIR__ . '/../Views/emails/' . $template . '.php';
        
        if (!file_exists($templatePath)) {
            error_log("Email template not found: " . $templatePath);
            return $this->getDefaultTemplate($template, $data);
        }

        ob_start();
        extract($data);
        include $templatePath;
        return ob_get_clean();
    }

    /**
     * Get default email template (fallback)
     */
    private function getDefaultTemplate(string $type, array $data): string
    {
        $brandColor = '#002060';
        $accentColor = '#FFA500';
        
        $templates = [
            'application-received' => "
                <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
                    <div style='background: {$brandColor}; color: white; padding: 20px; text-align: center;'>
                        <h1 style='margin: 0;'>Nebatech AI Academy</h1>
                    </div>
                    <div style='padding: 30px; background: #f9fafb;'>
                        <h2 style='color: {$brandColor};'>Application Received!</h2>
                        <p>Dear " . ($data['name'] ?? 'Applicant') . ",</p>
                        <p>Thank you for applying to our <strong>" . ($data['program'] ?? 'our program') . "</strong> program.</p>
                        <p>Your application has been received and is currently under review. We will notify you of our decision within 3-5 business days.</p>
                        <p>Application ID: <strong>" . ($data['application_id'] ?? 'N/A') . "</strong></p>
                        <p>Best regards,<br>Nebatech AI Academy Team</p>
                    </div>
                </div>
            ",
            'application-approved' => "
                <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
                    <div style='background: {$brandColor}; color: white; padding: 20px; text-align: center;'>
                        <h1 style='margin: 0;'>🎉 Congratulations!</h1>
                    </div>
                    <div style='padding: 30px; background: #f9fafb;'>
                        <h2 style='color: {$brandColor};'>You've Been Accepted!</h2>
                        <p>Dear " . ($data['name'] ?? 'Applicant') . ",</p>
                        <p>We're thrilled to inform you that your application for <strong>" . ($data['program'] ?? 'our program') . "</strong> has been approved!</p>
                        <div style='background: white; padding: 20px; border-radius: 8px; margin: 20px 0;'>
                            <h3 style='color: {$brandColor}; margin-top: 0;'>Your Login Credentials</h3>
                            <p><strong>Email:</strong> " . ($data['email'] ?? 'N/A') . "</p>
                            " . (isset($data['temporary_password']) ? "<p><strong>Temporary Password:</strong> {$data['temporary_password']}</p>" : "") . "
                            <p style='margin-top: 20px;'>
                                <a href='" . ($data['login_url'] ?? '#') . "' style='background: {$accentColor}; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; display: inline-block;'>Login Now</a>
                            </p>
                        </div>
                        <p>Welcome to Nebatech AI Academy! We're excited to have you on this learning journey.</p>
                        <p>Best regards,<br>Nebatech AI Academy Team</p>
                    </div>
                </div>
            ",
            'contact-notification' => "
                <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
                    <div style='background: {$brandColor}; color: white; padding: 20px; text-align: center;'>
                        <h1 style='margin: 0;'>New Contact Form Submission</h1>
                    </div>
                    <div style='padding: 30px; background: #f9fafb;'>
                        <h2 style='color: {$brandColor};'>Contact Details</h2>
                        <div style='background: white; padding: 20px; border-radius: 8px; margin: 20px 0;'>
                            <p><strong>Name:</strong> " . ($data['name'] ?? 'N/A') . "</p>
                            <p><strong>Email:</strong> " . ($data['email'] ?? 'N/A') . "</p>
                            <p><strong>Phone:</strong> " . ($data['phone'] ?? 'Not provided') . "</p>
                            <p><strong>Subject:</strong> " . ($data['subject'] ?? 'No Subject') . "</p>
                            <p><strong>Message:</strong></p>
                            <p style='background: #f9fafb; padding: 15px; border-left: 3px solid {$accentColor};'>" . ($data['message'] ?? 'No message') . "</p>
                        </div>
                        <p>Contact ID: <strong>" . ($data['contact_id'] ?? 'N/A') . "</strong></p>
                    </div>
                </div>
            ",
            'certificate-issued' => "
                <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
                    <div style='background: {$brandColor}; color: white; padding: 20px; text-align: center;'>
                        <h1 style='margin: 0;'>🎓 Certificate Issued!</h1>
                    </div>
                    <div style='padding: 30px; background: #f9fafb;'>
                        <h2 style='color: {$brandColor};'>Congratulations, " . ($data['name'] ?? 'Student') . "!</h2>
                        <p>We're thrilled to inform you that your certificate for <strong>" . ($data['course_name'] ?? 'the course') . "</strong> has been issued!</p>
                        <div style='background: white; padding: 20px; border-radius: 8px; margin: 20px 0; text-align: center;'>
                            <h3 style='color: {$brandColor}; margin-top: 0;'>Certificate Details</h3>
                            <p><strong>Certificate Number:</strong> " . ($data['certificate_number'] ?? 'N/A') . "</p>
                            <p style='margin-top: 20px;'>
                                <a href='" . ($data['certificate_url'] ?? '#') . "' style='background: {$accentColor}; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; display: inline-block; margin: 5px;'>View Certificate</a>
                                <a href='" . ($data['download_url'] ?? '#') . "' style='background: {$brandColor}; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; display: inline-block; margin: 5px;'>Download PDF</a>
                            </p>
                        </div>
                        <p>You can verify your certificate at any time using this link:</p>
                        <p><a href='" . ($data['verify_url'] ?? '#') . "'>" . ($data['verify_url'] ?? 'Verification link') . "</a></p>
                        <p>Congratulations on your achievement!</p>
                        <p>Best regards,<br>Nebatech AI Academy Team</p>
                    </div>
                </div>
            ",
            'welcome-new-user' => "
                <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
                    <div style='background: {$brandColor}; color: white; padding: 20px; text-align: center;'>
                        <h1 style='margin: 0;'>Welcome to Nebatech AI Academy! 🚀</h1>
                    </div>
                    <div style='padding: 30px; background: #f9fafb;'>
                        <h2 style='color: {$brandColor};'>Hello, " . ($data['name'] ?? 'User') . "!</h2>
                        <p>Thank you for joining Nebatech AI Academy. We're excited to have you on this learning journey!</p>
                        <div style='background: white; padding: 20px; border-radius: 8px; margin: 20px 0;'>
                            <h3 style='color: {$brandColor}; margin-top: 0;'>Getting Started</h3>
                            <p>Here's what you can do next:</p>
                            <ul style='text-align: left;'>
                                <li>Explore our <a href='" . ($data['courses_url'] ?? url('/courses')) . "'>available courses</a></li>
                                <li>Complete your profile in your <a href='" . ($data['dashboard_url'] ?? url('/dashboard')) . "'>dashboard</a></li>
                                <li>Apply for a program that interests you</li>
                            </ul>
                            <p style='margin-top: 20px;'>
                                <a href='" . ($data['dashboard_url'] ?? url('/dashboard')) . "' style='background: {$accentColor}; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; display: inline-block;'>Go to Dashboard</a>
                            </p>
                        </div>
                        <p><strong>Tagline:</strong> Learn by Doing, Master by Practicing</p>
                        <p>If you have any questions, feel free to contact us at <a href='mailto:" . ($data['support_email'] ?? 'support@nebatech.com') . "'>" . ($data['support_email'] ?? 'support@nebatech.com') . "</a></p>
                        <p>Best regards,<br>Nebatech AI Academy Team</p>
                    </div>
                </div>
            ",
            'email-verification' => "
                <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
                    <div style='background: {$brandColor}; color: white; padding: 20px; text-align: center;'>
                        <h1 style='margin: 0;'>Verify Your Email Address</h1>
                    </div>
                    <div style='padding: 30px; background: #f9fafb;'>
                        <h2 style='color: {$brandColor};'>Hello, " . ($data['name'] ?? 'User') . "!</h2>
                        <p>Thank you for registering with Nebatech AI Academy. Please verify your email address to complete your registration.</p>
                        <div style='background: white; padding: 20px; border-radius: 8px; margin: 20px 0; text-align: center;'>
                            <p style='margin-top: 20px;'>
                                <a href='" . ($data['verification_url'] ?? '#') . "' style='background: {$accentColor}; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; display: inline-block;'>Verify Email Address</a>
                            </p>
                        </div>
                        <p>If you didn't create an account with Nebatech AI Academy, you can safely ignore this email.</p>
                        <p>This verification link will expire in 24 hours.</p>
                        <p>If you have any questions, contact us at <a href='mailto:" . ($data['support_email'] ?? 'support@nebatech.com') . "'>" . ($data['support_email'] ?? 'support@nebatech.com') . "</a></p>
                        <p>Best regards,<br>Nebatech AI Academy Team</p>
                    </div>
                </div>
            "
        ];

        return $templates[$type] ?? "<p>Email notification</p>";
    }

    /**
     * Log email activity
     */
    private function logEmail(string $type, string $recipient, bool $success = true, ?string $error = null): bool
    {
        try {
            // Only log if email_logs table exists
            \Nebatech\Core\Database::insert('email_logs', [
                'type' => $type,
                'recipient' => $recipient,
                'status' => $success ? 'sent' : 'failed',
                'error_message' => $error,
                'sent_at' => date('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
            // Silently fail if table doesn't exist - email logging is optional
            error_log("Failed to log email: " . $e->getMessage());
        }
        
        return true;
    }
}
