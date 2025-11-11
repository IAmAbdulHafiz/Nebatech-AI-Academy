<?php
$title = $course['title'] ?? 'Course';
ob_start();
// Use appropriate sidebar based on user role
if (isset($user['role']) && $user['role'] === 'facilitator') {
    include __DIR__ . '/../partials/facilitator-sidebar.php';
} elseif (isset($user['role']) && $user['role'] === 'admin') {
    include __DIR__ . '/../partials/admin-sidebar.php';
} else {
    include __DIR__ . '/../partials/student-sidebar.php';
}
$sidebarContent = ob_get_clean();
ob_start();
?>

<div x-data="courseViewer()" x-init="initTracking()">
    <!-- Preview Mode Banner (for facilitators not enrolled) -->
    <?php if (isset($user['role']) && $user['role'] === 'facilitator' && !$enrollment): ?>
    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded-lg">
        <div class="flex items-center">
            <i class="fas fa-eye text-blue-500 text-xl mr-3"></i>
            <div>
                <h3 class="text-blue-900 font-semibold">Preview Mode</h3>
                <p class="text-blue-700 text-sm">You are viewing this course in read-only mode. Interactive features are disabled.</p>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Course Header -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex items-start justify-between">
            <div class="flex-1">
                <?php if ($user['role'] === 'facilitator' && !$enrollment): ?>
                    <a href="<?= url('/facilitator/courses') ?>" class="text-primary hover:underline text-sm mb-2 inline-block">
                        <i class="fas fa-arrow-left mr-1"></i>Back to Courses
                    </a>
                <?php else: ?>
                    <a href="<?= url('/my-courses') ?>" class="text-primary hover:underline text-sm mb-2 inline-block">
                        <i class="fas fa-arrow-left mr-1"></i>Back to My Courses
                    </a>
                <?php endif; ?>
                <h1 class="text-3xl font-bold text-gray-900 mb-2"><?= htmlspecialchars($course['title']) ?></h1>
                <p class="text-gray-600 mb-4"><?= htmlspecialchars($course['description'] ?? '') ?></p>
                
                <!-- Progress Bar (only for enrolled users) -->
                <?php if ($enrollment): ?>
                <div class="max-w-md">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-gray-700">Course Progress</span>
                        <span class="text-sm font-bold text-primary"><?= number_format($enrollment['progress'] ?? 0, 1) ?>%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-primary h-3 rounded-full transition-all" style="width: <?= $enrollment['progress'] ?? 0 ?>%"></div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Resume Course Button -->
                <?php if (isset($resumeLesson) && $resumeLesson): ?>
                <div class="mt-4">
                    <?php 
                    $lessonId = $resumeLesson['lesson_id'] ?? $resumeLesson['id'];
                    $isInProgress = isset($resumeLesson['status']) && $resumeLesson['status'] === 'in_progress';
                    $buttonText = $isInProgress ? 'Resume Learning' : 'Start Next Lesson';
                    ?>
                    <a href="<?= url('/courses/' . $course['slug'] . '/lesson/' . $lessonId) ?>" 
                       class="inline-flex items-center px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary-dark transition font-semibold shadow-md hover:shadow-lg">
                        <i class="fas fa-play-circle mr-2"></i>
                        <?= $buttonText ?>
                    </a>
                    <?php if ($isInProgress): ?>
                    <p class="text-sm text-gray-600 mt-2">
                        Continue from: <strong><?= htmlspecialchars($resumeLesson['lesson_title'] ?? $resumeLesson['title'] ?? 'Last lesson') ?></strong>
                    </p>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Course Content -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Current Lesson/Assignment Display -->
            <div id="content-area" class="bg-white rounded-lg shadow p-6">
                <?php if (isset($currentLesson)): ?>
                    <!-- Lesson Header with Actions -->
                    <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-200">
                        <div class="flex items-center gap-3">
                            <?php if (isset($lessonProgress) && $lessonProgress['status'] === 'completed'): ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-1"></i> Completed
                            </span>
                            <?php elseif (isset($lessonProgress) && $lessonProgress['status'] === 'in_progress'): ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800">
                                <i class="fas fa-spinner mr-1"></i> In Progress
                            </span>
                            <?php endif; ?>
                            
                            <?php if (isset($lessonProgress) && $lessonProgress['time_spent_seconds'] > 0): ?>
                            <span class="text-sm text-gray-600">
                                <i class="fas fa-clock mr-1"></i>
                                <?= gmdate('H:i:s', $lessonProgress['time_spent_seconds']) ?> spent
                            </span>
                            <?php endif; ?>
                        </div>
                        
                        <?php if ($enrollment): ?>
                        <div class="flex items-center gap-2">
                            <!-- Bookmark Button -->
                            <button @click="toggleBookmark(<?= $currentLesson['id'] ?>)" 
                                    class="p-2 rounded-lg hover:bg-gray-100 transition"
                                    :class="bookmarked ? 'text-yellow-500' : 'text-gray-400'">
                                <i class="fas fa-bookmark" :class="bookmarked ? 'fas' : 'far'"></i>
                            </button>
                            
                            <!-- Mark Complete Button -->
                            <?php if (!isset($lessonProgress) || $lessonProgress['status'] !== 'completed'): ?>
                            <button @click="markComplete(<?= $currentLesson['id'] ?>)" 
                                    class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold text-sm">
                                <i class="fas fa-check mr-2"></i>Mark Complete
                            </button>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <!-- Lesson Content -->
                    <h2 class="text-2xl font-bold text-gray-900 mb-4"><?= htmlspecialchars($currentLesson['title']) ?></h2>
                    <div class="prose max-w-none mb-6">
                        <?= $currentLesson['content'] ?>
                    </div>

                    <!-- Notes Section (only for enrolled users) -->
                    <?php if ($enrollment): ?>
                    <div class="mt-6 border-t border-gray-200 pt-6">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-lg font-semibold text-gray-900">
                                <i class="fas fa-sticky-note text-primary mr-2"></i>My Notes
                            </h3>
                            <button @click="saveNotes()" 
                                    x-show="notesChanged"
                                    class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition text-sm font-semibold">
                                <i class="fas fa-save mr-1"></i>Save Notes
                            </button>
                        </div>
                        <textarea x-model="notes" 
                                  @input="notesChanged = true"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent resize-none"
                                  rows="4"
                                  placeholder="Take notes about this lesson..."></textarea>
                    </div>
                    <?php endif; ?>

                    <!-- Assignment Section (if exists) -->
                    <?php if (isset($currentAssignment)): ?>
                        <div class="border-t border-gray-200 pt-6 mt-6">
                            <h3 class="text-xl font-semibold text-gray-900 mb-4">
                                <i class="fas fa-clipboard-list text-primary mr-2"></i>
                                Assignment: <?= htmlspecialchars($currentAssignment['title']) ?>
                            </h3>
                            
                            <div class="prose max-w-none mb-6">
                                <?= $currentAssignment['description'] ?>
                            </div>

                            <?php if ($currentAssignment['max_score']): ?>
                                <p class="text-sm text-gray-600 mb-4">
                                    <i class="fas fa-star text-yellow-500 mr-1"></i>
                                    Maximum Score: <strong><?= $currentAssignment['max_score'] ?> points</strong>
                                </p>
                            <?php endif; ?>

                            <?php
                            // Check if student has already submitted
                            $submission = \Nebatech\Models\Submission::findByUserAndAssignment(
                                $user['id'], 
                                $currentAssignment['id']
                            );
                            ?>

                            <div class="flex gap-4 flex-wrap">
                                <?php if ($submission): ?>
                                    <!-- Already submitted - show view button -->
                                    <a href="<?= url('/submission/' . $submission['id']) ?>" 
                                       class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                                        <i class="fas fa-eye mr-2"></i>View Submission
                                    </a>
                                    
                                    <?php if ($submission['status'] === 'revision_needed'): ?>
                                        <!-- Needs revision - show update button -->
                                        <a href="<?= url('/assignment/' . $currentAssignment['id'] . '/submit') ?>" 
                                           class="inline-flex items-center px-6 py-3 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition font-semibold">
                                            <i class="fas fa-redo mr-2"></i>Update Submission
                                        </a>
                                    <?php endif; ?>
                                    
                                    <!-- Show status badge -->
                                    <?php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                        'graded' => 'bg-blue-100 text-blue-800 border-blue-200',
                                        'verified' => 'bg-green-100 text-green-800 border-green-200',
                                        'revision_needed' => 'bg-red-100 text-red-800 border-red-200'
                                    ];
                                    $statusColor = $statusColors[$submission['status']] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                                    ?>
                                    <div class="inline-flex items-center px-4 py-3 border-2 rounded-lg <?= $statusColor ?> font-semibold">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        <?= ucwords(str_replace('_', ' ', $submission['status'])) ?>
                                        <?php if ($submission['facilitator_score']): ?>
                                            <span class="ml-2 font-bold">(<?= number_format($submission['facilitator_score'], 1) ?>%)</span>
                                        <?php endif; ?>
                                    </div>
                                <?php else: ?>
                                    <!-- Not submitted yet - show submit button -->
                                    <a href="<?= url('/assignment/' . $currentAssignment['id'] . '/submit') ?>" 
                                       class="inline-flex items-center px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary-dark transition font-semibold">
                                        <i class="fas fa-paper-plane mr-2"></i>Submit Assignment
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Next Lesson Navigation -->
                    <?php if (isset($nextLesson) && $nextLesson): ?>
                    <div class="mt-6 border-t border-gray-200 pt-6">
                        <a href="<?= url('/courses/' . $course['slug'] . '/lesson/' . $nextLesson['id']) ?>" 
                           class="inline-flex items-center px-6 py-3 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition font-semibold">
                            Next Lesson: <?= htmlspecialchars($nextLesson['title']) ?>
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                    <?php endif; ?>

                <?php else: ?>
                    <!-- No lesson selected -->
                    <div class="text-center py-12">
                        <i class="fas fa-book-open text-6xl text-gray-300 mb-4"></i>
                        <h3 class="text-xl font-bold text-gray-700 mb-2">Select a Lesson</h3>
                        <p class="text-gray-600">Choose a lesson from the curriculum to start learning</p>
                    </div>
                <?php endif; ?>
            </div>

        </div>

        <!-- Curriculum Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow p-6 sticky top-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Course Curriculum</h3>
                
                <?php if (empty($modules)): ?>
                    <p class="text-gray-600 text-sm">No modules available yet.</p>
                <?php else: ?>
                    <div class="space-y-4">
                        <?php foreach ($modules as $module): ?>
                            <div class="border border-gray-200 rounded-lg overflow-hidden">
                                <!-- Module Header -->
                                <button @click="toggleModule(<?= $module['id'] ?>)" 
                                        class="w-full flex items-center justify-between p-4 bg-gray-50 hover:bg-gray-100 transition">
                                    <div class="flex items-center gap-3">
                                        <i class="fas fa-folder text-primary"></i>
                                        <span class="font-semibold text-gray-900 text-left"><?= htmlspecialchars($module['title']) ?></span>
                                    </div>
                                    <i class="fas fa-chevron-down transition-transform" 
                                       :class="openModules.includes(<?= $module['id'] ?>) ? 'rotate-180' : ''"></i>
                                </button>

                                <!-- Lessons List -->
                                <div x-show="openModules.includes(<?= $module['id'] ?>)" 
                                     x-transition
                                     class="border-t border-gray-200">
                                    <?php if (empty($module['lessons'])): ?>
                                        <p class="p-4 text-sm text-gray-500">No lessons yet</p>
                                    <?php else: ?>
                                        <?php foreach ($module['lessons'] as $lesson): ?>
                                            <a href="<?= url('/courses/' . $course['slug'] . '/lesson/' . $lesson['id']) ?>" 
                                               class="flex items-center gap-3 p-4 hover:bg-gray-50 transition border-b border-gray-100 last:border-b-0 <?= isset($currentLesson) && $currentLesson['id'] === $lesson['id'] ? 'bg-primary-50' : '' ?>">
                                                <!-- Status Icon -->
                                                <?php if ($lesson['is_completed']): ?>
                                                    <i class="fas fa-check-circle text-green-500"></i>
                                                <?php elseif ($lesson['is_in_progress']): ?>
                                                    <i class="fas fa-circle-half-stroke text-blue-500"></i>
                                                <?php else: ?>
                                                    <i class="far fa-circle text-gray-400"></i>
                                                <?php endif; ?>
                                                
                                                <div class="flex-1">
                                                    <p class="text-sm font-medium text-gray-900 <?= $lesson['is_completed'] ? 'line-through text-gray-500' : '' ?>">
                                                        <?= htmlspecialchars($lesson['title']) ?>
                                                    </p>
                                                    <div class="flex items-center gap-2 mt-1">
                                                        <?php if ($lesson['duration_minutes']): ?>
                                                            <span class="text-xs text-gray-500">
                                                                <i class="fas fa-clock mr-1"></i><?= $lesson['duration_minutes'] ?> min
                                                            </span>
                                                        <?php endif; ?>
                                                        <?php if ($lesson['has_assignment']): ?>
                                                            <span class="text-xs text-primary">
                                                                <i class="fas fa-clipboard-list mr-1"></i>Assignment
                                                            </span>
                                                        <?php endif; ?>
                                                        <?php if (isset($lesson['progress']) && $lesson['progress']['bookmarked']): ?>
                                                            <i class="fas fa-bookmark text-yellow-500 text-xs"></i>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </a>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
