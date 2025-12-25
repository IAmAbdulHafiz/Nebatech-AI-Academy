<?php

namespace Nebatech\Models\CBT;

use Nebatech\Core\Database;
use PDO;

/**
 * Learning Objective Model
 * Manages lesson learning objectives
 */
class LearningObjective
{
    /**
     * Create a new learning objective
     */
    public static function create(array $data): int
    {
        $db = Database::connect();
        $stmt = $db->prepare("
            INSERT INTO learning_objectives (lesson_id, objective_number, objective_text, bloom_level, is_assessable)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['lesson_id'],
            $data['objective_number'] ?? 1,
            $data['objective_text'],
            $data['bloom_level'] ?? 'understand',
            $data['is_assessable'] ?? true
        ]);
        return (int)$db->lastInsertId();
    }

    /**
     * Get objectives by lesson
     */
    public static function getByLesson(int $lessonId): array
    {
        $db = Database::connect();
        $stmt = $db->prepare("
            SELECT * FROM learning_objectives 
            WHERE lesson_id = ? 
            ORDER BY objective_number
        ");
        $stmt->execute([$lessonId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Bulk insert objectives for a lesson
     */
    public static function bulkCreate(int $lessonId, array $objectives): int
    {
        $db = Database::connect();
        $count = 0;
        
        foreach ($objectives as $index => $objective) {
            $stmt = $db->prepare("
                INSERT INTO learning_objectives (lesson_id, objective_number, objective_text, bloom_level, is_assessable)
                VALUES (?, ?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE objective_text = VALUES(objective_text), bloom_level = VALUES(bloom_level)
            ");
            $stmt->execute([
                $lessonId,
                $index + 1,
                $objective['text'],
                $objective['bloom_level'] ?? 'understand',
                $objective['is_assessable'] ?? true
            ]);
            $count++;
        }
        
        return $count;
    }

    /**
     * Delete all objectives for a lesson
     */
    public static function deleteByLesson(int $lessonId): bool
    {
        $db = Database::connect();
        $stmt = $db->prepare("DELETE FROM learning_objectives WHERE lesson_id = ?");
        return $stmt->execute([$lessonId]);
    }
}
