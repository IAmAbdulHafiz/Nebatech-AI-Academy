<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applications Management - Nebatech AI Academy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <?php include __DIR__ . '/../../partials/header.php'; ?>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">
                <i class="fas fa-file-alt text-purple-600 mr-2"></i>
                Applications Management
            </h1>
            <p class="text-gray-600">Review and manage student applications</p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Total Applications</p>
                        <p class="text-3xl font-bold text-gray-900"><?= $stats['total'] ?></p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-file-alt text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-yellow-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Pending Review</p>
                        <p class="text-3xl font-bold text-gray-900"><?= $stats['pending'] + $stats['under_review'] ?></p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-clock text-yellow-600 text-xl"></i>
                    </div>
                </div>
                <?php if ($stats['urgent'] > 0): ?>
                    <p class="text-xs text-red-600 mt-2 font-semibold">
                        <i class="fas fa-exclamation-triangle"></i> <?= $stats['urgent'] ?> urgent
                    </p>
                <?php endif; ?>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Approved</p>
                        <p class="text-3xl font-bold text-gray-900"><?= $stats['approved'] ?></p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-red-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Rejected</p>
                        <p class="text-3xl font-bold text-gray-900"><?= $stats['rejected'] ?></p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-times-circle text-red-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Filters Sidebar -->
            <div class="lg:w-64 flex-shrink-0">
                <div class="bg-white rounded-xl shadow-lg p-6 sticky top-4">
                    <h3 class="font-bold text-gray-900 mb-4">
                        <i class="fas fa-filter mr-2"></i>Filters
                    </h3>
                    
                    <form method="GET" action="<?= url('/admin/applications') ?>" class="space-y-4">
                        <!-- Status Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 text-sm">
                                <option value="">All Status</option>
                                <option value="pending" <?= $filters['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                                <option value="under_review" <?= $filters['status'] === 'under_review' ? 'selected' : '' ?>>Under Review</option>
                                <option value="approved" <?= $filters['status'] === 'approved' ? 'selected' : '' ?>>Approved</option>
                                <option value="rejected" <?= $filters['status'] === 'rejected' ? 'selected' : '' ?>>Rejected</option>
                                <option value="waitlisted" <?= $filters['status'] === 'waitlisted' ? 'selected' : '' ?>>Waitlisted</option>
                            </select>
                        </div>

                        <!-- Priority Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Priority</label>
                            <select name="priority" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 text-sm">
                                <option value="">All Priorities</option>
                                <option value="urgent" <?= $filters['priority'] === 'urgent' ? 'selected' : '' ?>>Urgent</option>
                                <option value="high" <?= $filters['priority'] === 'high' ? 'selected' : '' ?>>High</option>
                                <option value="normal" <?= $filters['priority'] === 'normal' ? 'selected' : '' ?>>Normal</option>
                                <option value="low" <?= $filters['priority'] === 'low' ? 'selected' : '' ?>>Low</option>
                            </select>
                        </div>

                        <!-- Program Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Program</label>
                            <select name="program_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 text-sm">
                                <option value="">All Programs</option>
                                <?php foreach ($programs as $program): ?>
                                    <option value="<?= $program['id'] ?>" <?= $filters['program_id'] == $program['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($program['title']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Search -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                            <input type="text" name="search" value="<?= htmlspecialchars($filters['search']) ?>"
                                   placeholder="Name or email..."
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 text-sm">
                        </div>

                        <!-- Action Buttons -->
                        <div class="space-y-2">
                            <button type="submit" class="w-full px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition text-sm font-medium">
                                <i class="fas fa-search mr-2"></i>Apply Filters
                            </button>
                            <a href="<?= url('/admin/applications') ?>" 
                               class="block w-full px-4 py-2 bg-gray-200 text-gray-700 text-center rounded-lg hover:bg-gray-300 transition text-sm font-medium">
                                <i class="fas fa-redo mr-2"></i>Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Applications List -->
            <div class="flex-1">
                <?php if (empty($applications)): ?>
                    <!-- Empty State -->
                    <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                        <div class="text-6xl mb-4">📭</div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">No Applications Found</h2>
                        <p class="text-gray-600 mb-4">
                            <?php if (!empty($filters['status']) || !empty($filters['search'])): ?>
                                No applications match your current filters.
                            <?php else: ?>
                                There are no applications in the system yet.
                            <?php endif; ?>
                        </p>
                    </div>
                <?php else: ?>
                    <!-- Applications Table -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50 border-b">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Applicant
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Program
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Submitted
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Priority
                                        </th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    <?php foreach ($applications as $app): ?>
                                        <tr class="hover:bg-gray-50 transition">
                                            <!-- Applicant -->
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <?php if ($app['avatar']): ?>
                                                        <img src="<?= url('/public/assets/images/' . $app['avatar']) ?>" 
                                                             alt="<?= htmlspecialchars($app['first_name']) ?>"
                                                             class="w-10 h-10 rounded-full mr-3">
                                                    <?php else: ?>
                                                        <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center mr-3">
                                                            <span class="text-purple-600 font-bold">
                                                                <?= strtoupper(substr($app['first_name'], 0, 1)) ?>
                                                            </span>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-900">
                                                            <?= htmlspecialchars($app['first_name'] . ' ' . $app['last_name']) ?>
                                                        </p>
                                                        <p class="text-xs text-gray-500"><?= htmlspecialchars($app['email']) ?></p>
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- Program -->
                                            <td class="px-6 py-4">
                                                <p class="text-sm text-gray-900"><?= htmlspecialchars($app['program_name']) ?></p>
                                            </td>

                                            <!-- Submitted -->
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <p class="text-sm text-gray-900">
                                                    <?= date('M j, Y', strtotime($app['submitted_at'])) ?>
                                                </p>
                                                <p class="text-xs text-gray-500">
                                                    <?= date('g:i A', strtotime($app['submitted_at'])) ?>
                                                </p>
                                            </td>

                                            <!-- Status -->
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <?php
                                                $statusColors = [
                                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                                    'under_review' => 'bg-blue-100 text-blue-800',
                                                    'approved' => 'bg-green-100 text-green-800',
                                                    'rejected' => 'bg-red-100 text-red-800',
                                                    'waitlisted' => 'bg-purple-100 text-purple-800'
                                                ];
                                                $bgColor = $statusColors[$app['status']] ?? 'bg-gray-100 text-gray-800';
                                                ?>
                                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full <?= $bgColor ?>">
                                                    <?= ucwords(str_replace('_', ' ', $app['status'])) ?>
                                                </span>
                                            </td>

                                            <!-- Priority -->
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <select onchange="updatePriority(<?= $app['id'] ?>, this.value)" 
                                                        class="text-xs border-0 bg-transparent focus:ring-0 cursor-pointer font-semibold
                                                        <?= $app['priority'] === 'urgent' ? 'text-red-600' : ($app['priority'] === 'high' ? 'text-orange-600' : 'text-gray-600') ?>">
                                                    <option value="urgent" <?= $app['priority'] === 'urgent' ? 'selected' : '' ?>>Urgent</option>
                                                    <option value="high" <?= $app['priority'] === 'high' ? 'selected' : '' ?>>High</option>
                                                    <option value="normal" <?= $app['priority'] === 'normal' ? 'selected' : '' ?>>Normal</option>
                                                    <option value="low" <?= $app['priority'] === 'low' ? 'selected' : '' ?>>Low</option>
                                                </select>
                                            </td>

                                            <!-- Actions -->
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="<?= url('/admin/applications/' . $app['id'] . '/review') ?>" 
                                                   class="inline-block px-3 py-1 bg-purple-600 text-white rounded hover:bg-purple-700 transition">
                                                    <i class="fas fa-eye mr-1"></i>Review
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <?php if ($totalPages > 1): ?>
                            <div class="bg-gray-50 px-6 py-4 border-t flex items-center justify-between">
                                <div class="text-sm text-gray-700">
                                    Showing page <strong><?= $currentPage ?></strong> of <strong><?= $totalPages ?></strong>
                                    (<?= $total ?> total applications)
                                </div>
                                <div class="flex gap-2">
                                    <?php if ($currentPage > 1): ?>
                                        <a href="?<?= http_build_query(array_merge($filters, ['page' => $currentPage - 1])) ?>" 
                                           class="px-3 py-1 bg-white border border-gray-300 rounded hover:bg-gray-50 transition">
                                            <i class="fas fa-chevron-left"></i>
                                        </a>
                                    <?php endif; ?>
                                    
                                    <?php for ($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++): ?>
                                        <a href="?<?= http_build_query(array_merge($filters, ['page' => $i])) ?>" 
                                           class="px-3 py-1 border rounded transition <?= $i === $currentPage ? 'bg-purple-600 text-white border-purple-600' : 'bg-white border-gray-300 hover:bg-gray-50' ?>">
                                            <?= $i ?>
                                        </a>
                                    <?php endfor; ?>
                                    
                                    <?php if ($currentPage < $totalPages): ?>
                                        <a href="?<?= http_build_query(array_merge($filters, ['page' => $currentPage + 1])) ?>" 
                                           class="px-3 py-1 bg-white border border-gray-300 rounded hover:bg-gray-50 transition">
                                            <i class="fas fa-chevron-right"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        async function updatePriority(applicationId, priority) {
            try {
                const response = await fetch('<?= url('/admin/applications/priority') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        application_id: applicationId,
                        priority: priority
                    })
                });

                const data = await response.json();
                if (data.success) {
                    // Show success feedback (optional)
                    console.log('Priority updated');
                } else {
                    alert('Failed to update priority');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred');
            }
        }
    </script>

    <?php include __DIR__ . '/../../partials/footer.php'; ?>
</body>
</html>
