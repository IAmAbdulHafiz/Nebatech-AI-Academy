<?php

namespace Nebatech\Controllers;

use Nebatech\Core\Controller;
use Nebatech\Models\User;
use Nebatech\Services\EmailService;

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

        // Handle remember me
        if ($remember) {
            $token = bin2hex(random_bytes(32));
            setcookie('remember_token', $token, time() + (86400 * 30), '/', '', true, true); // 30 days
            // TODO: Store token in database for verification
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
        $emailService = new EmailService();
        $user = User::findById($userId);
        if ($user) {
            $emailService->queueEmail('welcome', $user, ['user' => $user]);
        }

        // Set success message
        $_SESSION['success'] = 'Registration successful! Please log in.';
        
        header('Location: ' . url('/login'));
        exit;
    }

    public function logout()
    {
        // Clear session
        $_SESSION = [];
        
        // Destroy session cookie
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 42000, '/');
        }
        
        // Clear remember me cookie
        if (isset($_COOKIE['remember_token'])) {
            setcookie('remember_token', '', time() - 42000, '/', '', true, true);
        }
        
        // Destroy session
        session_destroy();
        
        header('Location: ' . url('/'));
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
