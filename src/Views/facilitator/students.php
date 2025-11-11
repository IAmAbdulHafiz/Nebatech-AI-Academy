<?php
$title = 'My Students';
ob_start();
include __DIR__ . '/../partials/facilitator-sidebar.php';
$sidebarContent = ob_get_clean();
ob_start();
?>
<div x-data="{ searchQuery: '' }">
<!-- Page Header -->
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">My Students</h1>
    <p class="text-sm text-gray-600">Track student progress and performance</p>
</div>
                
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Total Students</p>
                                <p class="text-2xl font-bold text-gray-800"><?= count($students) ?></p>
                            </div>
                            <div class="bg-blue-100 p-3 rounded-full">
                                <i class="fas fa-user-graduate text-blue-600 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Active Courses</p>
                                <p class="text-2xl font-bold text-green-600"><?= count($courses) ?></p>
                            </div>
                            <div class="bg-green-100 p-3 rounded-full">
                                <i class="fas fa-book text-green-600 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Avg Progress</p>
                                <p class="text-2xl font-bold text-purple-600">
                                    <?php
                                    $avgProgress = !empty($students) ? array_sum(array_column($students, 'average_progress')) / count($students) : 0;
                                    echo number_format($avgProgress, 1);
                                    ?>%
                                </p>
                            </div>
                            <div class="bg-purple-100 p-3 rounded-full">
                                <i class="fas fa-chart-line text-purple-600 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Enrollments</p>
                                <p class="text-2xl font-bold text-orange-600">
                                    <?= !empty($students) ? array_sum(array_column($students, 'enrolled_courses')) : 0 ?>
                                </p>
                            </div>
                            <div class="bg-orange-100 p-3 rounded-full">
                                <i class="fas fa-clipboard-check text-orange-600 text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Search and Filter -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <div class="flex gap-4">
                        <div class="flex-1">
                            <div class="relative">
                                <input type="text" x-model="searchQuery" 
                                       placeholder="Search students by name or email..." 
                                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Students Grid -->
                <?php if (empty($students)): ?>
                    <div class="bg-white rounded-lg shadow p-12 text-center">
                        <i class="fas fa-user-graduate text-gray-400 text-6xl mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-700 mb-2">No Students Yet</h3>
                        <p class="text-gray-600">Students will appear here once they enroll in your courses.</p>
                    </div>
                <?php else: ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php foreach ($students as $student): ?>
                            <div class="bg-white rounded-lg shadow hover:shadow-lg transition" 
                                 x-show="searchQuery === '' || 
                                         '<?= strtolower($student['first_name'] . ' ' . $student['last_name'] . ' ' . $student['email']) ?>'.includes(searchQuery.toLowerCase())">
                                <div class="p-6">
                                    <div class="flex items-center gap-4 mb-4">
                                        <div class="h-16 w-16 flex-shrink-0">
                                            <?php if ($student['avatar']): ?>
                                                <img class="h-16 w-16 rounded-full object-cover" src="<?= url('/' . $student['avatar']) ?>" alt="">
                                            <?php else: ?>
                                                <div class="h-16 w-16 rounded-full bg-primary text-white flex items-center justify-center font-semibold text-xl">
                                                    <?= strtoupper(substr($student['first_name'], 0, 1) . substr($student['last_name'], 0, 1)) ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h3 class="text-lg font-semibold text-gray-800 truncate">
                                                <?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?>
                                            </h3>
                                            <p class="text-sm text-gray-600 truncate"><?= htmlspecialchars($student['email']) ?></p>
                                        </div>
                                    </div>

                                    <div class="space-y-3 mb-4">
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="text-gray-600">Enrolled Courses</span>
                                            <span class="font-semibold text-gray-800"><?= $student['enrolled_courses'] ?></span>
                                        </div>
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="text-gray-600">Average Progress</span>
                                            <span class="font-semibold text-primary"><?= number_format($student['average_progress'], 1) ?>%</span>
                                        </div>
                                    </div>

                                    <!-- Progress Bar -->
                                    <div class="mb-4">
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-primary h-2 rounded-full transition-all" 
                                                 style="width: <?= min(100, $student['average_progress']) ?>%"></div>
                                        </div>
                                    </div>

                                    <a href="<?= url('/facilitator/students/' . $student['id']) ?>" 
                                       class="block w-full text-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition">
                                        <i class="fas fa-eye mr-2"></i>View Details
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/dashboard.php';
?>
