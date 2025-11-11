<?php

namespace Nebatech\Middleware;

use Nebatech\Core\Middleware;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\RotatingFileHandler;

class LoggingMiddleware extends Middleware
{
    protected Logger $logger;

    public function __construct()
    {
        $this->logger = new Logger('app');
        
        // Log to daily rotating files
        $logPath = __DIR__ . '/../../storage/logs/app.log';
        $this->logger->pushHandler(
            new RotatingFileHandler($logPath, 30, Logger::INFO)
        );
    }

    public function handle(): void
    {
        $startTime = microtime(true);
        
        // Log request
        $this->logger->info('Request received', [
            'method' => $_SERVER['REQUEST_METHOD'] ?? 'UNKNOWN',
            'uri' => $_SERVER['REQUEST_URI'] ?? '/',
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
            'user_id' => $_SESSION['user_id'] ?? null,
        ]);

        // Register shutdown function to log response time
        register_shutdown_function(function () use ($startTime) {
            $executionTime = microtime(true) - $startTime;
            $this->logger->info('Request completed', [
                'execution_time' => round($executionTime * 1000, 2) . 'ms',
                'memory_usage' => round(memory_get_peak_usage() / 1024 / 1024, 2) . 'MB',
            ]);
        });
    }
}
