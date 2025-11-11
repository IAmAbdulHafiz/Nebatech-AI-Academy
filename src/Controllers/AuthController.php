<?php

namespace Nebatech\Controllers;

use Nebatech\Core\Controller;
use Nebatech\Models\User;

class AuthController extends Controller
{
    public function __construct()
    {
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function showLogin()
    {
        // Redirect if already logged in
        if ($this->isAuthenticated()) {
            header('Location: ' . url('/dashboard'));
            exit;
        }

        $errors = $_SESSION['errors'] ?? [];
        $oldInput = $_SESSION['old_input'] ?? [];
        $success = $_SESSION['success'] ?? '';
        
        // Clear flash data
        unset($_SESSION['errors'], $_SESSION['old_input'], $_SESSION['success']);

        echo $this->view('auth/login', [
            'title' => 'Login',
            'errors' => $errors,
            'oldInput' => $oldInput,
            'success' => $success
        ]);
    }

    public function showRegister()
    {
        // Redirect if already logged in
        if ($this->isAuthenticated()) {
            header('Location: ' . url('/dashboard'));
            exit;
        }

        $errors = $_SESSION['errors'] ?? [];
        $oldInput = $_SESSION['old_input'] ?? [];
        
        // Clear flash data
        unset($_SESSION['errors'], $_SESSION['old_input']);

        echo $this->view('auth/register', [
            'title' => 'Register',
            'errors' => $errors,
            'oldInput' => $oldInput
        ]);
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . url('/login'));
            exit;
        }

        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = $_POST['password'] ?? '';
        $remember = isset($_POST['remember']);

        $errors = [];

        // Validate input
        if (!$email) {
            $errors['email'] = 'Please provide a valid email address.';
        }

        if (empty($password)) {
            $errors['password'] = 'Password is required.';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_input'] = ['email' => $_POST['email'] ?? ''];
            header('Location: ' . url('/login'));
            exit;
        }

        // Find user by email
        $user = User::findByEmail($email);

        if (!$user) {
            $_SESSION['errors'] = ['email' => 'Invalid email or password.'];
            $_SESSION['old_input'] = ['email' => $email];
            header('Location: ' . url('/login'));
            exit;
        }

        // Verify password
        if (!User::verifyPassword($password, $user['password'])) {
            $_SESSION['errors'] = ['email' => 'Invalid email or password.'];
            $_SESSION['old_input'] = ['email' => $email];
            header('Location: ' . url('/login'));
            exit;
        }

        // Check if user account is active
        if ($user['status'] !== 'active') {
            $_SESSION['errors'] = ['email' => 'Your account has been suspended. Please contact support.'];
            header('Location: ' . url('/login'));
            exit;
        }

        // Regenerate session ID for security
        session_regenerate_id(true);

        // Set session data
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_uuid'] = $user['uuid'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
        
        // Set complete user data for middleware
        $_SESSION['user_data'] = $user;

        // Handle remember me
        if ($remember) {
            $token = bin2hex(random_bytes(32));
            $expiresAt = date('Y-m-d H:i:s', time() + (86400 * 30)); // 30 days
            
            // Store token in database for verification
            try {
                \Nebatech\Core\Database::insert('remember_tokens', [
                    'user_id' => $user['id'],
                    'token' => $token,
                    'expires_at' => $expiresAt
                ]);
                
                setcookie('remember_token', $token, time() + (86400 * 30), '/', '', true, true);
            } catch (\Exception $e) {
                error_log("Failed to store remember token: " . $e->getMessage());
            }
        }

        // Redirect based on role
        $redirectUrl = match($user['role']) {
            'admin' => url('/admin/dashboard'),
            'facilitator' => url('/facilitator/dashboard'),
            default => url('/dashboard')
        };

