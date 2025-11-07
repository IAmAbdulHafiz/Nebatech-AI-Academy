<?php

namespace Nebatech\Core;

class Router
{
    private array $routes = [];
    private array $middlewares = [];

    public function get(string $path, callable|array $handler, array $middleware = []): void
    {
        $this->addRoute('GET', $path, $handler, $middleware);
    }

    public function post(string $path, callable|array $handler, array $middleware = []): void
    {
        $this->addRoute('POST', $path, $handler, $middleware);
    }

    public function put(string $path, callable|array $handler, array $middleware = []): void
    {
        $this->addRoute('PUT', $path, $handler, $middleware);
    }

    public function delete(string $path, callable|array $handler, array $middleware = []): void
    {
        $this->addRoute('DELETE', $path, $handler, $middleware);
    }

    private function addRoute(string $method, string $path, callable|array $handler, array $middleware = []): void
    {
        $pattern = $this->convertPathToRegex($path);
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'pattern' => $pattern,
            'handler' => $handler,
            'middleware' => $middleware,
        ];
    }

    private function convertPathToRegex(string $path): string
    {
        // Convert route parameters like {id} to regex patterns
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $path);
        return '#^' . $pattern . '$#';
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // Remove the base path from the URI
        $scriptName = $_SERVER['SCRIPT_NAME']; // e.g., /Nebatech-AI-Academy/public/index.php
        $scriptDir = dirname($scriptName); // e.g., /Nebatech-AI-Academy/public
        
        // Get the application base (one level up from public)
        $baseParts = explode('/', trim($scriptDir, '/'));
        array_pop($baseParts); // Remove 'public'
        $appBase = '/' . implode('/', $baseParts); // e.g., /Nebatech-AI-Academy
        
        // Strip the application base from the request URI
        $uri = $requestUri;
        if ($appBase !== '/' && $appBase !== '' && strpos($uri, $appBase) === 0) {
            $uri = substr($uri, strlen($appBase));
        }
        
        // Ensure the URI starts with /
        if (empty($uri) || $uri[0] !== '/') {
            $uri = '/' . $uri;
        }
        
        // Remove trailing slash (except for root)
        if ($uri !== '/' && substr($uri, -1) === '/') {
            $uri = rtrim($uri, '/');
        }

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && preg_match($route['pattern'], $uri, $matches)) {
                // Extract route parameters
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                // Run middleware
                foreach ($route['middleware'] as $middlewareClass) {
                    $middleware = new $middlewareClass();
                    $middleware->handle();
                }

                // Call handler
                if (is_array($route['handler'])) {
                    [$controller, $method] = $route['handler'];
                    $controllerInstance = new $controller();
                    echo $controllerInstance->$method($params);
                } else {
                    echo $route['handler']($params);
                }
                return;
            }
        }

        // 404 Not Found
        http_response_code(404);
        echo json_encode(['error' => 'Route not found']);
    }

    public function group(array $attributes, callable $callback): void
    {
        $callback($this);
    }
}
