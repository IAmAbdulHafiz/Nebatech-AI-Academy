<?php

namespace Nebatech\Repositories;

use Nebatech\Core\Database;

class ApplicationRepository
{
    /**
     * Find application by ID
     */
    public function findById(int $id): ?array
    {
        $sql = "SELECT a.*, 
                       u.first_name, u.last_name, u.email,
                       r.first_name as reviewer_first_name,
                       r.last_name as reviewer_last_name
                FROM applications a
                LEFT JOIN users u ON a.user_id = u.id
                LEFT JOIN users r ON a.reviewed_by = r.id
                WHERE a.id = :id
                LIMIT 1";
        
        return Database::fetch($sql, ['id' => $id]);
    }

    /**
     * Find application by UUID
     */
    public function findByUuid(string $uuid): ?array
    {
        $sql = "SELECT a.*, 
                       u.first_name, u.last_name, u.email
                FROM applications a
                LEFT JOIN users u ON a.user_id = u.id
                WHERE a.uuid = :uuid
                LIMIT 1";
        
        return Database::fetch($sql, ['uuid' => $uuid]);
    }

    /**
     * Get all applications with filters
     */
    public function getAll(array $filters = []): array
    {
        $sql = "SELECT a.*, 
                       u.first_name, u.last_name, u.email,
                       r.first_name as reviewer_first_name,
                       r.last_name as reviewer_last_name
                FROM applications a
                LEFT JOIN users u ON a.user_id = u.id
                LEFT JOIN users r ON a.reviewed_by = r.id
                WHERE 1=1";
        
        $params = [];

        if (!empty($filters['status'])) {
            $sql .= " AND a.status = :status";
            $params['status'] = $filters['status'];
        }

        if (!empty($filters['program'])) {
            $sql .= " AND a.program = :program";
            $params['program'] = $filters['program'];
        }

        if (!empty($filters['user_id'])) {
            $sql .= " AND a.user_id = :user_id";
            $params['user_id'] = $filters['user_id'];
        }

        $sql .= " ORDER BY a.created_at DESC";

        if (!empty($filters['limit'])) {
            $sql .= " LIMIT " . (int)$filters['limit'];
        }

        return Database::fetchAll($sql, $params);
    }

    /**
     * Create new application
     */
    public function create(array $data): ?int
    {
        if (!isset($data['uuid'])) {
            $data['uuid'] = $this->generateUuid();
        }

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
     * Update application
     */
    public function update(int $id, array $data): bool
    {
        unset($data['id'], $data['uuid'], $data['created_at'], $data['user_id']);

        if (empty($data)) {
            return false;
        }

        $result = Database::update('applications', $data, 'id = :id', ['id' => $id]);
        return $result > 0;
    }

    /**
     * Approve application
     */
    public function approve(int $id, int $reviewerId, ?string $notes = null): bool
    {
        $data = [
            'status' => 'approved',
            'reviewed_by' => $reviewerId,
            'reviewed_at' => date('Y-m-d H:i:s')
        ];

        if ($notes) {
            $data['admin_notes'] = $notes;
        }

        return $this->update($id, $data);
    }

    /**
     * Reject application
     */
    public function reject(int $id, int $reviewerId, ?string $notes = null): bool
    {
        $data = [
            'status' => 'rejected',
            'reviewed_by' => $reviewerId,
            'reviewed_at' => date('Y-m-d H:i:s')
        ];

        if ($notes) {
            $data['admin_notes'] = $notes;
        }

        return $this->update($id, $data);
    }

    /**
     * Request more information
     */
    public function requestInfo(int $id, int $reviewerId, string $notes): bool
    {
        $data = [
            'status' => 'info_requested',
            'reviewed_by' => $reviewerId,
            'reviewed_at' => date('Y-m-d H:i:s'),
            'admin_notes' => $notes
        ];

        return $this->update($id, $data);
    }

    /**
     * Check if user has pending application
     */
    public function hasPendingApplication(int $userId, ?string $program = null): bool
    {
        $sql = "SELECT COUNT(*) as count FROM applications 
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
     * Get application statistics
     */
    public function getStats(): array
    {
        $sql = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                    SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) as approved,
                    SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected,
                    SUM(CASE WHEN status = 'info_requested' THEN 1 ELSE 0 END) as info_requested
                FROM applications";
        
        return Database::fetch($sql) ?? [
            'total' => 0,
            'pending' => 0,
            'approved' => 0,
            'rejected' => 0,
            'info_requested' => 0
        ];
    }

    /**
     * Delete application
     */
    public function delete(int $id): bool
    {
        $result = Database::delete('applications', 'id = :id', ['id' => $id]);
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