        header('Location: ' . $redirectUrl);
        exit;
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . url('/register'));
            exit;
        }

        // Get full name and split it
        $fullName = trim($_POST['name'] ?? '');
        $nameParts = explode(' ', $fullName, 2);
        $firstName = $nameParts[0] ?? '';
        $lastName = $nameParts[1] ?? '';

        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = $_POST['password'] ?? '';
        $agreeTerms = isset($_POST['terms']);

        $errors = [];

        // Validate name
        if (empty($fullName)) {
            $errors['name'] = 'Full name is required.';
        } elseif (strlen($fullName) < 3) {
            $errors['name'] = 'Please enter your full name.';
        }

        // Validate email
        if (!$email) {
            $errors['email'] = 'Please provide a valid email address.';
        } elseif (User::emailExists($email)) {
            $errors['email'] = 'This email is already registered.';
        }

        // Validate password
        if (empty($password)) {
            $errors['password'] = 'Password is required.';
        } elseif (strlen($password) < 8) {
            $errors['password'] = 'Password must be at least 8 characters.';
        }

        // Validate terms agreement
        if (!$agreeTerms) {
            $errors['terms'] = 'You must agree to the Terms of Service and Privacy Policy.';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_input'] = [
                'name' => $fullName,
                'email' => $_POST['email'] ?? ''
            ];
            header('Location: ' . url('/register'));
            exit;
        }

        // Create user
        $userId = User::create([
            'first_name' => $firstName,
            'last_name' => $lastName ?: $firstName,
            'email' => $email,
            'password' => $password,
            'role' => 'student',
            'status' => 'active'
        ]);

        if (!$userId) {
            $_SESSION['errors'] = ['general' => 'Registration failed. Please try again.'];
            $_SESSION['old_input'] = [
                'name' => $fullName,
                'email' => $_POST['email'] ?? ''
            ];
            header('Location: ' . url('/register'));
            exit;
        }

        // Send welcome email
        try {
            $user = \Nebatech\Models\User::findById($userId);
            if ($user) {
                $emailService = new \Nebatech\Services\EmailService();
                $emailService->sendWelcomeEmailNewUser($user);
            }
        } catch (\Exception $e) {
            error_log("Failed to send welcome email: " . $e->getMessage());
        }

        // Send email verification
        try {
            $user = \Nebatech\Models\User::findById($userId);
            if ($user) {
                $emailService = new \Nebatech\Services\EmailService();
                $emailService->sendEmailVerification($user);
            }
        } catch (\Exception $e) {
            error_log("Failed to send verification email: " . $e->getMessage());
        }

        // Set success message
        $_SESSION['success'] = 'Registration successful! Please check your email to verify your account and log in.';
        
        header('Location: ' . url('/login'));
        exit;
    }

    public function logout()
    {
        // Determine redirect location before destroying session
        $referer = $_SERVER['HTTP_REFERER'] ?? '';
        $publicPages = ['/', '/about', '/blog', '/contact', '/courses', '/login', '/register'];
        
        // Check if referer is a public page
        $redirectTo = '/';
        if (!empty($referer)) {
            $refererPath = parse_url($referer, PHP_URL_PATH);
            // Remove base path if it exists
            $basePath = parse_url(url('/'), PHP_URL_PATH);
            if ($basePath && $basePath !== '/') {
                $refererPath = str_replace($basePath, '', $refererPath);
            }
            
            // Check if it's a public page or course listing
            if (in_array($refererPath, $publicPages) || 
                str_starts_with($refererPath, '/courses/') || 
                str_starts_with($refererPath, '/blog/')) {
                $redirectTo = $refererPath;
            }
        }
        
        // Clear session
        $_SESSION = [];
        
        // Destroy session cookie
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 42000, '/');
        }
        
        // Clear remember me cookie and database token
        if (isset($_COOKIE['remember_token'])) {
            try {
                // Delete token from database
                \Nebatech\Core\Database::delete(
                    'remember_tokens',
                    'token = :token',
                    ['token' => $_COOKIE['remember_token']]
                );
            } catch (\Exception $e) {
                error_log("Failed to delete remember token: " . $e->getMessage());
            }
            
            setcookie('remember_token', '', time() - 42000, '/', '', true, true);
        }
        
        // Destroy session
        session_destroy();
        
        // Redirect to appropriate page
        header('Location: ' . url($redirectTo));
        exit;
    }

    public function forgotPassword()
    {
        echo $this->view('auth/forgot-password', [
            'title' => 'Forgot Password'
        ]);
    }

    public function resetPassword()
    {
        echo $this->view('auth/reset-password', [
            'title' => 'Reset Password'
        ]);
    }

    /**
     * Verify email address
     */
    public function verifyEmail()
    {
        $token = $_GET['token'] ?? '';
        
        if (empty($token)) {
            $_SESSION['error'] = 'Invalid verification link.';
            header('Location: ' . url('/login'));
            exit;
        }

        try {
            // Find verification record
            $verification = \Nebatech\Core\Database::fetch(
                'SELECT * FROM email_verifications WHERE token = :token AND verified_at IS NULL',
                ['token' => $token]
            );

            if (!$verification) {
                echo $this->view('auth/verify-email', [
                    'title' => 'Email Verification',
                    'success' => false,
                    'message' => 'Invalid or already used verification link.'
                ]);
                return;
            }

            // Check if token has expired
            if (strtotime($verification['expires_at']) < time()) {
                echo $this->view('auth/verify-email', [
                    'title' => 'Email Verification',
                    'success' => false,
                    'message' => 'This verification link has expired. Please request a new one.'
                ]);
                return;
            }

            // Mark email as verified
            \Nebatech\Core\Database::update(
                'users',
                ['email_verified_at' => date('Y-m-d H:i:s')],
                'id = :id',
                ['id' => $verification['user_id']]
            );

            // Mark verification as used
            \Nebatech\Core\Database::update(
                'email_verifications',
                ['verified_at' => date('Y-m-d H:i:s')],
                'id = :id',
                ['id' => $verification['id']]
            );

            echo $this->view('auth/verify-email', [
                'title' => 'Email Verification',
                'success' => true,
                'message' => 'Your email has been successfully verified! You can now log in to your account.'
            ]);

        } catch (\Exception $e) {
            error_log("Email verification error: " . $e->getMessage());
            echo $this->view('auth/verify-email', [
                'title' => 'Email Verification',
                'success' => false,
                'message' => 'An error occurred during verification. Please try again or contact support.'
            ]);
        }
    }

    /**
     * Check if user is authenticated
     */
    protected function isAuthenticated(): bool
    {
        return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
    }

    /**
     * Get current authenticated user
     */
    protected function getCurrentUser(): ?array
    {
        if (!$this->isAuthenticated()) {
            return null;
        }

        return User::findById($_SESSION['user_id']);
    }

    /**
     * Require authentication or redirect to login
     */
    protected function requireAuth(): void
    {
        if (!$this->isAuthenticated()) {
            $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
            header('Location: ' . url('/login'));
            exit;
        }
    }

    /**
     * Require specific role
     */
    protected function requireRole(string $role): void
    {
        $this->requireAuth();
        
        if ($_SESSION['user_role'] !== $role) {
            header('Location: ' . url('/'));
            exit;
        }
    }
}
