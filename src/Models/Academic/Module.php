<?php

namespace Nebatech\Models\Academic;

use Nebatech\Core\Model;
use Nebatech\Core\Database;

class Module extends Model
{
    protected string $table = 'modules';
    protected string $primaryKey = 'id';

    /**
     * Create a new module
     */
    public static function create(array $data): ?int
    {
        // Generate UUID if not provided
        if (!isset($data['uuid'])) {
            $data['uuid'] = self::generateUuid();
        }

        // Set default status if not provided
        if (!isset($data['status'])) {
            $data['status'] = 'draft';
        }

        // Set default order_index if not provided
        if (!isset($data['order_index'])) {
            $data['order_index'] = self::getNextOrderIndex($data['course_id']);
        }

        try {
            return Database::insert('modules', $data);
        } catch (\Exception $e) {
            error_log("Module creation failed: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get modules by course
     */
    public static function getByCourse(int $courseId, ?string $status = null): array
    {
        $sql = "SELECT * FROM " . 'modules' . " WHERE course_id = :course_id";
        $params = ['course_id' => $courseId];

        if ($status) {
            $sql .= " AND status = :status";
            $params['status'] = $status;
        }

        $sql .= " ORDER BY order_index ASC";

        return Database::fetchAll($sql, $params);
    }

    /**
     * Get module by ID with lessons count
     */
    public static function findById(int $id): ?array
    {
        $sql = "SELECT m.*, 
                       (SELECT COUNT(*) FROM lessons WHERE module_id = m.id) as lessons_count
                FROM " . 'modules' . " m
                WHERE m.id = :id
                LIMIT 1";
        
        return Database::fetch($sql, ['id' => $id]);
    }

    /**
     * Update module
     */
    public static function updateById(int $moduleId, array $data): bool
    {
        unset($data['id'], $data['uuid'], $data['created_at'], $data['course_id']);

        if (empty($data)) {
            return false;
        }

        $result = Database::update(
            'modules',
            $data,
            'id = :id',
            ['id' => $moduleId]
        );

        return $result > 0;
    }

    /**
     * Delete module
     */
    public static function deleteById(int $moduleId): bool
    {
        $result = Database::delete('modules', 'id = :id', ['id' => $moduleId]);
        return $result > 0;
    }

    /**
     * Reorder modules
     */
    public static function reorder(int $courseId, array $moduleIds): bool
    {
        Database::beginTransaction();

        try {
            foreach ($moduleIds as $index => $moduleId) {
                Database::update(
                    'modules',
                    ['order_index' => $index],
                    'id = :id AND course_id = :course_id',
                    ['id' => $moduleId, 'course_id' => $courseId]
                );
            }

            Database::commit();
            return true;
        } catch (\Exception $e) {
            Database::rollback();
            error_log("Module reordering failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get next order index for a course
     */
    protected static function getNextOrderIndex(int $courseId): int
    {
        $sql = "SELECT MAX(order_index) as max_index FROM " . 'modules' . " 
                WHERE course_id = :course_id";
        
        $result = Database::fetch($sql, ['course_id' => $courseId]);
        return $result && $result['max_index'] !== null ? (int)$result['max_index'] + 1 : 0;
    }

    /**
     * Publish module
     */
    public static function publish(int $moduleId): bool
    {
        return self::updateById($moduleId, ['status' => 'published']);
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
