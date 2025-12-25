<?php

namespace Nebatech\Controllers;

use Nebatech\Core\Controller;
use Nebatech\Core\Database;

/**
 * CBT Progress Controller
 * Handles competency-based training progress dashboard and related endpoints
 */
class CBTProgressController extends Controller
{
    /**
     * Display the CBT progress dashboard
     */
    public function dashboard()
    {
        // Require authentication
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . url('/login'));
            exit;
        }

        $userId = $_SESSION['user_id'];
        $db = Database::connect();

        // Get enrolled courses with CBT progress
        $courses = $this->getCoursesWithProgress($db, $userId);

        // Calculate overall stats
        $overallStats = $this->calculateOverallStats($db, $userId);

        // Get recent activity
        $recentActivity = $this->getRecentActivity($db, $userId);

        // Get competency progress
        $competencies = $this->getCompetencyProgress($db, $userId);

        // Get milestones achieved
        $milestones = $this->getMilestones($db, $userId);

        return $this->render('progress/cbt-dashboard', [
            'title' => 'My Learning Progress',
            'courses' => $courses,
            'overallStats' => $overallStats,
            'recentActivity' => $recentActivity,
            'competencies' => $competencies,
            'milestones' => $milestones,
            'user' => \Nebatech\Models\User::findById($userId)
        ], 'student');
    }

    /**
     * Get enrolled courses with CBT progress
     */
    private function getCoursesWithProgress($db, $userId)
    {
        $courses = [];

        try {
            // Get all enrolled courses
            $stmt = $db->prepare("
                SELECT c.id, c.title, c.slug, e.progress as enrollment_progress,
                       (SELECT COUNT(*) FROM lessons l 
                        JOIN modules m ON l.module_id = m.id 
                        WHERE m.course_id = c.id) as total_lessons,
                       (SELECT COUNT(*) FROM lesson_progress lp 
                        JOIN lessons l ON lp.lesson_id = l.id
                        JOIN modules m ON l.module_id = m.id
                        WHERE lp.user_id = ? AND m.course_id = c.id AND lp.status = 'completed') as lessons_completed
                FROM enrollments e
                JOIN courses c ON e.course_id = c.id
                WHERE e.user_id = ? AND e.status = 'active'
                ORDER BY e.enrolled_at DESC
            ");
            $stmt->execute([$userId, $userId]);
            $enrolledCourses = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            foreach ($enrolledCourses as $course) {
                // Get CBT stats for each course
                $courseId = $course['id'];

                // Total objectives for this course
                $objStmt = $db->prepare("
                    SELECT COUNT(*) FROM cbt_learning_objectives lo
                    JOIN lessons l ON lo.lesson_id = l.id
                    JOIN modules m ON l.module_id = m.id
                    WHERE m.course_id = ?
                ");
                $objStmt->execute([$courseId]);
                $course['total_objectives'] = (int)$objStmt->fetchColumn();

                // Mastered objectives (via passed quizzes)
                $masteredStmt = $db->prepare("
                    SELECT COUNT(DISTINCT lo.id) FROM cbt_learning_objectives lo
                    JOIN lessons l ON lo.lesson_id = l.id
                    JOIN modules m ON l.module_id = m.id
                    JOIN cbt_quizzes q ON q.lesson_id = l.id
                    JOIN cbt_quiz_attempts qa ON qa.quiz_id = q.id
                    WHERE m.course_id = ? AND qa.user_id = ? AND qa.passed = 1
                ");
                $masteredStmt->execute([$courseId, $userId]);
                $course['objectives_mastered'] = (int)$masteredStmt->fetchColumn();

                // Quizzes passed
                $quizStmt = $db->prepare("
                    SELECT COUNT(DISTINCT q.id) FROM cbt_quizzes q
                    JOIN lessons l ON q.lesson_id = l.id
                    JOIN modules m ON l.module_id = m.id
                    JOIN cbt_quiz_attempts qa ON qa.quiz_id = q.id
                    WHERE m.course_id = ? AND qa.user_id = ? AND qa.passed = 1
                ");
                $quizStmt->execute([$courseId, $userId]);
                $course['quizzes_passed'] = (int)$quizStmt->fetchColumn();

                // Practicals completed
                $practStmt = $db->prepare("
                    SELECT COUNT(DISTINCT p.id) FROM cbt_practicals p
                    JOIN lessons l ON p.lesson_id = l.id
                    JOIN modules m ON l.module_id = m.id
                    JOIN cbt_practical_submissions ps ON ps.practical_id = p.id
                    WHERE m.course_id = ? AND ps.user_id = ? AND ps.status = 'approved'
                ");
                $practStmt->execute([$courseId, $userId]);
                $course['practicals_completed'] = (int)$practStmt->fetchColumn();

                // Calculate competency progress
                if ($course['total_objectives'] > 0) {
                    $course['competency_progress'] = ($course['objectives_mastered'] / $course['total_objectives']) * 100;
                } else {
                    $course['competency_progress'] = $course['enrollment_progress'] ?? 0;
                }

                $courses[] = $course;
            }
        } catch (\Exception $e) {
            error_log("Error fetching course progress: " . $e->getMessage());
        }

        return $courses;
    }

    /**
     * Calculate overall CBT statistics
     */
    private function calculateOverallStats($db, $userId)
    {
        $stats = [
            'overall_progress' => 0,
            'total_objectives' => 0,
            'mastered_objectives' => 0,
            'quizzes_passed' => 0,
            'practicals_completed' => 0
        ];

        try {
            // Total objectives across all enrolled courses
            $stmt = $db->prepare("
                SELECT COUNT(*) FROM cbt_learning_objectives lo
                JOIN lessons l ON lo.lesson_id = l.id
                JOIN modules m ON l.module_id = m.id
                JOIN enrollments e ON e.course_id = m.course_id
                WHERE e.user_id = ? AND e.status = 'active'
            ");
            $stmt->execute([$userId]);
            $stats['total_objectives'] = (int)$stmt->fetchColumn();

            // Mastered objectives
            $stmt = $db->prepare("
                SELECT COUNT(DISTINCT lo.id) FROM cbt_learning_objectives lo
                JOIN lessons l ON lo.lesson_id = l.id
                JOIN modules m ON l.module_id = m.id
                JOIN enrollments e ON e.course_id = m.course_id
                JOIN cbt_quizzes q ON q.lesson_id = l.id
                JOIN cbt_quiz_attempts qa ON qa.quiz_id = q.id
                WHERE e.user_id = ? AND e.status = 'active' AND qa.user_id = ? AND qa.passed = 1
            ");
            $stmt->execute([$userId, $userId]);
            $stats['mastered_objectives'] = (int)$stmt->fetchColumn();

            // Quizzes passed
            $stmt = $db->prepare("
                SELECT COUNT(DISTINCT qa.quiz_id) FROM cbt_quiz_attempts qa
                WHERE qa.user_id = ? AND qa.passed = 1
            ");
            $stmt->execute([$userId]);
            $stats['quizzes_passed'] = (int)$stmt->fetchColumn();

            // Practicals completed
            $stmt = $db->prepare("
                SELECT COUNT(DISTINCT ps.practical_id) FROM cbt_practical_submissions ps
                WHERE ps.user_id = ? AND ps.status = 'approved'
            ");
            $stmt->execute([$userId]);
            $stats['practicals_completed'] = (int)$stmt->fetchColumn();

            // Calculate overall progress
            if ($stats['total_objectives'] > 0) {
                $stats['overall_progress'] = ($stats['mastered_objectives'] / $stats['total_objectives']) * 100;
            }
        } catch (\Exception $e) {
            error_log("Error calculating overall stats: " . $e->getMessage());
        }

        return $stats;
    }

    /**
     * Get recent learning activity
     */
    private function getRecentActivity($db, $userId)
    {
        $activities = [];

        try {
            // Quiz attempts
            $stmt = $db->prepare("
                SELECT 'quiz_passed' as type, 
                       CONCAT('Passed quiz: ', q.title, ' (', qa.score, '%)') as description,
                       qa.completed_at as created_at
                FROM cbt_quiz_attempts qa
                JOIN cbt_quizzes q ON qa.quiz_id = q.id
                WHERE qa.user_id = ? AND qa.passed = 1
                ORDER BY qa.completed_at DESC
                LIMIT 10
            ");
            $stmt->execute([$userId]);
            $activities = array_merge($activities, $stmt->fetchAll(\PDO::FETCH_ASSOC));

            // Practical submissions
            $stmt = $db->prepare("
                SELECT 'practical_completed' as type,
                       CONCAT('Completed practical: ', p.title) as description,
                       ps.submitted_at as created_at
                FROM cbt_practical_submissions ps
                JOIN cbt_practicals p ON ps.practical_id = p.id
                WHERE ps.user_id = ? AND ps.status = 'approved'
                ORDER BY ps.submitted_at DESC
                LIMIT 10
            ");
            $stmt->execute([$userId]);
            $activities = array_merge($activities, $stmt->fetchAll(\PDO::FETCH_ASSOC));

            // Sort by date
            usort($activities, function($a, $b) {
                return strtotime($b['created_at']) - strtotime($a['created_at']);
            });

            $activities = array_slice($activities, 0, 10);
        } catch (\Exception $e) {
            error_log("Error fetching activity: " . $e->getMessage());
        }

        return $activities;
    }

    /**
     * Get competency progress breakdown
     */
    private function getCompetencyProgress($db, $userId)
    {
        $competencies = [];

        try {
            $stmt = $db->prepare("
                SELECT c.id, c.name, c.description,
                       COUNT(DISTINCT cm.module_id) as total_modules,
                       COUNT(DISTINCT CASE WHEN lp.status = 'completed' THEN l.id END) as completed_lessons,
                       COUNT(DISTINCT l.id) as total_lessons
                FROM cbt_competencies c
                JOIN cbt_competency_modules cm ON c.id = cm.competency_id
                JOIN modules m ON cm.module_id = m.id
                JOIN lessons l ON l.module_id = m.id
                JOIN enrollments e ON e.course_id = m.course_id
                LEFT JOIN lesson_progress lp ON lp.lesson_id = l.id AND lp.user_id = ?
                WHERE e.user_id = ? AND e.status = 'active'
                GROUP BY c.id
                ORDER BY c.name
            ");
            $stmt->execute([$userId, $userId]);
            $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            foreach ($rows as $row) {
                $progress = 0;
                if ($row['total_lessons'] > 0) {
                    $progress = ($row['completed_lessons'] / $row['total_lessons']) * 100;
                }
                $competencies[] = [
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'description' => $row['description'],
                    'progress' => round($progress, 1)
                ];
            }
        } catch (\Exception $e) {
            error_log("Error fetching competencies: " . $e->getMessage());
        }

        return $competencies;
    }

    /**
     * Get achieved milestones
     */
    private function getMilestones($db, $userId)
    {
        $milestones = [];

        try {
            $stmt = $db->prepare("
                SELECT m.title, m.description, m.badge_icon, sm.achieved_at
                FROM cbt_student_milestones sm
                JOIN cbt_milestones m ON sm.milestone_id = m.id
                WHERE sm.user_id = ?
                ORDER BY sm.achieved_at DESC
                LIMIT 10
            ");
            $stmt->execute([$userId]);
            $milestones = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            error_log("Error fetching milestones: " . $e->getMessage());
        }

        return $milestones;
    }

    /**
     * API endpoint to get progress data (for AJAX updates)
     */
    public function getProgress()
    {
        header('Content-Type: application/json');

        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'error' => 'Not authenticated']);
            return;
        }

        $userId = $_SESSION['user_id'];
        $db = Database::connect();

        $courseId = $_GET['course_id'] ?? null;

        try {
            if ($courseId) {
                // Get progress for specific course
                $progress = $this->getCourseProgress($db, $userId, $courseId);
            } else {
                // Get overall progress
                $progress = $this->calculateOverallStats($db, $userId);
            }

            echo json_encode(['success' => true, 'progress' => $progress]);
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Get detailed progress for a specific course
     */
    private function getCourseProgress($db, $userId, $courseId)
    {
        $progress = [
            'lessons_completed' => 0,
            'total_lessons' => 0,
            'objectives_mastered' => 0,
            'total_objectives' => 0,
            'quizzes_passed' => 0,
            'total_quizzes' => 0,
            'practicals_completed' => 0,
            'total_practicals' => 0,
            'competency_progress' => 0
        ];

        try {
            // Total and completed lessons
            $stmt = $db->prepare("
                SELECT COUNT(*) as total,
                       SUM(CASE WHEN lp.status = 'completed' THEN 1 ELSE 0 END) as completed
                FROM lessons l
                JOIN modules m ON l.module_id = m.id
                LEFT JOIN lesson_progress lp ON lp.lesson_id = l.id AND lp.user_id = ?
                WHERE m.course_id = ?
            ");
            $stmt->execute([$userId, $courseId]);
            $row = $stmt->fetch(\PDO::FETCH_ASSOC);
            $progress['total_lessons'] = (int)$row['total'];
            $progress['lessons_completed'] = (int)$row['completed'];

            // Total objectives
            $stmt = $db->prepare("
                SELECT COUNT(*) FROM cbt_learning_objectives lo
                JOIN lessons l ON lo.lesson_id = l.id
                JOIN modules m ON l.module_id = m.id
                WHERE m.course_id = ?
            ");
            $stmt->execute([$courseId]);
            $progress['total_objectives'] = (int)$stmt->fetchColumn();

            // Mastered objectives
            $stmt = $db->prepare("
                SELECT COUNT(DISTINCT lo.id) FROM cbt_learning_objectives lo
                JOIN lessons l ON lo.lesson_id = l.id
                JOIN modules m ON l.module_id = m.id
                JOIN cbt_quizzes q ON q.lesson_id = l.id
                JOIN cbt_quiz_attempts qa ON qa.quiz_id = q.id
                WHERE m.course_id = ? AND qa.user_id = ? AND qa.passed = 1
            ");
            $stmt->execute([$courseId, $userId]);
            $progress['objectives_mastered'] = (int)$stmt->fetchColumn();

            // Total quizzes
            $stmt = $db->prepare("
                SELECT COUNT(*) FROM cbt_quizzes q
                JOIN lessons l ON q.lesson_id = l.id
                JOIN modules m ON l.module_id = m.id
                WHERE m.course_id = ?
            ");
            $stmt->execute([$courseId]);
            $progress['total_quizzes'] = (int)$stmt->fetchColumn();

            // Passed quizzes
            $stmt = $db->prepare("
                SELECT COUNT(DISTINCT q.id) FROM cbt_quizzes q
                JOIN lessons l ON q.lesson_id = l.id
                JOIN modules m ON l.module_id = m.id
                JOIN cbt_quiz_attempts qa ON qa.quiz_id = q.id
                WHERE m.course_id = ? AND qa.user_id = ? AND qa.passed = 1
            ");
            $stmt->execute([$courseId, $userId]);
            $progress['quizzes_passed'] = (int)$stmt->fetchColumn();

            // Total practicals
            $stmt = $db->prepare("
                SELECT COUNT(*) FROM cbt_practicals p
                JOIN lessons l ON p.lesson_id = l.id
                JOIN modules m ON l.module_id = m.id
                WHERE m.course_id = ?
            ");
            $stmt->execute([$courseId]);
            $progress['total_practicals'] = (int)$stmt->fetchColumn();

            // Completed practicals
            $stmt = $db->prepare("
                SELECT COUNT(DISTINCT p.id) FROM cbt_practicals p
                JOIN lessons l ON p.lesson_id = l.id
                JOIN modules m ON l.module_id = m.id
                JOIN cbt_practical_submissions ps ON ps.practical_id = p.id
                WHERE m.course_id = ? AND ps.user_id = ? AND ps.status = 'approved'
            ");
            $stmt->execute([$courseId, $userId]);
            $progress['practicals_completed'] = (int)$stmt->fetchColumn();

            // Calculate competency progress
            if ($progress['total_objectives'] > 0) {
                $progress['competency_progress'] = ($progress['objectives_mastered'] / $progress['total_objectives']) * 100;
            }
        } catch (\Exception $e) {
            error_log("Error fetching course progress: " . $e->getMessage());
        }

        return $progress;
    }
}
