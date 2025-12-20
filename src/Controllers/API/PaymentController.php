<?php

namespace Nebatech\Controllers\API;

use Nebatech\Core\Controller;
use Nebatech\Core\Database;
use Nebatech\Services\HubtelPaymentService;
use Nebatech\Services\EmailService;
use Nebatech\Services\NotificationService;

/**
 * Payment API Controller
 * Handles payment gateway callbacks and status checks
 */
class PaymentController extends Controller
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
     * Hubtel payment callback endpoint
     * Receives payment status notifications from Hubtel
     */
    public function hubtelCallback(): void
    {
        // Get raw POST data
        $rawInput = file_get_contents('php://input');
        
        // Log incoming callback
        $this->logCallback('hubtel', $rawInput);

        // Parse JSON
        $callbackData = json_decode($rawInput, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid JSON']);
            exit;
        }

        // Process callback through payment service
        $result = $this->paymentService->processCallback($callbackData);

        if (empty($result['clientReference'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing client reference']);
            exit;
        }

        $db = Database::connect();

        // Find the enrollment by client reference
        $stmt = $db->prepare("
            SELECT e.*, u.id as user_id, u.email, u.first_name, u.last_name, 
                   c.title as course_title, c.slug as course_slug
            FROM enrollments e
            JOIN users u ON e.user_id = u.id
            JOIN courses c ON e.course_id = c.id
            WHERE e.transaction_id = ?
        ");
        $stmt->execute([$result['clientReference']]);
        $enrollment = $stmt->fetch();

        if (!$enrollment) {
            // Log unknown reference
            error_log("Hubtel callback for unknown reference: " . $result['clientReference']);
            http_response_code(200); // Still respond 200 to acknowledge receipt
            echo json_encode(['status' => 'reference_not_found']);
            exit;
        }

        // Update enrollment based on payment status
        if ($result['success'] && in_array($result['status'], ['success', 'paid'])) {
            // Payment successful
            $this->completeEnrollment($enrollment, $result);
            
            echo json_encode([
                'status' => 'success',
                'message' => 'Enrollment completed'
            ]);
        } elseif (in_array($result['status'], ['failed', 'cancelled'])) {
            // Payment failed
            $this->failEnrollment($enrollment, $result);
            
            echo json_encode([
                'status' => 'failed',
                'message' => 'Payment failed'
            ]);
        } else {
            // Still pending or unknown status
            $this->updateEnrollmentDetails($enrollment['id'], $result);
            
            echo json_encode([
                'status' => 'pending',
                'message' => 'Status updated'
            ]);
        }

        exit;
    }

    /**
     * Check transaction status endpoint
     */
    public function checkStatus(): void
    {
        header('Content-Type: application/json');

        $clientReference = $_GET['ref'] ?? $_POST['ref'] ?? '';

        if (empty($clientReference)) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing reference parameter']);
            exit;
        }

        // Check status with Hubtel
        $statusCheck = $this->paymentService->checkTransactionStatus($clientReference);

        // If paid, update enrollment
        if ($statusCheck['success'] && $statusCheck['status'] === 'paid') {
            $db = Database::connect();
            $stmt = $db->prepare("
                SELECT e.*, u.email, u.first_name, u.last_name, 
                       c.title as course_title, c.slug as course_slug
                FROM enrollments e
                JOIN users u ON e.user_id = u.id
                JOIN courses c ON e.course_id = c.id
                WHERE e.transaction_id = ? AND e.payment_status = 'pending'
            ");
            $stmt->execute([$clientReference]);
            $enrollment = $stmt->fetch();

            if ($enrollment) {
                $this->completeEnrollment($enrollment, $statusCheck);
                $statusCheck['enrollment_completed'] = true;
                $statusCheck['course_slug'] = $enrollment['course_slug'];
            }
        }

        echo json_encode($statusCheck);
        exit;
    }

    /**
     * Get payment methods available
     */
    public function getMethods(): void
    {
        header('Content-Type: application/json');

        $paymentConfig = require __DIR__ . '/../../../config/payment.php';

        $methods = array_filter($paymentConfig['methods'], function($method) {
            return $method['enabled'] ?? false;
        });

        echo json_encode([
            'success' => true,
            'currency' => $paymentConfig['currency'],
            'currency_symbol' => $paymentConfig['currency_symbol'],
            'methods' => $methods
        ]);
        exit;
    }

    /**
     * Complete enrollment after successful payment
     */
    private function completeEnrollment(array $enrollment, array $paymentResult): void
    {
        $db = Database::connect();

        // Update enrollment to completed
        $stmt = $db->prepare("
            UPDATE enrollments 
            SET payment_status = 'completed',
                enrolled_at = NOW(),
                payment_details = JSON_SET(
                    COALESCE(payment_details, '{}'),
                    '$.hubtel_checkout_id', ?,
                    '$.hubtel_sales_invoice_id', ?,
                    '$.hubtel_transaction_id', ?,
                    '$.payment_method', ?,
                    '$.customer_phone', ?,
                    '$.amount_paid', ?,
                    '$.completed_at', ?,
                    '$.callback_received', ?
                )
            WHERE id = ?
        ");
        $stmt->execute([
            $paymentResult['checkoutId'] ?? null,
            $paymentResult['salesInvoiceId'] ?? null,
            $paymentResult['transactionId'] ?? null,
            $paymentResult['paymentDetails']['PaymentType'] ?? $paymentResult['paymentMethod'] ?? 'unknown',
            $paymentResult['customerPhone'] ?? null,
            $paymentResult['amount'] ?? $enrollment['amount'],
            date('Y-m-d H:i:s'),
            true,
            $enrollment['id']
        ]);

        // Send confirmation email
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
                'enrolled_at' => date('Y-m-d H:i:s')
            ];
            
            $this->emailService->sendEnrollmentConfirmation($enrollmentData, $user, $course);
        } catch (\Exception $e) {
            error_log("Failed to send enrollment email: " . $e->getMessage());
        }

        // Create notification
        $this->createNotification(
            $enrollment['user_id'],
            'enrollment_success',
            "🎉 Payment successful! You're now enrolled in {$enrollment['course_title']}.",
            "/courses/{$enrollment['course_slug']}/learn"
        );

        // Log success
        error_log("Enrollment completed: User {$enrollment['user_id']} enrolled in course {$enrollment['course_id']}");
    }

    /**
     * Handle failed payment
     */
    private function failEnrollment(array $enrollment, array $paymentResult): void
    {
        $db = Database::connect();

        $stmt = $db->prepare("
            UPDATE enrollments 
            SET payment_status = 'failed',
                payment_details = JSON_SET(
                    COALESCE(payment_details, '{}'),
                    '$.failure_reason', ?,
                    '$.failed_at', ?
                )
            WHERE id = ?
        ");
        $stmt->execute([
            $paymentResult['description'] ?? 'Payment failed',
            date('Y-m-d H:i:s'),
            $enrollment['id']
        ]);

        // Create notification
        $this->createNotification(
            $enrollment['user_id'],
            'payment_failed',
            "Payment for {$enrollment['course_title']} was unsuccessful. Please try again.",
            "/courses/{$enrollment['course_slug']}/enroll"
        );
    }

    /**
     * Update enrollment with callback details
     */
    private function updateEnrollmentDetails(int $enrollmentId, array $result): void
    {
        $db = Database::connect();

        $stmt = $db->prepare("
            UPDATE enrollments 
            SET payment_details = JSON_SET(
                COALESCE(payment_details, '{}'),
                '$.last_callback_at', ?,
                '$.last_status', ?
            )
            WHERE id = ?
        ");
        $stmt->execute([
            date('Y-m-d H:i:s'),
            $result['status'] ?? 'unknown',
            $enrollmentId
        ]);
    }

    /**
     * Create a notification
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
     * Log incoming callback for debugging
     */
    private function logCallback(string $gateway, string $rawData): void
    {
        $logPath = __DIR__ . '/../../../storage/logs/payment_callbacks.log';
        
        $logEntry = [
            'timestamp' => date('Y-m-d H:i:s'),
            'gateway' => $gateway,
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            'data' => $rawData
        ];

        file_put_contents(
            $logPath, 
            json_encode($logEntry) . PHP_EOL, 
            FILE_APPEND | LOCK_EX
        );
    }
}
