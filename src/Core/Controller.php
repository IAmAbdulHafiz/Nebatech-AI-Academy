<?php

namespace Nebatech\Core;

abstract class Controller
{
    /**
     * Render a view with the default layout
     */
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

    /**
     * Render a view with a specific layout based on user role
     */
    protected function render(string $view, array $data = [], ?string $layout = null): string
    {
        // Get current user and determine layout
        $user = $this->getCurrentUser();
        
        if ($layout === null && $user) {
            // Auto-detect layout based on user role
            $layout = match($user['role']) {
                'admin' => 'admin',
                'facilitator' => 'facilitator',
                'student' => 'student',
                default => 'main'
            };
        } else if ($layout === null) {
            $layout = 'main';
        }

        // Load the view content
        extract($data);
        ob_start();
        $viewFile = __DIR__ . '/../Views/' . str_replace('.', '/', $view) . '.php';
        
        if (file_exists($viewFile)) {
            require $viewFile;
        } else {
            throw new \Exception("View not found: {$view}");
        }
        
        $content = ob_get_clean();

        // Wrap in layout
        $data['content'] = $content;
        $data['user'] = $user;
        extract($data);
        
        ob_start();
        $layoutFile = __DIR__ . '/../Views/layouts/' . $layout . '.php';
        
        if (file_exists($layoutFile)) {
            require $layoutFile;
        } else {
            // Fallback to content without layout
            echo $content;
        }
        
        return ob_get_clean();
    }

    /**
     * Get the currently authenticated user
     */
    protected function getCurrentUser(): ?array
    {
        if (!isset($_SESSION['user_id'])) {
            return null;
        }

        // Get user from session or database
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }

        // Fetch from database if needed
        $db = \Nebatech\Core\Database::connect();
        $stmt = $db->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $_SESSION['user_id']]);
        $user = $stmt->fetch();

        if ($user) {
            $_SESSION['user'] = $user;
            return $user;
        }

        return null;
    }

    /**
     * Require authentication
     */
    protected function requireAuth(): void
    {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
            $this->redirect(url('/login'));
            exit;
        }
    }

    protected function json(array $data, int $statusCode = 200): string
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        return json_encode($data);
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
            throw new \Exception(json_encode($errors));
        }

        return $data;
    }
}
