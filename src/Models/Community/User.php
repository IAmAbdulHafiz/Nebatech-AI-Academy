<?php

namespace Nebatech\Models\Community;

use Nebatech\Core\Model;
use Nebatech\Core\Database;

class User extends Model
{
    protected string $table = 'users';
    protected string $primaryKey = 'id';

    /**
     * Find user by email
     */
    public static function findByEmail(string $email): ?array
    {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        return Database::fetch($sql, ['email' => $email]);
    }

    /**
     * Find user by UUID
     */
    public static function findByUuid(string $uuid): ?array
    {
        $sql = "SELECT * FROM users WHERE uuid = :uuid LIMIT 1";
        return Database::fetch($sql, ['uuid' => $uuid]);
    }

    /**
     * Create a new user
     */
    public static function create(array $data): ?int
    {
        // Generate UUID if not provided
        if (!isset($data['uuid'])) {
            $data['uuid'] = self::generateUuid();
        }

        // Hash password if provided
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT, ['cost' => 12]);
        }

        // Set default role if not provided
        if (!isset($data['role'])) {
            $data['role'] = 'student';
        }

        // Set default status if not provided
        if (!isset($data['status'])) {
            $data['status'] = 'active';
        }

        try {
            return Database::insert('users', $data);
        } catch (\Exception $e) {
            error_log("User creation failed: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Verify user password
     */
    public static function verifyPassword(string $password, string $hashedPassword): bool
    {
        return password_verify($password, $hashedPassword);
    }

    /**
     * Update user password
     */
    public static function updatePassword(int $userId, string $newPassword): bool
    {
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT, ['cost' => 12]);
        
        $result = Database::update(
            'users',
            ['password' => $hashedPassword],
            'id = :id',
            ['id' => $userId]
        );

        return $result > 0;
    }

    /**
     * Update user details
     */
    public static function updateUser(int $userId, array $data): bool
    {
        // Remove sensitive fields that shouldn't be updated directly
        unset($data['id'], $data['uuid'], $data['password'], $data['created_at']);

        if (empty($data)) {
            return false;
        }

        $result = Database::update(
            'users',
            $data,
            'id = :id',
            ['id' => $userId]
        );

        return $result > 0;
    }

    /**
     * Mark email as verified
     */
    public static function verifyEmail(int $userId): bool
    {
        $result = Database::update(
            'users',
            ['email_verified_at' => date('Y-m-d H:i:s')],
            'id = :id',
            ['id' => $userId]
        );

        return $result > 0;
    }

    /**
     * Check if email exists
     */
    public static function emailExists(string $email): bool
    {
        $sql = "SELECT COUNT(*) as count FROM users WHERE email = :email";
        $result = Database::fetch($sql, ['email' => $email]);
        return $result && $result['count'] > 0;
    }

    /**
     * Get user by ID with all details
     */
    public static function findById(int $id): ?array
    {
        $sql = "SELECT * FROM users WHERE id = :id LIMIT 1";
        return Database::fetch($sql, ['id' => $id]);
    }

    /**
     * Get all users with optional filters
     */
    public static function getAll(array $filters = []): array
    {
        $sql = "SELECT * FROM users";
        $params = [];
        $conditions = [];

        if (!empty($filters['role'])) {
            $conditions[] = "role = :role";
            $params['role'] = $filters['role'];
        }

        if (!empty($filters['status'])) {
            $conditions[] = "status = :status";
            $params['status'] = $filters['status'];
        }

        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(' AND ', $conditions);
        }

        $sql .= " ORDER BY created_at DESC";

        if (!empty($filters['limit'])) {
            $sql .= " LIMIT " . (int)$filters['limit'];
        }

        return Database::fetchAll($sql, $params);
    }

    /**
     * Update user status
     */
    public static function updateStatus(int $userId, string $status): bool
    {
        $validStatuses = ['active', 'inactive', 'suspended'];
        
        if (!in_array($status, $validStatuses)) {
            return false;
        }

        $result = Database::update(
            'users',
            ['status' => $status],
            'id = :id',
            ['id' => $userId]
        );

        return $result > 0;
    }

    /**
     * Get user stats
     */
    public static function getStats(): array
    {
        $sql = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN role = 'student' THEN 1 ELSE 0 END) as students,
                    SUM(CASE WHEN role = 'facilitator' THEN 1 ELSE 0 END) as facilitators,
                    SUM(CASE WHEN role = 'admin' THEN 1 ELSE 0 END) as admins,
                    SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active,
                    SUM(CASE WHEN status = 'inactive' THEN 1 ELSE 0 END) as inactive
                FROM users";
        
        return Database::fetch($sql) ?? [
            'total' => 0,
            'students' => 0,
            'facilitators' => 0,
            'admins' => 0,
            'active' => 0,
            'inactive' => 0
        ];
    }

    /**
     * Generate UUID v4
     */
    protected static function generateUuid(): string
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
        
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    /**
     * Delete user (soft delete by setting status to inactive)
     */
    public static function softDelete(int $userId): bool
    {
        return self::updateStatus($userId, 'inactive');
    }

    /**
     * Permanently delete user
     */
    public static function hardDelete(int $userId): bool
    {
        $result = Database::delete('users', 'id = :id', ['id' => $userId]);
        return $result > 0;
    }
}
