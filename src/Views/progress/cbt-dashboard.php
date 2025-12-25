<?php
/**
 * CBT Progress Dashboard
 * Shows student's competency-based training progress across all enrolled courses
 * 
 * @var array $user Current user
 * @var array $courses Enrolled courses with CBT progress
 * @var array $overallStats Overall CBT statistics
 * @var array $recentActivity Recent learning activities
 * @var array $competencies Competency progress
 * @var array $milestones Milestone achievements
 */

$overallProgress = $overallStats['overall_progress'] ?? 0;
$totalObjectives = $overallStats['total_objectives'] ?? 0;
$masteredObjectives = $overallStats['mastered_objectives'] ?? 0;
$quizzesPassed = $overallStats['quizzes_passed'] ?? 0;
$practicalsDone = $overallStats['practicals_completed'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Learning Progress | Nebatech AI Academy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100 min-h-screen">

<div class="max-w-7xl mx-auto px-4 py-8">
    
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">My Learning Progress</h1>
        <p class="text-gray-600">Track your competency-based training journey across all courses</p>
    </div>

    <!-- Overall Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <!-- Overall Progress -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-chart-line text-indigo-600 text-xl"></i>
                </div>
                <span class="text-3xl font-bold text-indigo-600"><?= number_format($overallProgress, 1) ?>%</span>
            </div>
            <h3 class="font-semibold text-gray-900">Overall Progress</h3>
            <div class="mt-2 h-2 bg-gray-200 rounded-full">
                <div class="h-2 bg-indigo-600 rounded-full transition-all" style="width: <?= min(100, $overallProgress) ?>%"></div>
            </div>
        </div>

        <!-- Objectives Mastered -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-bullseye text-green-600 text-xl"></i>
                </div>
                <span class="text-3xl font-bold text-green-600"><?= $masteredObjectives ?></span>
            </div>
            <h3 class="font-semibold text-gray-900">Objectives Mastered</h3>
            <p class="text-sm text-gray-500 mt-1">of <?= $totalObjectives ?> total objectives</p>
        </div>

        <!-- Quizzes Passed -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-check-circle text-blue-600 text-xl"></i>
                </div>
                <span class="text-3xl font-bold text-blue-600"><?= $quizzesPassed ?></span>
            </div>
            <h3 class="font-semibold text-gray-900">Quizzes Passed</h3>
            <p class="text-sm text-gray-500 mt-1">Demonstrated understanding</p>
        </div>

        <!-- Practicals Completed -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-laptop-code text-purple-600 text-xl"></i>
                </div>
                <span class="text-3xl font-bold text-purple-600"><?= $practicalsDone ?></span>
            </div>
            <h3 class="font-semibold text-gray-900">Practicals Done</h3>
            <p class="text-sm text-gray-500 mt-1">Hands-on practice</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Column: Course Progress -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Course Progress Cards -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-book text-indigo-500 mr-3"></i>
                    Course Progress
                </h2>
                
                <?php if (empty($courses)): ?>
                <div class="text-center py-12">
                    <i class="fas fa-book-open text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-semibold text-gray-600 mb-2">No Enrolled Courses</h3>
                    <p class="text-gray-500 mb-4">Start your learning journey by enrolling in a course!</p>
                    <a href="<?= url('/courses') ?>" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition">
                        <i class="fas fa-search mr-2"></i>Browse Courses
                    </a>
                </div>
                <?php else: ?>
                <div class="space-y-4">
                    <?php foreach ($courses as $course): ?>
                    <div class="border border-gray-200 rounded-lg p-5 hover:border-indigo-300 transition">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900"><?= htmlspecialchars($course['title']) ?></h3>
                                <p class="text-sm text-gray-500"><?= $course['lessons_completed'] ?? 0 ?> of <?= $course['total_lessons'] ?? 0 ?> lessons</p>
                            </div>
                            <a href="<?= url('/courses/' . $course['slug'] . '/learn') ?>" 
                               class="px-4 py-2 bg-indigo-100 text-indigo-700 rounded-lg text-sm font-semibold hover:bg-indigo-200 transition">
                                Continue
                            </a>
                        </div>
                        
                        <!-- Progress Bar -->
                        <div class="mb-3">
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600">Competency Progress</span>
                                <span class="font-semibold text-indigo-600"><?= number_format($course['competency_progress'] ?? 0, 1) ?>%</span>
                            </div>
                            <div class="h-2 bg-gray-200 rounded-full">
                                <div class="h-2 bg-indigo-600 rounded-full transition-all" style="width: <?= min(100, $course['competency_progress'] ?? 0) ?>%"></div>
                            </div>
                        </div>
                        
                        <!-- CBT Stats Row -->
                        <div class="flex gap-6 text-sm">
                            <span class="text-gray-600">
                                <i class="fas fa-bullseye text-green-500 mr-1"></i>
                                <?= $course['objectives_mastered'] ?? 0 ?>/<?= $course['total_objectives'] ?? 0 ?> objectives
                            </span>
                            <span class="text-gray-600">
                                <i class="fas fa-check-circle text-blue-500 mr-1"></i>
                                <?= $course['quizzes_passed'] ?? 0 ?> quizzes
                            </span>
                            <span class="text-gray-600">
                                <i class="fas fa-laptop-code text-purple-500 mr-1"></i>
                                <?= $course['practicals_completed'] ?? 0 ?> practicals
                            </span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- Competency Progress Chart -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-chart-bar text-green-500 mr-3"></i>
                    Competency Breakdown
                </h2>
                <div class="h-64">
                    <canvas id="competencyChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Right Column: Recent Activity & Milestones -->
        <div class="space-y-6">
            
            <!-- Recent Activity -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-history text-blue-500 mr-2"></i>
                    Recent Activity
                </h2>
                
                <?php if (empty($recentActivity)): ?>
                <p class="text-gray-500 text-sm">No recent activity yet.</p>
                <?php else: ?>
                <div class="space-y-4">
                    <?php foreach (array_slice($recentActivity, 0, 5) as $activity): ?>
                    <div class="flex items-start gap-3">
                        <?php
                        $iconClass = 'fas fa-circle';
                        $bgColor = 'bg-gray-100';
                        $textColor = 'text-gray-500';
                        
                        switch ($activity['type'] ?? '') {
                            case 'quiz_passed':
                                $iconClass = 'fas fa-check-circle';
                                $bgColor = 'bg-green-100';
                                $textColor = 'text-green-600';
                                break;
                            case 'practical_completed':
                                $iconClass = 'fas fa-laptop-code';
                                $bgColor = 'bg-purple-100';
                                $textColor = 'text-purple-600';
                                break;
                            case 'objective_mastered':
                                $iconClass = 'fas fa-bullseye';
                                $bgColor = 'bg-blue-100';
                                $textColor = 'text-blue-600';
                                break;
                            case 'milestone_achieved':
                                $iconClass = 'fas fa-trophy';
                                $bgColor = 'bg-yellow-100';
                                $textColor = 'text-yellow-600';
                                break;
                        }
                        ?>
                        <div class="w-8 h-8 <?= $bgColor ?> rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="<?= $iconClass ?> <?= $textColor ?> text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-900"><?= htmlspecialchars($activity['description'] ?? '') ?></p>
                            <p class="text-xs text-gray-500 mt-1"><?= \Nebatech\Helpers::timeAgo($activity['created_at'] ?? date('Y-m-d H:i:s')) ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- Milestones -->
            <div class="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-xl p-6 border border-yellow-200">
                <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-trophy text-yellow-500 mr-2"></i>
                    Milestones Achieved
                </h2>
                
                <?php if (empty($milestones)): ?>
                <p class="text-gray-500 text-sm">Complete quizzes and practicals to unlock milestones!</p>
                <?php else: ?>
                <div class="space-y-3">
                    <?php foreach (array_slice($milestones, 0, 5) as $milestone): ?>
                    <div class="bg-white/70 rounded-lg p-3 flex items-center gap-3">
                        <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-medal text-yellow-600"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900 text-sm"><?= htmlspecialchars($milestone['title'] ?? '') ?></p>
                            <p class="text-xs text-gray-500"><?= htmlspecialchars($milestone['description'] ?? '') ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- AI Tutor CTA -->
            <div class="bg-gradient-to-br from-indigo-600 to-purple-700 rounded-xl p-6 text-white">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-robot text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold">AI Study Coach</h3>
                        <p class="text-white/80 text-sm">Get personalized help</p>
                    </div>
                </div>
                <p class="text-white/70 text-sm mb-4">
                    Struggling with a concept? Get guided explanations and study recommendations tailored to your progress.
                </p>
                <a href="<?= url('/ai-tutor') ?>" 
                   class="inline-flex items-center px-4 py-2 bg-white text-indigo-700 rounded-lg font-semibold hover:bg-gray-100 transition text-sm">
                    <i class="fas fa-comments mr-2"></i>
                    Open AI Tutor
                </a>
            </div>
        </div>
    </div>
</div>

<script>
// Competency Progress Chart
const ctx = document.getElementById('competencyChart').getContext('2d');
const competencyData = <?= json_encode($competencies ?? []) ?>;

const labels = competencyData.map(c => c.name || 'Unknown');
const progress = competencyData.map(c => c.progress || 0);

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels.length > 0 ? labels : ['No competencies yet'],
        datasets: [{
            label: 'Mastery %',
            data: progress.length > 0 ? progress : [0],
            backgroundColor: [
                'rgba(99, 102, 241, 0.8)',
                'rgba(16, 185, 129, 0.8)',
                'rgba(59, 130, 246, 0.8)',
                'rgba(139, 92, 246, 0.8)',
                'rgba(245, 158, 11, 0.8)',
                'rgba(239, 68, 68, 0.8)'
            ],
            borderRadius: 8,
            borderSkipped: false
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        indexAxis: 'y',
        plugins: {
            legend: { display: false }
        },
        scales: {
            x: {
                beginAtZero: true,
                max: 100,
                grid: { display: false },
                ticks: { callback: value => value + '%' }
            },
            y: {
                grid: { display: false }
            }
        }
    }
});
</script>

</body>
</html>
