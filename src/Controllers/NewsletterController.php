<?php

namespace Nebatech\Controllers;

use Nebatech\Core\Controller;
use Nebatech\Core\Database;

class NewsletterController extends Controller
{
    public function subscribe()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . url('/'));
            exit;
        }
        
        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
        $name = trim($_POST['name'] ?? '');
        $source = $_POST['source'] ?? 'website';
        
        if (!$email) {
            $_SESSION['newsletter_error'] = 'Please enter a valid email address';
            header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? url('/')));
            exit;
        }
        
        // Check if already subscribed
        $existing = Database::fetch(
            "SELECT id, status FROM newsletter_subscriptions WHERE email = ?",
            [$email]
        );
        
        if ($existing) {
            if ($existing['status'] === 'active') {
                $_SESSION['newsletter_info'] = 'You are already subscribed to our newsletter!';
            } else {
                // Reactivate subscription
                Database::query(
                    "UPDATE newsletter_subscriptions 
                     SET status = 'active', subscribed_at = NOW() 
                     WHERE email = ?",
                    [$email]
                );
                $_SESSION['newsletter_success'] = 'Welcome back! Your subscription has been reactivated.';
            }
        } else {
            // Generate unsubscribe token
            $token = bin2hex(random_bytes(32));
            
            // Insert new subscription
            Database::query(
                "INSERT INTO newsletter_subscriptions (email, name, token, source, subscribed_at)
                 VALUES (?, ?, ?, ?, NOW())",
                [$email, $name, $token, $source]
            );
            
            $_SESSION['newsletter_success'] = 'Thank you for subscribing! Check your email for confirmation.';
            
            // TODO: Send welcome email
        }
        
        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? url('/')));
        exit;
    }
    
    public function unsubscribe()
    {
        $token = $_GET['token'] ?? '';
        
        if (empty($token)) {
            $_SESSION['error'] = 'Invalid unsubscribe link';
            header('Location: ' . url('/'));
            exit;
        }
        
        $subscription = Database::fetch(
            "SELECT id, email FROM newsletter_subscriptions WHERE token = ?",
            [$token]
        );
        
        if (!$subscription) {
            $_SESSION['error'] = 'Subscription not found';
            header('Location: ' . url('/'));
            exit;
        }
        
        // Unsubscribe
        Database::query(
            "UPDATE newsletter_subscriptions 
             SET status = 'unsubscribed', unsubscribed_at = NOW() 
             WHERE token = ?",
            [$token]
        );
        
        echo $this->view('newsletter.unsubscribed', [
            'title' => 'Unsubscribed',
            'email' => $subscription['email']
        ]);
    }
}
