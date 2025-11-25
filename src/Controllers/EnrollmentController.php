<?php

namespace Nebatech\Controllers;

use Nebatech\Core\Controller;
use Nebatech\Core\Database;

class EnrollmentController extends Controller
{
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

        return $this->render('courses.enroll', [
            'title' => 'Enroll in ' . $course['title'],
            'course' => $course
        ], 'main');
    }

    /**
     * Process enrollment submission
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
        $userId = $_SESSION['user']['id'];
        $stmt = $db->prepare("
            SELECT * FROM enrollments 
            WHERE user_id = ? AND course_id = ?
        ");
        $stmt->execute([$userId, $course['id']]);
        $existingEnrollment = $stmt->fetch();

        if ($existingEnrollment && $existingEnrollment['payment_status'] === 'completed') {
            $_SESSION['success_message'] = "You are already enrolled in this course!";
            header('Location: ' . url("/courses/$slug/learn"));
            exit;
        }

        // Validate form data
        $errors = [];
        
        $fullName = trim($_POST['full_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $location = trim($_POST['location'] ?? '');
        $paymentMethod = $_POST['payment_method'] ?? '';
        $terms = isset($_POST['terms']);

        if (empty($fullName)) $errors[] = "Full name is required.";
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required.";
        if (empty($phone)) $errors[] = "Phone number is required.";
        if (empty($paymentMethod)) $errors[] = "Payment method is required.";
        if (!$terms) $errors[] = "You must agree to the terms and conditions.";

        // Validate payment method specific fields
        $paymentDetails = [];
        
        if ($paymentMethod === 'mobile_money') {
            $momoNetwork = $_POST['momo_network'] ?? '';
            $momoNumber = trim($_POST['momo_number'] ?? '');
            
            if (empty($momoNetwork)) $errors[] = "Mobile money network is required.";
            if (empty($momoNumber)) $errors[] = "Mobile money number is required.";
            
            $paymentDetails = [
                'network' => $momoNetwork,
                'number' => $momoNumber
            ];
        } elseif ($paymentMethod === 'card') {
            $cardNumber = trim($_POST['card_number'] ?? '');
            $cardExpiry = trim($_POST['card_expiry'] ?? '');
            $cardCvv = trim($_POST['card_cvv'] ?? '');
            
            if (empty($cardNumber)) $errors[] = "Card number is required.";
            if (empty($cardExpiry)) $errors[] = "Card expiry date is required.";
            if (empty($cardCvv)) $errors[] = "Card CVV is required.";
            
            // Don't store full card details in plain text - this is just for demo
            $paymentDetails = [
                'card_last_4' => substr($cardNumber, -4),
                'card_type' => $this->getCardType($cardNumber)
            ];
        } elseif ($paymentMethod === 'bank_transfer') {
            $bankReference = trim($_POST['bank_reference'] ?? '');
            
            if (empty($bankReference)) $errors[] = "Bank transaction reference is required.";
            
            $paymentDetails = [
                'reference' => $bankReference
            ];
        }

        if (!empty($errors)) {
            $_SESSION['error_message'] = implode('<br>', $errors);
            header('Location: ' . url("/courses/$slug/enroll"));
            exit;
        }

        // Generate transaction ID
        $transactionId = 'TXN-' . strtoupper(uniqid()) . '-' . time();

        // Determine payment status based on method
        // Mobile Money and Card are instant (simulated), Bank Transfer requires verification
        $paymentStatus = ($paymentMethod === 'bank_transfer') ? 'pending' : 'completed';

        try {
            // Create or update enrollment record
            if ($existingEnrollment) {
                // Update existing enrollment
                $stmt = $db->prepare("
                    UPDATE enrollments 
                    SET payment_status = ?, 
                        payment_method = ?, 
                        amount = ?, 
                        transaction_id = ?,
                        payment_details = ?,
                        enrolled_at = NOW()
                    WHERE id = ?
                ");
                $stmt->execute([
                    $paymentStatus,
                    $paymentMethod,
                    $course['price'],
                    $transactionId,
                    json_encode($paymentDetails),
                    $existingEnrollment['id']
                ]);
            } else {
                // Create new enrollment
                $stmt = $db->prepare("
                    INSERT INTO enrollments 
                    (user_id, course_id, payment_status, payment_method, amount, transaction_id, payment_details, enrolled_at, created_at) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
                ");
                $stmt->execute([
                    $userId,
                    $course['id'],
                    $paymentStatus,
                    $paymentMethod,
                    $course['price'],
                    $transactionId,
                    json_encode($paymentDetails)
                ]);
            }

            // Update user profile if needed
            $stmt = $db->prepare("
                UPDATE users 
                SET phone = ?, location = ? 
                WHERE id = ?
            ");
            $stmt->execute([$phone, $location, $userId]);

            // Process payment based on method
            if ($paymentMethod === 'mobile_money') {
                // TODO: Integrate with actual Mobile Money API (MTN, Vodafone, AirtelTigo)
                // For now, simulate successful payment
                $this->processMobileMoneyPayment($paymentDetails, $course['price'], $transactionId);
            } elseif ($paymentMethod === 'card') {
                // TODO: Integrate with payment gateway (Paystack, Flutterwave, Stripe)
                // For now, simulate successful payment
                $this->processCardPayment($paymentDetails, $course['price'], $transactionId);
            }

            // Set success message based on payment status
            if ($paymentStatus === 'completed') {
                $_SESSION['success_message'] = "Enrollment successful! Welcome to " . $course['title'] . ". You can now start learning.";
                
                // TODO: Send confirmation email
                $this->sendEnrollmentConfirmation($email, $fullName, $course, $transactionId);
                
                // Redirect to course learning page
                header('Location: ' . url("/courses/$slug/learn"));
            } else {
                $_SESSION['success_message'] = "Your enrollment is pending payment verification. We'll notify you once your payment is confirmed (1-2 business days).";
                header('Location: ' . url('/dashboard'));
            }

        } catch (\Exception $e) {
            $_SESSION['error_message'] = "An error occurred during enrollment. Please try again or contact support.";
            error_log("Enrollment error: " . $e->getMessage());
            header('Location: ' . url("/courses/$slug/enroll"));
        }

        exit;
    }

    /**
     * Simulate Mobile Money payment processing
     */
    private function processMobileMoneyPayment(array $details, float $amount, string $transactionId): bool
    {
        // TODO: Integrate with actual Mobile Money APIs
        // MTN Mobile Money API: https://momodeveloper.mtn.com/
        // Vodafone Cash API: Contact Vodafone Ghana
        // AirtelTigo Money API: Contact AirtelTigo Ghana
        
        // Simulate successful payment
        return true;
    }

    /**
     * Simulate Card payment processing
     */
    private function processCardPayment(array $details, float $amount, string $transactionId): bool
    {
        // TODO: Integrate with payment gateway
        // Paystack: https://paystack.com/docs
        // Flutterwave: https://developer.flutterwave.com
        // Stripe: https://stripe.com/docs
        
        // Simulate successful payment
        return true;
    }

    /**
     * Get card type from card number
     */
    private function getCardType(string $cardNumber): string
    {
        $cardNumber = preg_replace('/\s+/', '', $cardNumber);
        
        if (preg_match('/^4/', $cardNumber)) return 'Visa';
        if (preg_match('/^5[1-5]/', $cardNumber)) return 'Mastercard';
        if (preg_match('/^3[47]/', $cardNumber)) return 'Amex';
        
        return 'Unknown';
    }

    /**
     * Send enrollment confirmation email
     */
    private function sendEnrollmentConfirmation(string $email, string $name, array $course, string $transactionId): void
    {
        // TODO: Implement email sending
        // Use PHPMailer or similar library
        // Include: Welcome message, course access link, transaction details, next steps
    }
}
