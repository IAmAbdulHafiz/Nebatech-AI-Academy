<?php

namespace Nebatech\Controllers\Public;

use Nebatech\Core\Controller;

class ContactController extends Controller
{
    public function index()
    {
        echo $this->view('contact.index', [
            'title' => 'Contact Us'
        ]);
    }

    public function submit()
    {
        // Handle contact form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $subject = trim($_POST['subject'] ?? '');
            $message = trim($_POST['message'] ?? '');
            $phone = trim($_POST['phone'] ?? '');

            $errors = [];

            // Validate input
            if (empty($name)) {
                $errors['name'] = 'Name is required.';
            }

            if (!$email) {
                $errors['email'] = 'Please provide a valid email address.';
            }

            if (empty($message)) {
                $errors['message'] = 'Message is required.';
            } elseif (strlen($message) < 10) {
                $errors['message'] = 'Message must be at least 10 characters.';
            }

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old_input'] = [
                    'name' => $name,
                    'email' => $_POST['email'] ?? '',
                    'subject' => $subject,
                    'message' => $message,
                    'phone' => $phone
                ];
                header('Location: ' . url('/contact'));
                exit;
            }

            // Create contact submission
            $contactId = \Nebatech\Models\Contact::create([
                'name' => $name,
                'email' => $email,
                'subject' => $subject,
                'message' => $message,
                'phone' => $phone
            ]);

            if ($contactId) {
                // Send notification email to admin
                try {
                    $emailService = new \Nebatech\Services\EmailService();
                    $emailService->sendContactNotification([
                        'id' => $contactId,
                        'name' => $name,
                        'email' => $email,
                        'subject' => $subject,
                        'message' => $message,
                        'phone' => $phone
                    ]);
                } catch (\Exception $e) {
                    error_log("Failed to send contact notification: " . $e->getMessage());
                }

                $_SESSION['success'] = 'Thank you for contacting us! We will get back to you soon.';
            } else {
                $_SESSION['errors'] = ['general' => 'Failed to submit your message. Please try again.'];
            }

            header('Location: ' . url('/contact'));
            exit;
        }
    }
}
