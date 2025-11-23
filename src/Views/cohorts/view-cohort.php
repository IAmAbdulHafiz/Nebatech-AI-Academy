<?php
$title = $cohort['name'] . ' - Cohort Details';
ob_start();
include __DIR__ . '/../partials/student-sidebar.php';
$sidebarContent = ob_get_clean();
ob_start();

$statusConfig = [
    'upcoming' => ['bg' => 'bg-blue-100 text-blue-800', 'icon' => 'fa-clock', 'text' => 'Upcoming'],
    'active' => ['bg' => 'bg-green-100 text-green-800', 'icon' => 'fa-check-circle', 'text' => 'Active'],
    'completed' => ['bg' => 'bg-gray-100 text-gray-800', 'icon' => 'fa-flag-checkered', 'text' => 'Completed']
];
$config = $statusConfig[$cohort['status']] ?? ['bg' => 'bg-gray-100 text-gray-800', 'icon' => 'fa-circle', 'text' => 'Unknown'];
?>

<!-- Page Header -->
<div class="mb-6">
    <div class="flex items-center gap-4 mb-4">
        <a href="<?= url('/my-cohorts') ?>" class="text-gray-600 hover:text-purple-600 transition">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <div class="flex-1">
            <div class="flex items-center gap-3 mb-2">
                <h1 class="text-3xl font-bold text-gray-900"><?= htmlspecialchars($cohort['name']) ?></h1>
                <span class="px-3 py-1 rounded-full text-sm font-semibold <?= $config['bg'] ?>">
                    <i class="fas <?= $config['icon'] ?> mr-1"></i><?= $config['text'] ?>
                </span>
            </div>
            <p class="text-gray-600"><?= htmlspecialchars($cohort['program']) ?></p>
        </div>
    </div>
</div>

<!-- Welcome Banner for Active Cohorts -->
<?php if ($cohort['status'] === 'active'): ?>
<div class="bg-gradient-to-r from-purple-50 to-indigo-50 border border-purple-200 rounded-lg p-6 mb-6">
    <div class="flex items-start gap-4">
        <div class="flex-shrink-0">
            <div class="w-12 h-12 bg-purple-600 rounded-full flex items-center justify-center">
                <i class="fas fa-graduation-cap text-white text-xl"></i>
            </div>
        </div>
        <div class="flex-1">
            <h3 class="font-bold text-gray-900 mb-2">Welcome to Your Learning Journey!</h3>
            <p class="text-gray-700 text-sm mb-3">
                You're part of an active cohort. Click on any course below to start learning. Your progress is automatically tracked, 
                and you can take notes, complete assignments, and earn certificates as you advance.
            </p>
            <div class="flex flex-wrap gap-3 text-sm">
                <div class="flex items-center gap-2 text-gray-700">
                    <i class="fas fa-check-circle text-green-600"></i>
                    <span>Access all course materials</span>
                </div>
                <div class="flex items-center gap-2 text-gray-700">
                    <i class="fas fa-check-circle text-green-600"></i>
                    <span>Track your progress</span>
                </div>
                <div class="flex items-center gap-2 text-gray-700">
                    <i class="fas fa-check-circle text-green-600"></i>
                    <span>Take notes & bookmarks</span>
                </div>
            </div>
        </div>
    </div>
</div>
<?php elseif ($cohort['status'] === 'upcoming'): ?>
<div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
    <div class="flex items-start gap-4">
        <i class="fas fa-clock text-blue-600 text-2xl"></i>
        <div>
            <h3 class="font-bold text-blue-900 mb-1">Cohort Starts Soon</h3>
            <p class="text-blue-800 text-sm">
                This cohort will begin on <?= date('F d, Y', strtotime($cohort['start_date'])) ?>. 
                You can preview the courses below, but full access will be available once the cohort starts.
            </p>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Cohort Overview Card -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Facilitator -->
        <?php if (!empty($cohort['facilitator_first_name'])): ?>
            <div>
                <p class="text-sm text-gray-600 mb-2">Your Facilitator</p>
                <div class="flex items-center gap-2">
                    <i class="fas fa-chalkboard-teacher text-purple-600"></i>
                    <span class="font-semibold text-gray-900">
                        <?= htmlspecialchars($cohort['facilitator_first_name'] . ' ' . $cohort['facilitator_last_name']) ?>
                    </span>
                </div>
                <?php if (!empty($cohort['facilitator_email'])): ?>
                    <a href="mailto:<?= htmlspecialchars($cohort['facilitator_email']) ?>" 
                       class="text-xs text-purple-600 hover:underline mt-1 inline-block">
                        <i class="fas fa-envelope mr-1"></i>Contact
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Start Date -->
        <div>
            <p class="text-sm text-gray-600 mb-2">Started</p>
            <div class="flex items-center gap-2">
                <i class="fas fa-calendar-start text-purple-600"></i>
                <span class="font-semibold text-gray-900">
                    <?= date('M d, Y', strtotime($cohort['start_date'])) ?>
                </span>
            </div>
        </div>

        <!-- End Date -->
        <div>
            <p class="text-sm text-gray-600 mb-2"><?= !empty($cohort['end_date']) ? 'Ends' : 'Duration' ?></p>
            <div class="flex items-center gap-2">
                <i class="fas fa-calendar-check text-purple-600"></i>
                <span class="font-semibold text-gray-900">
                    <?= !empty($cohort['end_date']) ? date('M d, Y', strtotime($cohort['end_date'])) : 'Ongoing' ?>
                </span>
            </div>
        </div>
    </div>

    <?php if (!empty($cohort['description'])): ?>
        <div class="mt-6 pt-6 border-t border-gray-200">
            <p class="text-sm text-gray-600 mb-2">About This Cohort</p>
            <p class="text-gray-800"><?= nl2br(htmlspecialchars($cohort['description'])) ?></p>
        </div>
    <?php endif; ?>
