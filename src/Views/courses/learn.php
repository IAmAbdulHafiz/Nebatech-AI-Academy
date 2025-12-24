<?php
/**
 * Course Learning Overview Page
 * Shows all modules and lessons for an enrolled student
 */
$courseTitle = $course['title'] ?? 'Course';
$totalLessons = 0;
$completedLessons = 0;

foreach ($modules as $module) {
    if (!empty($module['lessons'])) {
        $totalLessons += count($module['lessons']);
        foreach ($module['lessons'] as $lesson) {
            if (!empty($lesson['is_completed'])) {
                $completedLessons++;
            }
        }
    }
}

$progress = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;
?>

<!-- AI Tutor Context Variables -->
<script>
    window.currentCourseId = <?= json_encode($course['id'] ?? null) ?>;
</script>

<div x-data="{ sidebarOpen: true }" class="min-h-screen bg-gray-50">
    <!-- Course Header Banner -->
    <div class="bg-gradient-to-r from-primary to-primary-dark text-white py-8 px-6">
        <div class="max-w-7xl mx-auto">
            <a href="<?= url('/my-courses') ?>" class="inline-flex items-center text-white/80 hover:text-white mb-4 transition">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to My Courses
            </a>
            <h1 class="text-3xl md:text-4xl font-bold mb-2"><?= htmlspecialchars($courseTitle) ?></h1>
            <p class="text-white/80 mb-4"><?= htmlspecialchars($course['description'] ?? '') ?></p>
            
            <!-- Progress Section -->
            <div class="flex flex-wrap items-center gap-6">
                <div class="flex-1 max-w-md">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium">Your Progress</span>
                        <span class="text-sm font-bold"><?= $progress ?>% Complete</span>
                    </div>
                    <div class="w-full bg-white/30 rounded-full h-3">
                        <div class="bg-secondary h-3 rounded-full transition-all duration-500" style="width: <?= $progress ?>%"></div>
                    </div>
                    <p class="text-sm text-white/70 mt-1"><?= $completedLessons ?> of <?= $totalLessons ?> lessons completed</p>
                </div>
                
                <?php if (isset($resumeLesson) && $resumeLesson): ?>
                <a href="<?= url('/courses/' . $course['slug'] . '/lesson/' . ($resumeLesson['lesson_id'] ?? $resumeLesson['id'])) ?>" 
                   class="inline-flex items-center px-6 py-3 bg-secondary hover:bg-orange-600 text-white rounded-lg font-semibold shadow-lg hover:shadow-xl transition transform hover:scale-105">
                    <i class="fas fa-play-circle mr-2 text-xl"></i>
                    <?= $completedLessons > 0 ? 'Continue Learning' : 'Start Course' ?>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Course Curriculum (Left/Main Column) -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-book-open text-primary mr-3"></i>
                        Course Curriculum
                    </h2>
                    
                    <?php if (empty($modules)): ?>
                    <div class="text-center py-12">
                        <i class="fas fa-folder-open text-6xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500">No modules available yet.</p>
                    </div>
                    <?php else: ?>
                    
                    <!-- Modules Accordion -->
                    <div class="space-y-4" x-data="{ openModule: <?= !empty($modules) ? $modules[0]['id'] : 'null' ?> }">
                        <?php foreach ($modules as $index => $module): ?>
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <!-- Module Header -->
                            <button @click="openModule = openModule === <?= $module['id'] ?> ? null : <?= $module['id'] ?>" 
                                    class="w-full flex items-center justify-between p-4 bg-gray-50 hover:bg-gray-100 transition text-left">
                                <div class="flex items-center gap-3">
                                    <span class="w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center font-bold text-sm">
                                        <?= $index + 1 ?>
                                    </span>
                                    <div>
                                        <h3 class="font-semibold text-gray-900"><?= htmlspecialchars($module['title']) ?></h3>
                                        <p class="text-sm text-gray-500"><?= count($module['lessons'] ?? []) ?> lessons</p>
                                    </div>
                                </div>
                                <i class="fas fa-chevron-down text-gray-400 transition-transform" 
                                   :class="openModule === <?= $module['id'] ?> ? 'rotate-180' : ''"></i>
                            </button>
                            
                            <!-- Module Lessons -->
                            <div x-show="openModule === <?= $module['id'] ?>" 
                                 x-collapse
                                 class="border-t border-gray-200">
                                <?php if (!empty($module['lessons'])): ?>
                                <ul class="divide-y divide-gray-100">
                                    <?php foreach ($module['lessons'] as $lessonIndex => $lesson): ?>
                                    <li>
                                        <a href="<?= url('/courses/' . $course['slug'] . '/lesson/' . $lesson['id']) ?>" 
                                           class="flex items-center p-4 hover:bg-blue-50 transition group">
                                            <!-- Lesson Status Icon -->
                                            <span class="w-8 h-8 rounded-full flex items-center justify-center mr-3 flex-shrink-0
                                                <?php if (!empty($lesson['is_completed'])): ?>
                                                    bg-green-100 text-green-600
                                                <?php elseif (!empty($lesson['is_in_progress'])): ?>
                                                    bg-blue-100 text-blue-600
                                                <?php else: ?>
                                                    bg-gray-100 text-gray-400 group-hover:bg-primary/10 group-hover:text-primary
                                                <?php endif; ?>
                                            ">
                                                <?php if (!empty($lesson['is_completed'])): ?>
                                                    <i class="fas fa-check"></i>
                                                <?php elseif (!empty($lesson['is_in_progress'])): ?>
                                                    <i class="fas fa-play"></i>
                                                <?php else: ?>
                                                    <i class="fas fa-circle text-xs"></i>
                                                <?php endif; ?>
                                            </span>
                                            
                                            <!-- Lesson Info -->
                                            <div class="flex-1 min-w-0">
                                                <p class="font-medium text-gray-900 group-hover:text-primary transition truncate">
                                                    <?= htmlspecialchars($lesson['title']) ?>
                                                </p>
                                                <p class="text-sm text-gray-500 flex items-center gap-3">
                                                    <?php if (!empty($lesson['duration_minutes'])): ?>
                                                    <span><i class="far fa-clock mr-1"></i><?= $lesson['duration_minutes'] ?> min</span>
                                                    <?php endif; ?>
                                                    <?php if (!empty($lesson['has_assignment'])): ?>
                                                    <span class="text-orange-500"><i class="fas fa-tasks mr-1"></i>Has Assignment</span>
                                                    <?php endif; ?>
                                                </p>
                                            </div>
                                            
                                            <!-- Arrow -->
                                            <i class="fas fa-chevron-right text-gray-300 group-hover:text-primary transition"></i>
                                        </a>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                                <?php else: ?>
                                <div class="p-4 text-center text-gray-500">
                                    <i class="fas fa-info-circle mr-2"></i>No lessons in this module yet.
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Sidebar (Right Column) -->
            <div class="space-y-6">
                
                <!-- Course Stats Card -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-chart-bar text-primary mr-2"></i>
                        Course Overview
                    </h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <span class="text-gray-600"><i class="fas fa-layer-group mr-2 text-primary/60"></i>Modules</span>
                            <span class="font-semibold"><?= count($modules) ?></span>
                        </div>
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <span class="text-gray-600"><i class="fas fa-book mr-2 text-primary/60"></i>Total Lessons</span>
                            <span class="font-semibold"><?= $totalLessons ?></span>
                        </div>
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <span class="text-gray-600"><i class="fas fa-check-circle mr-2 text-green-500"></i>Completed</span>
                            <span class="font-semibold text-green-600"><?= $completedLessons ?></span>
                        </div>
                        <div class="flex items-center justify-between py-3">
                            <span class="text-gray-600"><i class="fas fa-hourglass-half mr-2 text-orange-500"></i>Remaining</span>
                            <span class="font-semibold text-orange-600"><?= $totalLessons - $completedLessons ?></span>
                        </div>
                    </div>
                </div>
                
                <!-- Enrollment Info Card -->
                <?php if ($enrollment): ?>
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-id-badge text-primary mr-2"></i>
                        Enrollment Details
                    </h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Status</span>
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full font-medium capitalize">
                                <?= htmlspecialchars($enrollment['status'] ?? 'active') ?>
                            </span>
                        </div>
                        <?php if (!empty($enrollment['enrolled_at'])): ?>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Enrolled On</span>
                            <span class="font-medium"><?= date('M j, Y', strtotime($enrollment['enrolled_at'])) ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-bolt text-yellow-500 mr-2"></i>
                        Quick Actions
                    </h3>
                    <div class="space-y-3">
                        <?php if (isset($resumeLesson) && $resumeLesson): ?>
                        <a href="<?= url('/courses/' . $course['slug'] . '/lesson/' . ($resumeLesson['lesson_id'] ?? $resumeLesson['id'])) ?>" 
                           class="w-full flex items-center justify-center px-4 py-3 bg-primary hover:bg-primary-dark text-white rounded-lg font-semibold transition">
                            <i class="fas fa-play mr-2"></i>
                            <?= $completedLessons > 0 ? 'Continue Learning' : 'Start Learning' ?>
                        </a>
                        <?php endif; ?>
                        <a href="<?= url('/courses/' . $course['slug']) ?>" 
                           class="w-full flex items-center justify-center px-4 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition">
                            <i class="fas fa-info-circle mr-2"></i>
                            Course Details
                        </a>
                        <a href="<?= url('/ai-tutor?course=' . $course['id']) ?>" 
                           class="w-full flex items-center justify-center px-4 py-3 bg-gradient-to-r from-purple-500 to-indigo-600 text-white rounded-lg font-semibold hover:shadow-lg transition">
                            <i class="fas fa-robot mr-2"></i>
                            Ask AI Tutor
                        </a>
                    </div>
                </div>
                
                <!-- Need Help? -->
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                    <h3 class="font-bold text-blue-900 mb-2 flex items-center">
                        <i class="fas fa-question-circle text-blue-500 mr-2"></i>
                        Need Help?
                    </h3>
                    <p class="text-blue-700 text-sm mb-4">
                        Having trouble with the course? Our support team is here to help!
                    </p>
                    <a href="<?= url('/support') ?>" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                        Contact Support <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom animation for accordion */
    [x-cloak] { display: none !important; }
</style>
