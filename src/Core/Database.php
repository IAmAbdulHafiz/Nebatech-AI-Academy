<?php

namespace Nebatech\Core;

use PDO;
use PDOException;
use Nebatech\Exceptions\DatabaseConnectionException;

class Database
{
    private static ?PDO $connection = null;
    private static array $allowedTables = [
        'users', 'courses', 'modules', 'lessons', 'enrollments',
        'assignments', 'submissions', 'applications', 'cohorts',
        'portfolios', 'certificates', 'notifications', 'progress',
        'cohort_assignments', 'cohort_courses', 'cohort_schedules', 
        'cohort_assignment_deadlines', 'course_approvals', 'contacts',
        'activity_logs', 'email_logs', 'email_verifications', 'remember_tokens',
        'learning_goals', 'learning_streaks', 'lesson_progress', 'study_sessions',
        'user_preferences', 'approval_history', 'cohort_invitations',
        'services', 'projects', 'blog_posts', 'testimonials', 'service_requests', 'contact_messages',
        'service_categories', 'cross_promotions', 'course_categories'
    ];

    public static function connect(): PDO
    {
        if (self::$connection === null) {
            try {
                $config = require __DIR__ . '/../../config/database.php';
                
                $dsn = sprintf(
                    'mysql:host=%s;port=%d;dbname=%s;charset=%s',
                    $config['host'],
                    $config['port'],
                    $config['database'],
                    $config['charset']
                );

                self::$connection = new PDO(
                    $dsn,
                    $config['username'],
                    $config['password'],
                    $config['options']
                );
            } catch (PDOException $e) {
                // Log the actual error
                error_log('Database connection failed: ' . $e->getMessage());
                
                // Throw sanitized error based on environment
                $isDebug = ($_ENV['APP_DEBUG'] ?? 'false') === 'true';
                $message = $isDebug 
                    ? 'Database connection failed: ' . $e->getMessage()
                    : 'Database connection unavailable';
                    
                throw new DatabaseConnectionException($message, 0, $e);
            }
        }

        return self::$connection;
    }

    public static function query(string $sql, array $params = []): \PDOStatement
    {
        $pdo = self::connect();
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public static function fetch(string $sql, array $params = []): ?array
    {
        $stmt = self::query($sql, $params);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public static function fetchAll(string $sql, array $params = []): array
    {
        $stmt = self::query($sql, $params);
        return $stmt->fetchAll();
    }

    public static function insert(string $table, array $data): int
    {
        self::validateTableName($table);
        
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        
        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
        self::query($sql, $data);
        
        return (int) self::connect()->lastInsertId();
    }

    public static function update(string $table, array $data, string $where, array $whereParams = []): int
    {
        self::validateTableName($table);
        
        $sets = [];
        foreach (array_keys($data) as $column) {
            $sets[] = "{$column} = :{$column}";
        }
        $setString = implode(', ', $sets);
        
        $sql = "UPDATE {$table} SET {$setString} WHERE {$where}";
        $stmt = self::query($sql, array_merge($data, $whereParams));
        
        return $stmt->rowCount();
    }

    public static function delete(string $table, string $where, array $params = []): int
    {
        self::validateTableName($table);
        
        $sql = "DELETE FROM {$table} WHERE {$where}";
        $stmt = self::query($sql, $params);
        return $stmt->rowCount();
    }

    public static function beginTransaction(): bool
    {
        return self::connect()->beginTransaction();
    }

    public static function commit(): bool
    {
        return self::connect()->commit();
    }

    public static function rollback(): bool
    {
        return self::connect()->rollBack();
    }

    /**
     * Validate table name against whitelist
     */
    protected static function validateTableName(string $table): void
    {
        if (!in_array($table, self::$allowedTables)) {
            error_log('Invalid table name attempted: ' . $table);
            throw new \InvalidArgumentException('Invalid table name');
        }
    }
}
