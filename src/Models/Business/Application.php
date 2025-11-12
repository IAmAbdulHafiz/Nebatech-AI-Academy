<?php

namespace Nebatech\Models\Business;

use Nebatech\Core\Model;
use Nebatech\Core\Database;

class Application extends Model
{
    protected string $table = 'applications';
    protected string $primaryKey = 'id';

    /**
     * Create a new application
     */
    public static function create(array $data): ?int
    {
        // Generate UUID if not provided
        if (!isset($data['uuid'])) {
            $data['uuid'] = self::generateUuid();
        }

        // Set default status if not provided
        if (!isset($data['status'])) {
            $data['status'] = 'pending';
        }

        try {
            return Database::insert('applications', $data);
        } catch (\Exception $e) {
            error_log("Application creation failed: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get all applications with optional filters
     */
    public static function getAll(array $filters = []): array
    {
        $sql = "SELECT a.*, 
                       u.first_name,
                       u.last_name,
                       u.email,
                       u.phone,
                       r.first_name as reviewer_first_name,
                       r.last_name as reviewer_last_name
                FROM " . 'applications' . " a
                LEFT JOIN users u ON a.user_id = u.id
                LEFT JOIN users r ON a.reviewed_by = r.id";
        
        $params = [];
        $conditions = [];

        if (!empty($filters['status'])) {
            $conditions[] = "a.status = :status";
            $params['status'] = $filters['status'];
        }

        if (!empty($filters['program'])) {
            $conditions[] = "a.program = :program";
            $params['program'] = $filters['program'];
        }

        if (!empty($filters['user_id'])) {
            $conditions[] = "a.user_id = :user_id";
            $params['user_id'] = $filters['user_id'];
        }

        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(' AND ', $conditions);
        }

        $sql .= " ORDER BY a.created_at DESC";

        if (!empty($filters['limit'])) {
            $sql .= " LIMIT " . (int)$filters['limit'];
        }

        return Database::fetchAll($sql, $params);
    }

    /**
     * Get application by ID
     */
    public static function findById(int $id): ?array
    {
        $sql = "SELECT a.*, 
                       u.first_name,
                       u.last_name,
                       u.email,
                       u.phone,
                       u.location,
                       r.first_name as reviewer_first_name,
                       r.last_name as reviewer_last_name
                FROM " . 'applications' . " a
                LEFT JOIN users u ON a.user_id = u.id
                LEFT JOIN users r ON a.reviewed_by = r.id
                WHERE a.id = :id
                LIMIT 1";
        
        return Database::fetch($sql, ['id' => $id]);
    }

    /**
     * Get application by UUID
     */
    public static function findByUuid(string $uuid): ?array
    {
        $sql = "SELECT a.*, 
                       u.first_name,
                       u.last_name,
                       u.email
                FROM " . 'applications' . " a
                LEFT JOIN users u ON a.user_id = u.id
                WHERE a.uuid = :uuid
                LIMIT 1";
        
        return Database::fetch($sql, ['uuid' => $uuid]);
    }

    /**
     * Get user's applications
     */
    public static function getUserApplications(int $userId): array
    {
        return self::getAll(['user_id' => $userId]);
    }

    /**
     * Check if user has pending application
     */
    public static function hasPendingApplication(int $userId, ?string $program = null): bool
    {
        $sql = "SELECT COUNT(*) as count FROM " . 'applications' . " 
                WHERE user_id = :user_id AND status = 'pending'";
        
        $params = ['user_id' => $userId];

        if ($program) {
            $sql .= " AND program = :program";
            $params['program'] = $program;
        }

        $result = Database::fetch($sql, $params);
        return $result && $result['count'] > 0;
    }

    /**
     * Approve application
     */
    public static function approve(int $applicationId, int $reviewerId, ?string $notes = null): bool
    {
        $data = [
            'status' => 'approved',
            'reviewed_by' => $reviewerId,
            'reviewed_at' => date('Y-m-d H:i:s')
        ];

        if ($notes) {
            $data['admin_notes'] = $notes;
        }

        $result = Database::update(
            'applications',
            $data,
            'id = :id',
            ['id' => $applicationId]
        );

        return $result > 0;
    }

    /**
     * Reject application
     */
    public static function reject(int $applicationId, int $reviewerId, ?string $notes = null): bool
    {
        $data = [
            'status' => 'rejected',
            'reviewed_by' => $reviewerId,
            'reviewed_at' => date('Y-m-d H:i:s')
        ];

        if ($notes) {
            $data['admin_notes'] = $notes;
        }

        $result = Database::update(
            'applications',
            $data,
            'id = :id',
            ['id' => $applicationId]
        );

        return $result > 0;
    }

    /**
     * Request more information
     */
    public static function requestInfo(int $applicationId, int $reviewerId, string $notes): bool
    {
        $data = [
            'status' => 'info_requested',
            'reviewed_by' => $reviewerId,
            'reviewed_at' => date('Y-m-d H:i:s'),
            'admin_notes' => $notes
        ];

        $result = Database::update(
            'applications',
            $data,
            'id = :id',
            ['id' => $applicationId]
        );

        return $result > 0;
    }

    /**
     * Update application
     */
    public static function updateById(int $applicationId, array $data): bool
    {
        // Remove fields that shouldn't be updated directly
        unset($data['id'], $data['uuid'], $data['created_at'], $data['user_id']);

        if (empty($data)) {
            return false;
        }

        $result = Database::update(
            'applications',
            $data,
            'id = :id',
            ['id' => $applicationId]
        );

        return $result > 0;
    }

    /**
     * Update application by UUID
     */
    public static function updateByUuid(string $uuid, array $data): bool
    {
        // Remove fields that shouldn't be updated directly
        unset($data['id'], $data['uuid'], $data['created_at'], $data['user_id']);

        if (empty($data)) {
            return false;
        }

        $result = Database::update(
            'applications',
            $data,
            'uuid = :uuid',
            ['uuid' => $uuid]
        );

        return $result > 0;
    }

    /**
     * Get application statistics
     */
    public static function getStats(): array
    {
        $sql = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                    SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) as approved,
                    SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected,
                    SUM(CASE WHEN status = 'info_requested' THEN 1 ELSE 0 END) as info_requested
                FROM " . 'applications';
        
        return Database::fetch($sql) ?? [
            'total' => 0,
            'pending' => 0,
            'approved' => 0,
            'rejected' => 0,
            'info_requested' => 0
        ];
    }

    /**
     * Get applications by program
     */
    public static function getByProgram(string $program, ?string $status = null): array
    {
        $filters = ['program' => $program];
        
        if ($status) {
            $filters['status'] = $status;
        }

        return self::getAll($filters);
    }

    /**
     * Delete application
     */
    public static function deleteById(int $applicationId): bool
    {
        $result = Database::delete('applications', 'id = :id', ['id' => $applicationId]);
        return $result > 0;
    }

    /**
     * Generate UUID v4
     */
    protected static function generateUuid(): string
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}
