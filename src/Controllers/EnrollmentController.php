<?php

namespace Nebatech\Controllers;

use Nebatech\Core\Controller;
use Nebatech\Core\Database;
use Nebatech\Services\HubtelPaymentService;
use Nebatech\Services\EmailService;

class EnrollmentController extends Controller
{
    private HubtelPaymentService $paymentService;
    private EmailService $emailService;

    public function __construct()
    {
        parent::__construct();
        $this->paymentService = new HubtelPaymentService();
        $this->emailService = new EmailService();
    }

    /**
     * Show enrollment page for a course
     */
    public function show(string $slug): string
    {
        // Check if user is logged in
        if (!isset($_SESSION['user'])) {
            $_SESSION['redirect_after_login'] = "/courses/$slug/enroll";
            header('Location: ' . url('/login'));
            exit;
        }

        $db = Database::connect();

        // Get course details
        $stmt = $db->prepare("
            SELECT * FROM courses 
            WHERE slug = ? AND status = 'published'
        ");
        $stmt->execute([$slug]);
        $course = $stmt->fetch();

        if (!$course) {
            header('Location: ' . url('/courses'));
            exit;
        }

        // Check if user is already enrolled
        $userId = $_SESSION['user']['id'];
        $stmt = $db->prepare("
            SELECT * FROM enrollments 
            WHERE user_id = ? AND course_id = ? AND payment_status = 'completed'
        ");
        $stmt->execute([$userId, $course['id']]);
        $enrollment = $stmt->fetch();

        if ($enrollment) {
            // Already enrolled, redirect to course learning page
            $_SESSION['success_message'] = "You are already enrolled in this course!";
            header('Location: ' . url("/courses/$slug/learn"));
            exit;
        }

        // Check for pending enrollment
        $stmt = $db->prepare("
            SELECT * FROM enrollments 
            WHERE user_id = ? AND course_id = ? AND payment_status = 'pending'
            ORDER BY created_at DESC LIMIT 1
        ");
        $stmt->execute([$userId, $course['id']]);
        $pendingEnrollment = $stmt->fetch();

        // Get payment configuration
        $paymentConfig = require __DIR__ . '/../../config/payment.php';

        return $this->render('courses.enroll', [
            'title' => 'Enroll in ' . $course['title'],
            'course' => $course,
            'pendingEnrollment' => $pendingEnrollment,
            'paymentMethods' => $paymentConfig['methods'],
            'currency' => $paymentConfig['currency_symbol'] ?? 'GH₵',
        ], 'main');
    }

    /**
     * Process enrollment submission - Redirect to Hubtel Checkout
     */
    public function process(string $slug): void
    {
        // Check if user is logged in
        if (!isset($_SESSION['user'])) {
            $_SESSION['error_message'] = "Please login to enroll in courses.";
            header('Location: ' . url('/login'));
            exit;
        }

        $db = Database::connect();
        $user = $_SESSION['user'];

        // Get course details
        $stmt = $db->prepare("
            SELECT * FROM courses 
            WHERE slug = ? AND status = 'published'
        ");
        $stmt->execute([$slug]);
        $course = $stmt->fetch();

        if (!$course) {
            $_SESSION['error_message'] = "Course not found.";
            header('Location: ' . url('/courses'));
            exit;
        }

        // Check if user is already enrolled
        $userId = $user['id'];
        $stmt = $db->prepare("
            SELECT * FROM enrollments 
            WHERE user_id = ? AND course_id = ? AND payment_status = 'completed'
        ");
        $stmt->execute([$userId, $course['id']]);
        $existingEnrollment = $stmt->fetch();

        if ($existingEnrollment) {
            $_SESSION['success_message'] = "You are already enrolled in this course!";
            header('Location: ' . url("/courses/$slug/learn"));
            exit;
        }

        // Validate form data
        $errors = [];
        
        $fullName = trim($_POST['full_name'] ?? ($user['first_name'] . ' ' . $user['last_name']));
        $email = trim($_POST['email'] ?? $user['email']);
        $phone = trim($_POST['phone'] ?? '');
        $terms = isset($_POST['terms']);

        if (empty($fullName)) $errors[] = "Full name is required.";
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required.";
        if (empty($phone)) $errors[] = "Phone number is required.";
        if (!$terms) $errors[] = "You must agree to the terms and conditions.";

        if (!empty($errors)) {
            $_SESSION['error_message'] = implode('<br>', $errors);
            header('Location: ' . url("/courses/$slug/enroll"));
            exit;
        }

        // Check if Hubtel is configured
        if (!$this->paymentService->isConfigured()) {
            $_SESSION['error_message'] = "Payment service is not configured. Please contact support.";
            error_log("Hubtel Payment Service not configured");
            header('Location: ' . url("/courses/$slug/enroll"));
            exit;
        }

        // Generate unique client reference
        $clientReference = $this->paymentService->generateClientReference('ENR');

        try {
            // Create pending enrollment record
            $stmt = $db->prepare("
                INSERT INTO enrollments 
                (user_id, course_id, payment_status, payment_method, amount, transaction_id, payment_details, created_at) 
                VALUES (?, ?, 'pending', 'hubtel', ?, ?, ?, NOW())
                ON DUPLICATE KEY UPDATE 
                    payment_status = 'pending',
                    transaction_id = VALUES(transaction_id),
                    payment_details = VALUES(payment_details)
            ");
            $stmt->execute([
                $userId,
                $course['id'],
                $course['price'],
                $clientReference,
                json_encode([
                    'full_name' => $fullName,
                    'email' => $email,
                    'phone' => $phone,
                    'initiated_at' => date('Y-m-d H:i:s'),
                ])
            ]);

            $enrollmentId = $db->lastInsertId() ?: $this->getEnrollmentId($db, $userId, $course['id']);

            // Update user phone if provided
            if (!empty($phone)) {
                $stmt = $db->prepare("UPDATE users SET phone = ? WHERE id = ? AND (phone IS NULL OR phone = '')");
                $stmt->execute([$phone, $userId]);
            }

            // Initiate Hubtel checkout
            $appUrl = $_ENV['APP_URL'] ?? 'http://localhost';
            
            $checkoutResponse = $this->paymentService->initiateCheckout([
                'amount' => (float) $course['price'],
                'description' => "Enrollment: " . $course['title'],
                'clientReference' => $clientReference,
                'returnUrl' => $appUrl . "/payments/success?ref={$clientReference}",
                'cancellationUrl' => $appUrl . "/payments/cancelled?ref={$clientReference}",
                'payeeName' => $fullName,
                'payeeMobileNumber' => $phone,
                'payeeEmail' => $email,
            ]);

            if (!$checkoutResponse['success']) {
                throw new \Exception('Failed to initiate payment checkout');
            }

            // Store checkout ID in enrollment
            $stmt = $db->prepare("
                UPDATE enrollments 
                SET payment_details = JSON_SET(COALESCE(payment_details, '{}'), 
                    '$.checkout_id', ?,
                    '$.checkout_url', ?
                )
                WHERE id = ?
            ");
            $stmt->execute([
                $checkoutResponse['checkoutId'],
                $checkoutResponse['checkoutUrl'],
                $enrollmentId
            ]);

            // Redirect to Hubtel checkout
            header('Location: ' . $checkoutResponse['checkoutUrl']);
            exit;

        } catch (\Exception $e) {
            $_SESSION['error_message'] = "An error occurred while initiating payment. Please try again.";
            error_log("Enrollment payment error: " . $e->getMessage());
            header('Location: ' . url("/courses/$slug/enroll"));
            exit;
        }
    }

    /**
     * Payment success callback page
     */
    public function success(): string
    {
        $clientReference = $_GET['ref'] ?? '';
        
        if (empty($clientReference)) {
            $_SESSION['error_message'] = "Invalid payment reference.";
            header('Location: ' . url('/dashboard'));
            exit;
        }

        $db = Database::connect();

        // Find the enrollment
        $stmt = $db->prepare("
            SELECT e.*, c.title as course_title, c.slug as course_slug
            FROM enrollments e
            JOIN courses c ON e.course_id = c.id
            WHERE e.transaction_id = ?
        ");
        $stmt->execute([$clientReference]);
        $enrollment = $stmt->fetch();

        if (!$enrollment) {
            $_SESSION['error_message'] = "Enrollment not found.";
            header('Location: ' . url('/dashboard'));
            exit;
        }

        // Check payment status with Hubtel
        $statusCheck = $this->paymentService->checkTransactionStatus($clientReference);

        if ($statusCheck['success'] && $statusCheck['status'] === 'paid') {
            // Update enrollment to completed
            $this->completeEnrollment($enrollment['id'], $statusCheck);
            
            $_SESSION['success_message'] = "Payment successful! Welcome to " . $enrollment['course_title'] . ". You can now start learning.";
            header('Location: ' . url("/courses/{$enrollment['course_slug']}/learn"));
            exit;
        }

        // Payment might still be processing
        return $this->render('payments.success', [
            'title' => 'Payment Processing',
            'enrollment' => $enrollment,
            'statusCheck' => $statusCheck,
        ], 'main');
    }

    /**
     * Payment cancelled callback page
     */
    public function cancelled(): string
    {
        $clientReference = $_GET['ref'] ?? '';
        
        $db = Database::connect();

        if (!empty($clientReference)) {
            // Update enrollment status
            $stmt = $db->prepare("
                UPDATE enrollments 
                SET payment_status = 'cancelled',
                    payment_details = JSON_SET(COALESCE(payment_details, '{}'), '$.cancelled_at', ?)
                WHERE transaction_id = ? AND payment_status = 'pending'
            ");
            $stmt->execute([date('Y-m-d H:i:s'), $clientReference]);

            // Get course info for redirect
            $stmt = $db->prepare("
                SELECT c.slug 
                FROM enrollments e
                JOIN courses c ON e.course_id = c.id
                WHERE e.transaction_id = ?
            ");
            $stmt->execute([$clientReference]);
            $result = $stmt->fetch();
            
            if ($result) {
                $_SESSION['info_message'] = "Payment was cancelled. You can try again when you're ready.";
                header('Location: ' . url("/courses/{$result['slug']}/enroll"));
                exit;
            }
        }

        $_SESSION['info_message'] = "Payment was cancelled.";
        header('Location: ' . url('/courses'));
        exit;
    }

    /**
     * Check payment status (AJAX endpoint)
     */
    public function checkStatus(): void
    {
        header('Content-Type: application/json');

        $clientReference = $_GET['ref'] ?? $_POST['ref'] ?? '';

        if (empty($clientReference)) {
            echo json_encode(['error' => 'Missing reference']);
            exit;
        }

        $statusCheck = $this->paymentService->checkTransactionStatus($clientReference);

        if ($statusCheck['success'] && $statusCheck['status'] === 'paid') {
            // Update enrollment
            $db = Database::connect();
            $stmt = $db->prepare("SELECT id FROM enrollments WHERE transaction_id = ? AND payment_status = 'pending'");
            $stmt->execute([$clientReference]);
            $enrollment = $stmt->fetch();

            if ($enrollment) {
                $this->completeEnrollment($enrollment['id'], $statusCheck);
            }
        }

        echo json_encode($statusCheck);
        exit;
    }

    /**
     * Complete enrollment after successful payment
     */
    private function completeEnrollment(int $enrollmentId, array $paymentDetails): void
    {
        $db = Database::connect();

        // Update enrollment
        $stmt = $db->prepare("
            UPDATE enrollments 
            SET payment_status = 'completed',
                enrolled_at = NOW(),
                payment_details = JSON_SET(
                    COALESCE(payment_details, '{}'),
                    '$.hubtel_transaction_id', ?,
                    '$.external_transaction_id', ?,
                    '$.payment_method', ?,
                    '$.amount_paid', ?,
                    '$.charges', ?,
                    '$.completed_at', ?
                )
            WHERE id = ?
        ");
        $stmt->execute([
            $paymentDetails['transactionId'] ?? null,
            $paymentDetails['externalTransactionId'] ?? null,
            $paymentDetails['paymentMethod'] ?? 'hubtel',
            $paymentDetails['amount'] ?? 0,
            $paymentDetails['charges'] ?? 0,
            date('Y-m-d H:i:s'),
            $enrollmentId
        ]);

        // Get enrollment details for email
        $stmt = $db->prepare("
            SELECT e.*, u.email, u.first_name, u.last_name, 
                   c.title as course_title, c.slug as course_slug, c.description as course_description
            FROM enrollments e
            JOIN users u ON e.user_id = u.id
            JOIN courses c ON e.course_id = c.id
            WHERE e.id = ?
        ");
        $stmt->execute([$enrollmentId]);
        $enrollment = $stmt->fetch();

        if ($enrollment) {
            // Send confirmation email
            $this->sendEnrollmentConfirmation($enrollment);

            // Create notification
            $this->createNotification(
                $enrollment['user_id'],
                'enrollment_success',
                "You've successfully enrolled in {$enrollment['course_title']}!",
                "/courses/{$enrollment['course_slug']}/learn"
            );
        }
    }

    /**
     * Send enrollment confirmation email
     */
    private function sendEnrollmentConfirmation(array $enrollment): void
    {
        try {
            // Prepare user data
            $user = [
                'email' => $enrollment['email'],
                'first_name' => $enrollment['first_name'],
                'last_name' => $enrollment['last_name']
            ];
            
            // Prepare course data
            $course = [
                'title' => $enrollment['course_title'],
                'slug' => $enrollment['course_slug'],
                'description' => $enrollment['course_description'] ?? ''
            ];
            
            // Prepare enrollment data
            $enrollmentData = [
                'id' => $enrollment['id'],
                'amount' => $enrollment['amount'],
                'transaction_id' => $enrollment['transaction_id'],
                'enrolled_at' => $enrollment['enrolled_at']
            ];
            
            $this->emailService->sendEnrollmentConfirmation($enrollmentData, $user, $course);
        } catch (\Exception $e) {
            error_log("Failed to send enrollment confirmation email: " . $e->getMessage());
        }
    }

    /**
     * Create a notification for the user
     */
    private function createNotification(int $userId, string $type, string $message, string $link = null): void
    {
        try {
            $db = Database::connect();
            $stmt = $db->prepare("
                INSERT INTO notifications (user_id, type, message, link, created_at)
                VALUES (?, ?, ?, ?, NOW())
            ");
            $stmt->execute([$userId, $type, $message, $link]);
        } catch (\Exception $e) {
            error_log("Failed to create notification: " . $e->getMessage());
        }
    }

    /**
     * Get enrollment ID helper
     */
    private function getEnrollmentId(\PDO $db, int $userId, int $courseId): ?int
    {
        $stmt = $db->prepare("SELECT id FROM enrollments WHERE user_id = ? AND course_id = ?");
        $stmt->execute([$userId, $courseId]);
        $result = $stmt->fetch();
        return $result ? $result['id'] : null;
    }

    /**
     * Get card type from card number (legacy - kept for reference)
     */
    private function getCardType(string $cardNumber): string
    {
        $cardNumber = preg_replace('/\s+/', '', $cardNumber);
        
        if (preg_match('/^4/', $cardNumber)) return 'Visa';
        if (preg_match('/^5[1-5]/', $cardNumber)) return 'Mastercard';
        if (preg_match('/^3[47]/', $cardNumber)) return 'Amex';
        
        return 'Unknown';
    }
}
