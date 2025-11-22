<?php

namespace Nebatech\Controllers;

use Nebatech\Core\Controller;
use Nebatech\Core\Database;

class ContactController extends Controller
{
    public function index()
    {
        echo $this->render('contact.index', [
            'title' => 'Contact Us'
        ], 'main');
    }

    public function submit()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo $this->render('contact.index', ['title' => 'Contact Us'], 'main');
            return;
        }
        
        // Validate input
        $name = trim($_POST['name'] ?? '');
        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
        $phone = trim($_POST['phone'] ?? '');
        $subject = trim($_POST['subject'] ?? '');
        $message = trim($_POST['message'] ?? '');
        
        $errors = [];
        
        if (empty($name)) {
            $errors[] = 'Name is required';
        }
        
        if (!$email) {
            $errors[] = 'Valid email is required';
        }
        
        if (empty($subject)) {
            $errors[] = 'Subject is required';
        }
        
        if (empty($message)) {
            $errors[] = 'Message is required';
        }
        
        if (!empty($errors)) {
            $_SESSION['contact_errors'] = $errors;
            $_SESSION['contact_old'] = $_POST;
            header('Location: ' . url('/contact'));
            exit;
        }
        
        // Get user info
        $ipAddress = $_SERVER['REMOTE_ADDR'] ?? null;
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? null;
        
        // Save to database
        try {
            Database::query(
                "INSERT INTO contact_submissions 
                 (name, email, phone, subject, message, ip_address, user_agent, created_at)
                 VALUES (?, ?, ?, ?, ?, ?, ?, NOW())",
                [$name, $email, $phone, $subject, $message, $ipAddress, $userAgent]
            );
            
            // TODO: Send email notification to admin
            // TODO: Send confirmation email to user
            
            $_SESSION['contact_success'] = 'Thank you for contacting us! We will get back to you soon.';
            header('Location: ' . url('/contact?success=1'));
            exit;
            
        } catch (\Exception $e) {
            $_SESSION['contact_error'] = 'An error occurred. Please try again later.';
            header('Location: ' . url('/contact'));
            exit;
        }
    }
}
