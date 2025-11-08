<?php

namespace Nebatech\Models;

use Nebatech\Core\Model;
use Nebatech\Core\Database;

class Assignment extends Model
{
    protected string $table = 'assignments';
    protected string $primaryKey = 'id';

    /**
     * Create a new assignment
     */
    public static function createAssignment(array $data): ?int
    {
        // Generate UUID if not provided
        if (!isset($data['uuid'])) {
            $data['uuid'] = self::generateAssignmentUuid();
        }

        // Set default max_score if not provided
        if (!isset($data['max_score'])) {
            $data['max_score'] = 100;
        }

        // Encode rubric as JSON if it's an array
        if (isset($data['rubric']) && is_array($data['rubric'])) {
            $data['rubric'] = json_encode($data['rubric']);
        }

        try {
            return Database::insert('assignments', $data);
        } catch (\Exception $e) {
            error_log("Assignment creation failed: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get assignments by lesson
     */
    public static function getByLesson(int $lessonId): array
    {
        $sql = "SELECT * FROM " . 'assignments' . " 
                WHERE lesson_id = :lesson_id 
                ORDER BY created_at DESC";
        
        $assignments = Database::fetchAll($sql, ['lesson_id' => $lessonId]);

        // Decode JSON rubric
        foreach ($assignments as &$assignment) {
            if ($assignment['rubric']) {
                $assignment['rubric'] = json_decode($assignment['rubric'], true);
            }
        }

        return $assignments;
    }

    /**
     * Get assignment by ID
     */
    public static function findById(int $id): ?array
    {
        $sql = "SELECT a.*, 
                       l.title as lesson_title,
                       l.module_id,
                       m.title as module_title,
                       m.course_id,
                       c.title as course_title
                FROM " . 'assignments' . " a
                INNER JOIN lessons l ON a.lesson_id = l.id
                INNER JOIN modules m ON l.module_id = m.id
                INNER JOIN courses c ON m.course_id = c.id
                WHERE a.id = :id
                LIMIT 1";
        
        $assignment = Database::fetch($sql, ['id' => $id]);

        if ($assignment && $assignment['rubric']) {
            $assignment['rubric'] = json_decode($assignment['rubric'], true);
        }

        return $assignment;
    }

    /**
     * Update assignment
     */
    public static function updateAssignment(int $assignmentId, array $data): bool
    {
        unset($data['id'], $data['uuid'], $data['created_at'], $data['lesson_id']);

        // Encode rubric as JSON if it's an array
        if (isset($data['rubric']) && is_array($data['rubric'])) {
            $data['rubric'] = json_encode($data['rubric']);
        }

        if (empty($data)) {
            return false;
        }

        $result = Database::update(
            'assignments',
            $data,
            'id = :id',
            ['id' => $assignmentId]
        );

        return $result > 0;
    }

    /**
     * Delete assignment
     */
    public static function deleteAssignment(int $assignmentId): bool
    {
        $result = Database::delete('assignments', 'id = :id', ['id' => $assignmentId]);
        return $result > 0;
    }

    /**
     * Get assignments by course
     */
    public static function getByCourse(int $courseId): array
    {
        $sql = "SELECT a.*, 
                       l.title as lesson_title,
                       m.title as module_title
                FROM " . 'assignments' . " a
                INNER JOIN lessons l ON a.lesson_id = l.id
                INNER JOIN modules m ON l.module_id = m.id
                WHERE m.course_id = :course_id
                ORDER BY a.created_at DESC";
        
        return Database::fetchAll($sql, ['course_id' => $courseId]);
    }

    /**
     * Generate UUID v4
     */
    protected static function generateAssignmentUuid(): string
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}