function courseViewer() {
    return {
        openModules: [<?= isset($currentLesson) ? $currentLesson['module_id'] : '' ?>],
        bookmarked: <?= isset($lessonProgress) && $lessonProgress['bookmarked'] ? 'true' : 'false' ?>,
        notes: <?= isset($lessonProgress) && $lessonProgress['notes'] ? json_encode($lessonProgress['notes']) : '""' ?>,
        notesChanged: false,
        timeTracker: null,
        startTime: null,
        
        initTracking() {
            <?php if (isset($currentLesson)): ?>
            // Start time tracking
            this.startTime = Date.now();
            this.timeTracker = setInterval(() => {
                this.trackTime();
            }, 30000); // Track every 30 seconds
            
            // Track time on page unload
            window.addEventListener('beforeunload', () => {
                this.trackTime();
            });
            <?php endif; ?>
        },
        
        toggleModule(moduleId) {
            if (this.openModules.includes(moduleId)) {
                this.openModules = this.openModules.filter(id => id !== moduleId);
            } else {
                this.openModules.push(moduleId);
            }
        },
        
        async markComplete(lessonId) {
            try {
                const response = await fetch('<?= url('/api/progress/mark-complete') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        lesson_id: lessonId,
                        enrollment_id: <?= $enrollment['id'] ?? 0 ?>
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Show success message
                    this.showNotification('Lesson marked as completed!', 'success');
                    
                    // Reload page to update UI
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    this.showNotification('Failed to mark lesson as complete', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                this.showNotification('An error occurred', 'error');
            }
        },
        
        async toggleBookmark(lessonId) {
            try {
                const response = await fetch('<?= url('/api/progress/toggle-bookmark') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        lesson_id: lessonId
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    this.bookmarked = data.bookmarked;
                    this.showNotification(
                        data.bookmarked ? 'Lesson bookmarked!' : 'Bookmark removed',
                        'success'
                    );
                }
            } catch (error) {
                console.error('Error:', error);
            }
        },
        
        async saveNotes() {
            <?php if (isset($currentLesson)): ?>
            try {
                const response = await fetch('<?= url('/api/progress/save-notes') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        lesson_id: <?= $currentLesson['id'] ?>,
                        notes: this.notes
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    this.notesChanged = false;
                    this.showNotification('Notes saved!', 'success');
                }
            } catch (error) {
                console.error('Error:', error);
            }
            <?php endif; ?>
        },
        
        async trackTime() {
            <?php if (isset($currentLesson)): ?>
            if (!this.startTime) return;
            
            const elapsed = Math.floor((Date.now() - this.startTime) / 1000);
            this.startTime = Date.now(); // Reset start time
            
            try {
                await fetch('<?= url('/api/progress/track-time') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        lesson_id: <?= $currentLesson['id'] ?>,
                        seconds: elapsed
                    })
                });
            } catch (error) {
                console.error('Error tracking time:', error);
            }
            <?php endif; ?>
        },
        
        showNotification(message, type = 'info') {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg text-white z-50 transition-opacity ${
                type === 'success' ? 'bg-green-500' : 
                type === 'error' ? 'bg-red-500' : 
                'bg-blue-500'
            }`;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            // Remove after 3 seconds
            setTimeout(() => {
                notification.style.opacity = '0';
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }
    }
}
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/dashboard.php';
?>
