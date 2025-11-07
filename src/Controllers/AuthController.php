<?php

namespace Nebatech\Controllers;

use Nebatech\Core\Controller;

class AuthController extends Controller
{
    public function showLogin()
    {
        echo $this->view('auth.login', [
            'title' => 'Login'
        ]);
    }

    public function showRegister()
    {
        echo $this->view('auth.register', [
            'title' => 'Register'
        ]);
    }

    public function login()
    {
        // Handle login POST request
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // TODO: Implement login logic
            // For now, redirect to dashboard
            header('Location: ' . url('/dashboard'));
            exit;
        }
    }

    public function register()
    {
        // Handle registration POST request
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // TODO: Implement registration logic
            // For now, redirect to login
            header('Location: ' . url('/login'));
            exit;
        }
    }

    public function logout()
    {
        // TODO: Implement logout logic
        // Clear session, cookies, etc.
        header('Location: ' . url('/'));
        exit;
    }

    public function forgotPassword()
    {
        $this->view('auth.forgot-password', [
            'title' => 'Forgot Password'
        ]);
    }

    public function resetPassword()
    {
        $this->view('auth.reset-password', [
            'title' => 'Reset Password'
        ]);
    }
}
