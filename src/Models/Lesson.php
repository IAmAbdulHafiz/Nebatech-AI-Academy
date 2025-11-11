<?php

namespace Nebatech\Models;

use Nebatech\Core\Model;
use Nebatech\Core\Database;

class Lesson extends Model
{
    protected string $table = 'lessons';
    protected string $primaryKey = 'id';

    /**
     * Create a new lesson
     */
    public static function create(array $data): ?int
    {
        // Generate UUID if not provided
        if (!isset($data['uuid'])) {
            $data['uuid'] = self::generateUuid();
        }

        // Set default type if not provided
        if (!isset($data['type'])) {
            $data['type'] = 'text';
        }

        // Set default order_index if not provided
        if (!isset($data['order_index'])) {
            $data['order_index'] = self::getNextOrderIndex($data['module_id']);
        }

        // Encode resources as JSON if it's an array
        if (isset($data['resources']) && is_array($data['resources'])) {
            $data['resources'] = json_encode($data['resources']);
        }

        try {
            return Database::insert('lessons', $data);
        } catch (\Exception $e) {
            error_log("Lesson creation failed: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get lessons by module
     */
    public static function getByModule(int $moduleId): array
    {
        $sql = "SELECT * FROM " . 'lessons' . " 
                WHERE module_id = :module_id 
                ORDER BY order_index ASC";
        
        $lessons = Database::fetchAll($sql, ['module_id' => $moduleId]);

        // Decode JSON resources
        foreach ($lessons as &$lesson) {
            if ($lesson['resources']) {
                $lesson['resources'] = json_decode($lesson['resources'], true);
            }
        }

        return $lessons;
    }

    /**
     * Get lesson by ID
     */
    public static function findById(int $id): ?array
    {
        $sql = "SELECT l.*, 
                       m.title as module_title,
                       m.course_id,
                       c.title as course_title
                FROM " . 'lessons' . " l
                INNER JOIN modules m ON l.module_id = m.id
                INNER JOIN courses c ON m.course_id = c.id
                WHERE l.id = :id
                LIMIT 1";
        
        $lesson = Database::fetch($sql, ['id' => $id]);

        if ($lesson && $lesson['resources']) {
            $lesson['resources'] = json_decode($lesson['resources'], true);
        }

        return $lesson;
    }

    /**
     * Update lesson
     */
    public static function updateById(int $lessonId, array $data): bool
    {
        unset($data['id'], $data['uuid'], $data['created_at'], $data['module_id']);

        // Encode resources as JSON if it's an array
        if (isset($data['resources']) && is_array($data['resources'])) {
            $data['resources'] = json_encode($data['resources']);
        }

        if (empty($data)) {
            return false;
        }

        $result = Database::update(
            'lessons',
            $data,
            'id = :id',
            ['id' => $lessonId]
        );

        return $result > 0;
    }

    /**
     * Delete lesson
     */
    public static function deleteById(int $lessonId): bool
    {
        $result = Database::delete('lessons', 'id = :id', ['id' => $lessonId]);
        return $result > 0;
    }

    /**
     * Reorder lessons
     */
    public static function reorder(int $moduleId, array $lessonIds): bool
    {
        Database::beginTransaction();

        try {
            foreach ($lessonIds as $index => $lessonId) {
                Database::update(
                    'lessons',
                    ['order_index' => $index],
                    'id = :id AND module_id = :module_id',
                    ['id' => $lessonId, 'module_id' => $moduleId]
                );
            }

            Database::commit();
            return true;
        } catch (\Exception $e) {
            Database::rollback();
            error_log("Lesson reordering failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get next order index for a module
     */
    protected static function getNextOrderIndex(int $moduleId): int
    {
        $sql = "SELECT MAX(order_index) as max_index FROM " . 'lessons' . " 
                WHERE module_id = :module_id";
        
        $result = Database::fetch($sql, ['module_id' => $moduleId]);
        return $result && $result['max_index'] !== null ? (int)$result['max_index'] + 1 : 0;
    }

    /**
     * Get lessons by type
     */
    public static function getByType(int $moduleId, string $type): array
    {
        $sql = "SELECT * FROM " . 'lessons' . " 
                WHERE module_id = :module_id AND type = :type 
                ORDER BY order_index ASC";
        
        return Database::fetchAll($sql, [
            'module_id' => $moduleId,
            'type' => $type
        ]);
    }

    /**
     * Get AI-generated lessons
     */
    public static function getAIGenerated(int $moduleId): array
    {
        $sql = "SELECT * FROM " . 'lessons' . " 
                WHERE module_id = :module_id AND ai_generated = TRUE 
                ORDER BY order_index ASC";
        
        return Database::fetchAll($sql, ['module_id' => $moduleId]);
    }

    /**
     * Get lesson count by module
     */
    public static function getCountByModule(int $moduleId): int
    {
        $sql = "SELECT COUNT(*) as count FROM " . 'lessons' . " 
                WHERE module_id = :module_id";
        
        $result = Database::fetch($sql, ['module_id' => $moduleId]);
        return $result ? (int)$result['count'] : 0;
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
