<?php

namespace Nebatech\Repositories;

use Nebatech\Core\Database;

class UserRepository
{
    /**
     * Find user by ID
     */
    public function findById(int $id): ?array
    {
        $sql = "SELECT * FROM users WHERE id = :id LIMIT 1";
        return Database::fetch($sql, ['id' => $id]);
    }

    /**
     * Find user by email
     */
    public function findByEmail(string $email): ?array
    {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        return Database::fetch($sql, ['email' => $email]);
    }

    /**
     * Find user by UUID
     */
    public function findByUuid(string $uuid): ?array
    {
        $sql = "SELECT * FROM users WHERE uuid = :uuid LIMIT 1";
        return Database::fetch($sql, ['uuid' => $uuid]);
    }

    /**
     * Create new user
     */
    public function create(array $data): ?int
    {
        // Generate UUID if not provided
        if (!isset($data['uuid'])) {
            $data['uuid'] = $this->generateUuid();
        }

        // Hash password if provided
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_ARGON2ID);
        }

        // Set default role if not provided
        if (!isset($data['role'])) {
            $data['role'] = 'student';
        }

        try {
            return Database::insert('users', $data);
        } catch (\Exception $e) {
            error_log("User creation failed: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Update user
     */
    public function update(int $id, array $data): bool
    {
        // Remove fields that shouldn't be updated directly
        unset($data['id'], $data['uuid'], $data['created_at']);

        // Hash password if being updated
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_ARGON2ID);
        }

        if (empty($data)) {
            return false;
        }

        $result = Database::update('users', $data, 'id = :id', ['id' => $id]);
        return $result > 0;
    }

    /**
     * Delete user
     */
    public function delete(int $id): bool
    {
        $result = Database::delete('users', 'id = :id', ['id' => $id]);
        return $result > 0;
    }

    /**
     * Get all users with optional filters
     */
    public function getAll(array $filters = []): array
    {
        $sql = "SELECT id, uuid, email, first_name, last_name, role, avatar, status, created_at 
                FROM users WHERE 1=1";
        $params = [];

        if (!empty($filters['role'])) {
            $sql .= " AND role = :role";
            $params['role'] = $filters['role'];
        }

        if (!empty($filters['status'])) {
            $sql .= " AND status = :status";
            $params['status'] = $filters['status'];
        }

        if (!empty($filters['search'])) {
            $sql .= " AND (first_name LIKE :search OR last_name LIKE :search OR email LIKE :search)";
            $params['search'] = '%' . $filters['search'] . '%';
        }

        $sql .= " ORDER BY created_at DESC";

        if (!empty($filters['limit'])) {
            $sql .= " LIMIT " . (int)$filters['limit'];
            if (!empty($filters['offset'])) {
                $sql .= " OFFSET " . (int)$filters['offset'];
            }
        }

        return Database::fetchAll($sql, $params);
    }

    /**
     * Count users with optional filters
     */
    public function count(array $filters = []): int
    {
        $sql = "SELECT COUNT(*) as count FROM users WHERE 1=1";
        $params = [];

        if (!empty($filters['role'])) {
            $sql .= " AND role = :role";
            $params['role'] = $filters['role'];
        }

        if (!empty($filters['status'])) {
            $sql .= " AND status = :status";
            $params['status'] = $filters['status'];
        }

        $result = Database::fetch($sql, $params);
        return $result ? (int)$result['count'] : 0;
    }

    /**
     * Verify user email
     */
    public function verifyEmail(int $id): bool
    {
        $data = ['email_verified_at' => date('Y-m-d H:i:s')];
        $result = Database::update('users', $data, 'id = :id', ['id' => $id]);
        return $result > 0;
    }

    /**
     * Update user status
     */
    public function updateStatus(int $id, string $status): bool
    {
        $data = ['status' => $status];
        $result = Database::update('users', $data, 'id = :id', ['id' => $id]);
        return $result > 0;
    }

    /**
     * Generate UUID v4
     */
    private function generateUuid(): string
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}