</div>

<!-- Courses in Cohort -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-xl font-bold text-gray-900">
            <i class="fas fa-book-open text-purple-600 mr-2"></i>Courses in This Cohort
        </h2>
    </div>
    <div class="p-6">
        <?php if (empty($courses)): ?>
            <div class="text-center py-12">
                <i class="fas fa-book text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-600">No courses have been added to this cohort yet.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($courses as $course): ?>
                    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition">
                        <!-- Course Thumbnail -->
                        <?php if (!empty($course['thumbnail'])): ?>
                            <div class="h-40 bg-cover bg-center" style="background-image: url('<?= htmlspecialchars($course['thumbnail']) ?>')"></div>
                        <?php else: ?>
                            <div class="h-40 bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center">
                                <i class="fas fa-book text-white text-5xl opacity-50"></i>
                            </div>
                        <?php endif; ?>

                        <!-- Course Info -->
                        <div class="p-4">
                            <h3 class="font-bold text-gray-900 mb-2"><?= htmlspecialchars($course['title']) ?></h3>
                            
                            <?php if (!empty($course['description'])): ?>
                                <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                                    <?= htmlspecialchars(substr($course['description'], 0, 100)) ?><?= strlen($course['description']) > 100 ? '...' : '' ?>
                                </p>
                            <?php endif; ?>

                            <!-- Course Meta -->
                            <div class="flex items-center justify-between text-sm text-gray-600 mb-3">
                                <?php if (!empty($course['level'])): ?>
                                    <span class="flex items-center gap-1">
                                        <i class="fas fa-signal"></i>
                                        <?= ucfirst($course['level']) ?>
                                    </span>
                                <?php endif; ?>
                                <?php if (!empty($course['duration_hours'])): ?>
                                    <span class="flex items-center gap-1">
                                        <i class="fas fa-clock"></i>
                                        <?= $course['duration_hours'] ?>h
                                    </span>
                                <?php endif; ?>
                            </div>

                            <!-- Enrollment Status -->
                            <?php 
                            $isEnrolled = false;
                            $enrollmentProgress = 0;
                            $enrollmentStatus = 'not_started';
                            foreach ($enrollments as $enrollment) {
                                if ($enrollment['course_id'] == $course['id']) {
                                    $isEnrolled = true;
                                    $enrollmentProgress = $enrollment['progress'] ?? 0;
                                    $enrollmentStatus = $enrollment['status'] ?? 'active';
                                    break;
                                }
                            }
                            ?>

                            <!-- Progress Bar -->
                            <div class="mb-3">
                                <div class="flex items-center justify-between text-sm mb-1">
                                    <span class="text-gray-600">Your Progress</span>
                                    <span class="font-semibold text-purple-600"><?= round($enrollmentProgress) ?>%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-purple-600 h-2 rounded-full transition-all" style="width: <?= round($enrollmentProgress) ?>%"></div>
                                </div>
                            </div>

                            <!-- Action Button -->
                            <?php if ($enrollmentProgress > 0): ?>
                                <a href="<?= url('/courses/' . $course['slug']) ?>" 
                                   class="block w-full text-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-medium">
                                    <i class="fas fa-play mr-2"></i>Continue Learning
                                </a>
                            <?php else: ?>
                                <a href="<?= url('/courses/' . $course['slug']) ?>" 
                                   class="block w-full text-center px-4 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg hover:from-purple-700 hover:to-indigo-700 transition font-medium shadow-md">
                                    <i class="fas fa-rocket mr-2"></i>Start Course
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Cohort Members -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-gray-900">
                <i class="fas fa-users text-purple-600 mr-2"></i>Your Cohort
            </h2>
            <span class="text-sm text-gray-600">
                <?= count($students) ?> <?= count($students) === 1 ? 'Member' : 'Members' ?>
            </span>
        </div>
    </div>
    <div class="p-6">
        <?php if (empty($students)): ?>
            <div class="text-center py-12">
                <i class="fas fa-users text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-600">No other members yet. You're among the first!</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <?php foreach ($students as $student): ?>
                    <div class="flex flex-col items-center text-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                        <!-- Avatar -->
                        <?php if (!empty($student['avatar'])): ?>
                            <img src="<?= htmlspecialchars($student['avatar']) ?>" 
                                 alt="<?= htmlspecialchars($student['first_name']) ?>"
                                 class="w-16 h-16 rounded-full object-cover mb-2">
                        <?php else: ?>
                            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center text-white font-bold text-lg mb-2">
                                <?= strtoupper(substr($student['first_name'], 0, 1) . substr($student['last_name'], 0, 1)) ?>
                            </div>
                        <?php endif; ?>

                        <!-- Student Info -->
                        <p class="font-semibold text-gray-900 text-sm">
                            <?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/dashboard.php';
?>
