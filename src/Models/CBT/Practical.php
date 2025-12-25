<?php

namespace Nebatech\Models\CBT;

use Nebatech\Core\Database;
use PDO;

/**
 * Practical Model
 * Manages hands-on exercises for lessons
 */
class Practical
{
    /**
     * Create a new practical exercise
     */
    public static function create(array $data): int
    {
        $db = Database::connect();
        $stmt = $db->prepare("
            INSERT INTO practicals (
                lesson_id, title, description, instructions, expected_outcome,
                starter_code, solution_code, hints, difficulty, estimated_time_minutes,
                practical_type, resources, rubric, max_points, passing_score, is_required, status
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['lesson_id'],
            $data['title'],
            $data['description'],
            $data['instructions'],
            $data['expected_outcome'],
            $data['starter_code'] ?? null,
            $data['solution_code'] ?? null,
            json_encode($data['hints'] ?? []),
            $data['difficulty'] ?? 'beginner',
            $data['estimated_time_minutes'] ?? 30,
            $data['practical_type'] ?? 'coding',
            json_encode($data['resources'] ?? []),
            json_encode($data['rubric'] ?? []),
            $data['max_points'] ?? 100,
            $data['passing_score'] ?? 70,
            $data['is_required'] ?? true,
            $data['status'] ?? 'published'
        ]);
        return (int)$db->lastInsertId();
    }

    /**
     * Find practical by ID
     */
    public static function findById(int $id): ?array
    {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM practicals WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            $result['hints'] = json_decode($result['hints'], true) ?: [];
            $result['resources'] = json_decode($result['resources'], true) ?: [];
            $result['rubric'] = json_decode($result['rubric'], true) ?: [];
        }
        
        return $result ?: null;
    }

    /**
     * Get practical by lesson ID
     */
    public static function getByLesson(int $lessonId): ?array
    {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM practicals WHERE lesson_id = ? AND status = 'published' LIMIT 1");
        $stmt->execute([$lessonId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            $result['hints'] = json_decode($result['hints'], true) ?: [];
            $result['resources'] = json_decode($result['resources'], true) ?: [];
            $result['rubric'] = json_decode($result['rubric'], true) ?: [];
        }
        
        return $result ?: null;
    }

    /**
     * Get all practicals for a course
     */
    public static function getByCourse(int $courseId): array
    {
        $db = Database::connect();
        $stmt = $db->prepare("
            SELECT p.*, l.title as lesson_title, m.title as module_title
            FROM practicals p
            JOIN lessons l ON p.lesson_id = l.id
            JOIN modules m ON l.module_id = m.id
            WHERE m.course_id = ? AND p.status = 'published'
            ORDER BY m.order_index, l.order_index
        ");
        $stmt->execute([$courseId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Update practical
     */
    public static function update(int $id, array $data): bool
    {
        $db = Database::connect();
        $fields = [];
        $values = [];
        
        foreach ($data as $key => $value) {
            if (in_array($key, ['hints', 'resources', 'rubric'])) {
                $value = json_encode($value);
            }
            $fields[] = "{$key} = ?";
            $values[] = $value;
        }
        
        $values[] = $id;
        $sql = "UPDATE practicals SET " . implode(', ', $fields) . " WHERE id = ?";
        $stmt = $db->prepare($sql);
        return $stmt->execute($values);
    }

    /**
     * Count practicals for a course
     */
    public static function countByCourse(int $courseId): int
    {
        $db = Database::connect();
        $stmt = $db->prepare("
            SELECT COUNT(*) FROM practicals p
            JOIN lessons l ON p.lesson_id = l.id
            JOIN modules m ON l.module_id = m.id
            WHERE m.course_id = ? AND p.status = 'published'
        ");
        $stmt->execute([$courseId]);
        return (int)$stmt->fetchColumn();
    }
}
