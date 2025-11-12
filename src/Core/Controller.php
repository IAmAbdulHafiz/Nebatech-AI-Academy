<?php

namespace Nebatech\Core;

use Nebatech\Exceptions\ValidationException;
use Nebatech\Exceptions\AuthenticationException;
use Nebatech\Exceptions\AuthorizationException;

abstract class Controller
{
    public function __construct()
    {
        // Base constructor - can be extended by child classes
    }
    
    protected function view(string $view, array $data = []): string
    {
        extract($data);
        
        ob_start();
        $viewFile = __DIR__ . '/../Views/' . str_replace('.', '/', $view) . '.php';
        
        if (file_exists($viewFile)) {
            require $viewFile;
        } else {
            throw new \Exception("View not found: {$view}");
        }
        
        return ob_get_clean();
    }

    protected function json(array $data, int $statusCode = 200): string
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        return json_encode($data);
    }

    protected function jsonResponse(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    protected function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }

    protected function back(): void
    {
        $referer = $_SERVER['HTTP_REFERER'] ?? '/';
        $this->redirect($referer);
    }

    protected function request(string $key = null, $default = null)
    {
        if ($key === null) {
            return $_REQUEST;
        }
        return $_REQUEST[$key] ?? $default;
    }

    protected function input(string $key = null, $default = null)
    {
        $data = json_decode(file_get_contents('php://input'), true) ?? [];
        
        if ($key === null) {
            return array_merge($_REQUEST, $data);
        }
        
        return $data[$key] ?? $_REQUEST[$key] ?? $default;
    }

    protected function validate(array $rules): array
    {
        $data = $this->input();
        $errors = [];

        foreach ($rules as $field => $ruleSet) {
            $rulesArray = explode('|', $ruleSet);
            
            foreach ($rulesArray as $rule) {
                if ($rule === 'required' && empty($data[$field])) {
                    $errors[$field][] = ucfirst($field) . ' is required';
                }
                
                if (str_starts_with($rule, 'min:')) {
                    $min = (int) substr($rule, 4);
                    if (strlen($data[$field] ?? '') < $min) {
                        $errors[$field][] = ucfirst($field) . " must be at least {$min} characters";
                    }
                }
                
                if (str_starts_with($rule, 'max:')) {
                    $max = (int) substr($rule, 4);
                    if (strlen($data[$field] ?? '') > $max) {
                        $errors[$field][] = ucfirst($field) . " must not exceed {$max} characters";
                    }
                }
                
                if ($rule === 'email' && !empty($data[$field]) && !filter_var($data[$field], FILTER_VALIDATE_EMAIL)) {
                    $errors[$field][] = ucfirst($field) . ' must be a valid email';
                }
            }
        }

        if (!empty($errors)) {
            throw new ValidationException($errors);
        }

        return $data;
    }

    protected function requireAuth(): void
    {
        if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
            $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
            throw new AuthenticationException();
        }
    }

    protected function requireRole(string $role): void
    {
        $this->requireAuth();
        
        $user = $_SESSION['user_data'] ?? null;
        if (!$user || $user['role'] !== $role) {
            // Allow admin to access facilitator routes
            if ($role === 'facilitator' && $user && $user['role'] === 'admin') {
                return;
            }
            
            throw new AuthorizationException();
        }
    }

    protected function getCurrentUser(): ?array
    {
        if (!isset($_SESSION['user_id'])) {
            return null;
        }

        return $_SESSION['user_data'] ?? null;
    }
}
