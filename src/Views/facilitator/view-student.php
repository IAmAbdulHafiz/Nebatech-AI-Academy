<?php
$title = 'Student Profile';
ob_start();
include __DIR__ . '/../partials/facilitator-sidebar.php';
$sidebarContent = ob_get_clean();
ob_start();
?>
<div x-data="{ activeTab: 'overview' }">
<!-- Page Header -->
<div class="mb-6">
    <div class="flex items-center gap-4">
        <a href="<?= url('/facilitator/students') ?>" class="text-gray-600 hover:text-gray-800">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Student Profile</h1>
            <p class="text-sm text-gray-600"><?= htmlspecialchars($student['email']) ?></p>
        </div>
    </div>
</div>

<!-- Student Header Card -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <div class="flex items-center gap-6">
                        <div class="h-24 w-24 flex-shrink-0">
                            <?php if ($student['avatar']): ?>
                                <img class="h-24 w-24 rounded-full object-cover" src="<?= url('/' . $student['avatar']) ?>" alt="">
                            <?php else: ?>
                                <div class="h-24 w-24 rounded-full bg-primary text-white flex items-center justify-center font-semibold text-3xl">
                                    <?= strtoupper(substr($student['first_name'], 0, 1) . substr($student['last_name'], 0, 1)) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="flex-1">
                            <h2 class="text-3xl font-bold text-gray-800 mb-2">
                                <?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?>
                            </h2>
                            <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                                <span><i class="fas fa-envelope mr-2"></i><?= htmlspecialchars($student['email']) ?></span>
                                <?php if ($student['phone']): ?>
                                    <span><i class="fas fa-phone mr-2"></i><?= htmlspecialchars($student['phone']) ?></span>
                                <?php endif; ?>
                                <span><i class="fas fa-calendar mr-2"></i>Joined <?= date('M Y', strtotime($student['created_at'])) ?></span>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full <?= $student['status'] === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' ?>">
                                <?= ucfirst($student['status']) ?>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Enrolled Courses</p>
                                <p class="text-2xl font-bold text-blue-600"><?= count($enrollments) ?></p>
                            </div>
                            <div class="bg-blue-100 p-3 rounded-full">
                                <i class="fas fa-book text-blue-600 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Submissions</p>
                                <p class="text-2xl font-bold text-green-600"><?= count($submissions) ?></p>
                            </div>
                            <div class="bg-green-100 p-3 rounded-full">
                                <i class="fas fa-file-alt text-green-600 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Avg Progress</p>
                                <p class="text-2xl font-bold text-purple-600">
                                    <?php
                                    $avgProgress = !empty($enrollments) ? array_sum(array_column($enrollments, 'progress')) / count($enrollments) : 0;
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
                                <p class="text-sm text-gray-600">Cohorts</p>
                                <p class="text-2xl font-bold text-orange-600"><?= count($cohorts) ?></p>
                            </div>
                            <div class="bg-orange-100 p-3 rounded-full">
                                <i class="fas fa-user-friends text-orange-600 text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabs -->
                <div class="bg-white rounded-lg shadow mb-6">
                    <div class="border-b border-gray-200">
                        <nav class="flex -mb-px">
                            <button @click="activeTab = 'overview'" 
                                    :class="activeTab === 'overview' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                    class="px-6 py-4 border-b-2 font-medium text-sm transition">
                                Overview
                            </button>
                            <button @click="activeTab = 'enrollments'" 
                                    :class="activeTab === 'enrollments' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                    class="px-6 py-4 border-b-2 font-medium text-sm transition">
                                Enrollments
                            </button>
                            <button @click="activeTab = 'submissions'" 
                                    :class="activeTab === 'submissions' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                    class="px-6 py-4 border-b-2 font-medium text-sm transition">
                                Submissions
                            </button>
                            <button @click="activeTab = 'cohorts'" 
                                    :class="activeTab === 'cohorts' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                    class="px-6 py-4 border-b-2 font-medium text-sm transition">
                                Cohorts
                            </button>
                        </nav>
                    </div>

                    <!-- Tab Content -->
                    <div class="p-6">
                        
                        <!-- Overview Tab -->
                        <div x-show="activeTab === 'overview'" class="space-y-6">
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <!-- Recent Activity -->
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Submissions</h3>
                                    <?php if (empty($submissions)): ?>
                                        <p class="text-gray-600">No submissions yet.</p>
                                    <?php else: ?>
                                        <div class="space-y-3">
                                            <?php foreach (array_slice($submissions, 0, 5) as $submission): ?>
                                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                                    <div class="flex-1">
                                                        <p class="font-medium text-gray-800"><?= htmlspecialchars($submission['assignment_title']) ?></p>
                                                        <p class="text-sm text-gray-600"><?= htmlspecialchars($submission['course_title']) ?></p>
                                                    </div>
                                                    <div class="text-right">
                                                        <?php
                                                        $statusColors = [
                                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                                            'graded' => 'bg-blue-100 text-blue-800',
                                                            'verified' => 'bg-green-100 text-green-800',
                                                            'revision_needed' => 'bg-red-100 text-red-800'
                                                        ];
                                                        $statusColor = $statusColors[$submission['status']] ?? 'bg-gray-100 text-gray-800';
                                                        ?>
                                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full <?= $statusColor ?>">
                                                            <?= ucwords(str_replace('_', ' ', $submission['status'])) ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Course Progress -->
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Course Progress</h3>
                                    <?php if (empty($enrollments)): ?>
                                        <p class="text-gray-600">Not enrolled in any courses yet.</p>
                                    <?php else: ?>
                                        <div class="space-y-4">
                                            <?php foreach ($enrollments as $enrollment): ?>
                                                <div>
                                                    <div class="flex items-center justify-between mb-2">
                                                        <span class="font-medium text-gray-800"><?= htmlspecialchars($enrollment['course_title']) ?></span>
                                                        <span class="text-sm font-semibold text-primary"><?= number_format($enrollment['progress'], 1) ?>%</span>
                                                    </div>
                                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                                        <div class="bg-primary h-2 rounded-full transition-all" 
                                                             style="width: <?= min(100, $enrollment['progress']) ?>%"></div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Enrollments Tab -->
                        <div x-show="activeTab === 'enrollments'">
                            <?php if (empty($enrollments)): ?>
                                <p class="text-gray-600">No enrollments found.</p>
                            <?php else: ?>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <?php foreach ($enrollments as $enrollment): ?>
                                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                                            <?php if ($enrollment['thumbnail']): ?>
                                                <img src="<?= url('/' . $enrollment['thumbnail']) ?>" alt="" class="w-full h-40 object-cover rounded-lg mb-4">
                                            <?php endif; ?>
                                            <h4 class="font-semibold text-gray-800 mb-2"><?= htmlspecialchars($enrollment['course_title']) ?></h4>
                                            <div class="flex items-center justify-between text-sm mb-3">
                                                <span class="text-gray-600">Progress</span>
                                                <span class="font-semibold text-primary"><?= number_format($enrollment['progress'], 1) ?>%</span>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-2 mb-3">
                                                <div class="bg-primary h-2 rounded-full" style="width: <?= min(100, $enrollment['progress']) ?>%"></div>
                                            </div>
                                            <div class="flex items-center justify-between text-xs text-gray-500">
                                                <span>Enrolled: <?= date('M d, Y', strtotime($enrollment['enrolled_at'])) ?></span>
                                                <span class="px-2 py-1 rounded-full <?= $enrollment['status'] === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' ?>">
                                                    <?= ucfirst($enrollment['status']) ?>
                                                </span>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Submissions Tab -->
                        <div x-show="activeTab === 'submissions'">
                            <?php if (empty($submissions)): ?>
                                <p class="text-gray-600">No submissions found.</p>
                            <?php else: ?>
                                <div class="overflow-x-auto">
                                    <table class="w-full">
                                        <thead class="bg-gray-50 border-b">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Assignment</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Course</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Submitted</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Score</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <?php foreach ($submissions as $submission): ?>
                                                <tr class="hover:bg-gray-50">
                                                    <td class="px-6 py-4">
                                                        <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($submission['assignment_title']) ?></div>
                                                        <div class="text-sm text-gray-500"><?= htmlspecialchars($submission['lesson_title']) ?></div>
                                                    </td>
                                                    <td class="px-6 py-4 text-sm text-gray-900"><?= htmlspecialchars($submission['course_title']) ?></td>
                                                    <td class="px-6 py-4 text-sm text-gray-500"><?= date('M d, Y', strtotime($submission['submitted_at'])) ?></td>
                                                    <td class="px-6 py-4">
                                                        <?php
                                                        $statusColors = [
                                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                                            'graded' => 'bg-blue-100 text-blue-800',
                                                            'verified' => 'bg-green-100 text-green-800',
                                                            'revision_needed' => 'bg-red-100 text-red-800'
                                                        ];
                                                        $statusColor = $statusColors[$submission['status']] ?? 'bg-gray-100 text-gray-800';
                                                        ?>
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $statusColor ?>">
                                                            <?= ucwords(str_replace('_', ' ', $submission['status'])) ?>
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 text-sm text-gray-900">
                                                        <?php if ($submission['facilitator_score']): ?>
                                                            <?= number_format($submission['facilitator_score'], 1) ?>%
                                                        <?php else: ?>
                                                            <span class="text-gray-400">-</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="px-6 py-4 text-sm">
                                                        <a href="<?= url('/facilitator/submissions/' . $submission['id']) ?>" class="text-primary hover:text-primary-dark">
                                                            Review
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Cohorts Tab -->
                        <div x-show="activeTab === 'cohorts'">
                            <?php if (empty($cohorts)): ?>
                                <p class="text-gray-600">Not assigned to any cohorts.</p>
                            <?php else: ?>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <?php foreach ($cohorts as $cohort): ?>
                                        <div class="border border-gray-200 rounded-lg p-6">
                                            <h4 class="font-semibold text-gray-800 mb-2"><?= htmlspecialchars($cohort['name']) ?></h4>
                                            <div class="space-y-2 text-sm text-gray-600">
                                                <p><i class="fas fa-graduation-cap mr-2"></i><?= htmlspecialchars($cohort['program']) ?></p>
                                                <p><i class="fas fa-user mr-2"></i><?= htmlspecialchars($cohort['facilitator_first_name'] . ' ' . $cohort['facilitator_last_name']) ?></p>
                                                <p><i class="fas fa-calendar mr-2"></i>Starts: <?= date('M d, Y', strtotime($cohort['start_date'])) ?></p>
                                                <p>
                                                    <span class="px-2 py-1 rounded-full text-xs font-semibold <?= $cohort['status'] === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' ?>">
                                                        <?= ucfirst($cohort['status']) ?>
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/dashboard.php';
?>
