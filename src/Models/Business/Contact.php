<?php

namespace Nebatech\Models\Business;

use Nebatech\Core\Model;
use Nebatech\Core\Database;

class Contact extends Model
{
    protected string $table = 'contacts';
    protected string $primaryKey = 'id';

    /**
     * Create a new contact submission
     */
    public static function create(array $data): ?int
    {
        // Generate UUID if not provided
        if (!isset($data['uuid'])) {
            $data['uuid'] = self::generateUuid();
        }

        // Set default status if not provided
        if (!isset($data['status'])) {
            $data['status'] = 'new';
        }

        // Capture IP address and user agent if not provided
        if (!isset($data['ip_address'])) {
            $data['ip_address'] = $_SERVER['REMOTE_ADDR'] ?? null;
        }

        if (!isset($data['user_agent'])) {
            $data['user_agent'] = $_SERVER['HTTP_USER_AGENT'] ?? null;
        }

        try {
            return Database::insert('contacts', $data);
        } catch (\Exception $e) {
            error_log("Contact creation failed: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get all contacts with optional filters
     */
    public static function getAll(array $filters = []): array
    {
        $sql = "SELECT * FROM contacts";
        $params = [];
        $conditions = [];

        if (!empty($filters['status'])) {
            $conditions[] = "status = :status";
            $params['status'] = $filters['status'];
        }

        if (!empty($filters['email'])) {
            $conditions[] = "email = :email";
            $params['email'] = $filters['email'];
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
     * Find contact by ID
     */
    public static function findById(int $id): ?array
    {
        $sql = "SELECT * FROM contacts WHERE id = :id LIMIT 1";
        return Database::fetch($sql, ['id' => $id]);
    }

    /**
     * Find contact by UUID
     */
    public static function findByUuid(string $uuid): ?array
    {
        $sql = "SELECT * FROM contacts WHERE uuid = :uuid LIMIT 1";
        return Database::fetch($sql, ['uuid' => $uuid]);
    }

    /**
     * Update contact status
     */
    public static function updateStatus(int $id, string $status): bool
    {
        $validStatuses = ['new', 'read', 'replied', 'archived'];
        
        if (!in_array($status, $validStatuses)) {
            return false;
        }

        $result = Database::update(
            'contacts',
            ['status' => $status],
            'id = :id',
            ['id' => $id]
        );

        return $result > 0;
    }

    /**
     * Mark as replied
     */
    public static function markAsReplied(int $id, int $repliedBy): bool
    {
        $result = Database::update(
            'contacts',
            [
                'status' => 'replied',
                'replied_at' => date('Y-m-d H:i:s'),
                'replied_by' => $repliedBy
            ],
            'id = :id',
            ['id' => $id]
        );

        return $result > 0;
    }

    /**
     * Get contact statistics
     */
    public static function getStats(): array
    {
        $sql = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN status = 'new' THEN 1 ELSE 0 END) as new,
                    SUM(CASE WHEN status = 'read' THEN 1 ELSE 0 END) as read,
                    SUM(CASE WHEN status = 'replied' THEN 1 ELSE 0 END) as replied,
                    SUM(CASE WHEN status = 'archived' THEN 1 ELSE 0 END) as archived
                FROM contacts";
        
        return Database::fetch($sql) ?? [
            'total' => 0,
            'new' => 0,
            'read' => 0,
            'replied' => 0,
            'archived' => 0
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
     * Delete contact
     */
    public static function deleteById(int $id): bool
    {
        $result = Database::delete('contacts', 'id = :id', ['id' => $id]);
        return $result > 0;
    }
}
