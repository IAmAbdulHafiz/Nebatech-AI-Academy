<?php

namespace Nebatech\Models\CBT;

use Nebatech\Core\Database;
use PDO;

/**
 * Quiz Model
 * Manages quizzes for lessons
 */
class Quiz
{
    /**
     * Create a new quiz
     */
    public static function create(array $data): int
    {
        $db = Database::connect();
        $stmt = $db->prepare("
            INSERT INTO quizzes (
                lesson_id, title, description, quiz_type, time_limit_minutes,
                max_attempts, passing_score, shuffle_questions, shuffle_options,
                show_correct_answers, show_explanations, is_required, status
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['lesson_id'],
            $data['title'],
            $data['description'] ?? null,
            $data['quiz_type'] ?? 'knowledge_check',
            $data['time_limit_minutes'] ?? null,
            $data['max_attempts'] ?? 3,
            $data['passing_score'] ?? 70,
            $data['shuffle_questions'] ?? true,
            $data['shuffle_options'] ?? true,
            $data['show_correct_answers'] ?? true,
            $data['show_explanations'] ?? true,
            $data['is_required'] ?? true,
            $data['status'] ?? 'published'
        ]);
        return (int)$db->lastInsertId();
    }

    /**
     * Find quiz by ID
     */
    public static function findById(int $id): ?array
    {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM quizzes WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Get quiz by lesson ID
     */
    public static function getByLesson(int $lessonId): ?array
    {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM quizzes WHERE lesson_id = ? AND status = 'published' LIMIT 1");
        $stmt->execute([$lessonId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Get quiz with questions
     */
    public static function getWithQuestions(int $quizId, bool $shuffle = true): ?array
    {
        $quiz = self::findById($quizId);
        if (!$quiz) return null;
        
        $questions = QuizQuestion::getByQuiz($quizId);
        
        if ($shuffle && $quiz['shuffle_questions']) {
            shuffle($questions);
        }
        
        // Shuffle options if enabled
        if ($shuffle && $quiz['shuffle_options']) {
            foreach ($questions as &$q) {
                if ($q['question_type'] === 'multiple_choice' && !empty($q['options'])) {
                    $options = $q['options'];
                    shuffle($options);
                    $q['options'] = $options;
                }
            }
        }
        
        $quiz['questions'] = $questions;
        return $quiz;
    }

    /**
     * Get all quizzes for a course
     */
    public static function getByCourse(int $courseId): array
    {
        $db = Database::connect();
        $stmt = $db->prepare("
            SELECT q.*, l.title as lesson_title, m.title as module_title,
                   (SELECT COUNT(*) FROM quiz_questions WHERE quiz_id = q.id) as question_count
            FROM quizzes q
            JOIN lessons l ON q.lesson_id = l.id
            JOIN modules m ON l.module_id = m.id
            WHERE m.course_id = ? AND q.status = 'published'
            ORDER BY m.order_index, l.order_index
        ");
        $stmt->execute([$courseId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Update quiz
     */
    public static function update(int $id, array $data): bool
    {
        $db = Database::connect();
        $fields = [];
        $values = [];
        
        foreach ($data as $key => $value) {
            $fields[] = "{$key} = ?";
            $values[] = $value;
        }
        
        $values[] = $id;
        $sql = "UPDATE quizzes SET " . implode(', ', $fields) . " WHERE id = ?";
        $stmt = $db->prepare($sql);
        return $stmt->execute($values);
    }

    /**
     * Count quizzes for a course
     */
    public static function countByCourse(int $courseId): int
    {
        $db = Database::connect();
        $stmt = $db->prepare("
            SELECT COUNT(*) FROM quizzes q
            JOIN lessons l ON q.lesson_id = l.id
            JOIN modules m ON l.module_id = m.id
            WHERE m.course_id = ? AND q.status = 'published'
        ");
        $stmt->execute([$courseId]);
        return (int)$stmt->fetchColumn();
    }
}
