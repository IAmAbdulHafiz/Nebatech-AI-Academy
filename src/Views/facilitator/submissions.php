<?php
$title = 'Student Submissions';
ob_start();
include __DIR__ . '/../partials/facilitator-sidebar.php';
$sidebarContent = ob_get_clean();
ob_start();
?>
<!-- Page Header -->
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Student Submissions</h1>
    <p class="text-sm text-gray-600">Review and grade student work</p>
</div>
                
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-6">
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Total</p>
                                <p class="text-2xl font-bold text-gray-800"><?= $stats['total'] ?? 0 ?></p>
                            </div>
                            <div class="bg-blue-100 p-3 rounded-full">
                                <i class="fas fa-file-alt text-blue-600 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Pending</p>
                                <p class="text-2xl font-bold text-yellow-600"><?= $stats['pending'] ?? 0 ?></p>
                            </div>
                            <div class="bg-yellow-100 p-3 rounded-full">
                                <i class="fas fa-clock text-yellow-600 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Graded</p>
                                <p class="text-2xl font-bold text-blue-600"><?= $stats['graded'] ?? 0 ?></p>
                            </div>
                            <div class="bg-blue-100 p-3 rounded-full">
                                <i class="fas fa-check text-blue-600 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Verified</p>
                                <p class="text-2xl font-bold text-green-600"><?= $stats['verified'] ?? 0 ?></p>
                            </div>
                            <div class="bg-green-100 p-3 rounded-full">
                                <i class="fas fa-check-double text-green-600 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Avg Score</p>
                                <p class="text-2xl font-bold text-purple-600"><?= number_format($stats['average_score'] ?? 0, 1) ?>%</p>
                            </div>
                            <div class="bg-purple-100 p-3 rounded-full">
                                <i class="fas fa-star text-purple-600 text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <form method="GET" class="flex flex-wrap gap-4">
                        <div class="flex-1 min-w-[200px]">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                <option value="all" <?= ($currentStatus ?? 'all') === 'all' ? 'selected' : '' ?>>All Submissions</option>
                                <option value="pending" <?= ($currentStatus ?? '') === 'pending' ? 'selected' : '' ?>>Pending Review</option>
                                <option value="graded" <?= ($currentStatus ?? '') === 'graded' ? 'selected' : '' ?>>Graded</option>
                                <option value="verified" <?= ($currentStatus ?? '') === 'verified' ? 'selected' : '' ?>>Verified</option>
                                <option value="revision_needed" <?= ($currentStatus ?? '') === 'revision_needed' ? 'selected' : '' ?>>Needs Revision</option>
                            </select>
                        </div>

                        <div class="flex-1 min-w-[200px]">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Course</label>
                            <select name="course_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                <option value="">All Courses</option>
                                <?php foreach ($courses as $course): ?>
                                    <option value="<?= $course['id'] ?>" <?= ($currentCourseId ?? 0) == $course['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($course['title']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="flex items-end">
                            <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition">
                                <i class="fas fa-filter mr-2"></i>Filter
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Submissions Table -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <?php if (empty($submissions)): ?>
                        <div class="p-12 text-center">
                            <i class="fas fa-inbox text-gray-400 text-6xl mb-4"></i>
                            <h3 class="text-xl font-semibold text-gray-700 mb-2">No Submissions Found</h3>
                            <p class="text-gray-600">There are no submissions matching your filters.</p>
                        </div>
                    <?php else: ?>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50 border-b">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assignment</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Submitted</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Score</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php foreach ($submissions as $submission): ?>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="h-10 w-10 flex-shrink-0">
                                                        <?php if ($submission['avatar']): ?>
                                                            <img class="h-10 w-10 rounded-full object-cover" src="<?= url('/' . $submission['avatar']) ?>" alt="">
                                                        <?php else: ?>
                                                            <div class="h-10 w-10 rounded-full bg-primary text-white flex items-center justify-center font-semibold">
                                                                <?= strtoupper(substr($submission['first_name'], 0, 1) . substr($submission['last_name'], 0, 1)) ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            <?= htmlspecialchars($submission['first_name'] . ' ' . $submission['last_name']) ?>
                                                        </div>
                                                        <div class="text-sm text-gray-500"><?= htmlspecialchars($submission['email']) ?></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900"><?= htmlspecialchars($submission['assignment_title']) ?></div>
                                                <div class="text-sm text-gray-500"><?= htmlspecialchars($submission['lesson_title']) ?></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900"><?= htmlspecialchars($submission['course_title']) ?></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <?= date('M d, Y', strtotime($submission['submitted_at'])) ?>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
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
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <?php if ($submission['facilitator_score']): ?>
                                                    <span class="font-semibold"><?= number_format($submission['facilitator_score'], 1) ?>%</span>
                                                <?php elseif ($submission['ai_score']): ?>
                                                    <span class="text-gray-500">AI: <?= number_format($submission['ai_score'], 1) ?>%</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="<?= url('/facilitator/submissions/' . $submission['id']) ?>" class="text-primary hover:text-primary-dark">
                                                    <i class="fas fa-eye mr-1"></i>Review
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>


<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/dashboard.php';
?>
