<?php
$title = 'My Cohorts';
ob_start();
include __DIR__ . '/../partials/student-sidebar.php';
$sidebarContent = ob_get_clean();
ob_start();
?>

<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">My Cohorts</h1>
    <p class="text-gray-600">View your cohort groups and schedules</p>
</div>

<!-- Cohorts Grid -->
<?php if (empty($cohorts)): ?>
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
        <i class="fas fa-users text-6xl text-gray-300 mb-4"></i>
        <h3 class="text-xl font-bold text-gray-900 mb-2">No Cohorts</h3>
        <p class="text-gray-600 mb-6">You haven't been assigned to any cohorts yet.</p>
    </div>
<?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($cohorts as $cohort): ?>
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition">
                <!-- Cohort Header -->
                <div class="h-32 bg-gradient-to-br from-purple-500 to-purple-700 flex items-center justify-center relative">
                    <i class="fas fa-users text-white text-5xl opacity-50"></i>
                    
                    <!-- Status Badge -->
                    <?php
                    $statusConfig = [
                        'upcoming' => ['bg' => 'bg-blue-500', 'text' => 'Upcoming'],
                        'active' => ['bg' => 'bg-green-500', 'text' => 'Active'],
                        'completed' => ['bg' => 'bg-gray-500', 'text' => 'Completed']
                    ];
                    $config = $statusConfig[$cohort['status']] ?? ['bg' => 'bg-gray-500', 'text' => 'Unknown'];
                    ?>
                    <div class="absolute top-3 right-3 <?= $config['bg'] ?> text-white px-3 py-1 rounded-full text-xs font-bold">
                        <?= $config['text'] ?>
                    </div>
                </div>

                <!-- Cohort Info -->
                <div class="p-6">
                    <h3 class="font-bold text-gray-900 text-xl mb-2"><?= htmlspecialchars($cohort['name']) ?></h3>
                    <p class="text-sm text-gray-600 mb-4"><?= htmlspecialchars($cohort['program']) ?></p>
                    
                    <!-- Facilitator -->
                    <?php if (!empty($cohort['facilitator_first_name'])): ?>
                        <div class="flex items-center gap-2 mb-4 text-sm text-gray-700">
                            <i class="fas fa-chalkboard-teacher text-purple-600"></i>
                            <span><?= htmlspecialchars($cohort['facilitator_first_name'] . ' ' . $cohort['facilitator_last_name']) ?></span>
                        </div>
                    <?php endif; ?>

                    <!-- Dates -->
                    <div class="flex items-center justify-between text-sm text-gray-600 mb-4 pb-4 border-b border-gray-200">
                        <div>
                            <i class="fas fa-calendar-start mr-1"></i>
                            <span><?= date('M d, Y', strtotime($cohort['start_date'])) ?></span>
                        </div>
                        <?php if (!empty($cohort['end_date'])): ?>
                            <div>
                                <i class="fas fa-calendar-check mr-1"></i>
                                <span><?= date('M d, Y', strtotime($cohort['end_date'])) ?></span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="text-center p-3 bg-purple-50 rounded-lg">
                            <div class="text-2xl font-bold text-purple-600"><?= $cohort['student_count'] ?></div>
                            <div class="text-xs text-gray-600">Students</div>
                        </div>
                        <div class="text-center p-3 bg-indigo-50 rounded-lg">
                            <div class="text-2xl font-bold text-indigo-600">
                                <?php
                                // Get course count for this cohort
                                $cohortCourses = \Nebatech\Models\Cohort::getCourses($cohort['id']);
                                echo count($cohortCourses);
                                ?>
                            </div>
                            <div class="text-xs text-gray-600">Courses</div>
                        </div>
                    </div>

                    <!-- View Details Button -->
                    <a href="<?= url('/cohorts/' . $cohort['id']) ?>" 
                       class="block w-full text-center px-4 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-medium">
                        <i class="fas fa-eye mr-2"></i>View Details
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/dashboard.php';
?>
