<?php
$title = 'Course Management';
ob_start();
include __DIR__ . '/../partials/admin-sidebar.php';
$sidebarContent = ob_get_clean();
ob_start();
?>

<!-- Page Header -->
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Course Management</h1>
    <p class="text-gray-600">Oversee and manage all courses across the platform</p>
</div>

<!-- Stats Overview -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <div class="text-sm text-gray-600 mb-1">Total Courses</div>
        <div class="text-2xl font-bold text-gray-900"><?= $stats['total'] ?></div>
    </div>
    <div class="bg-green-50 rounded-lg border border-green-200 p-4">
        <div class="text-sm text-green-700 mb-1">Published</div>
        <div class="text-2xl font-bold text-green-900"><?= $stats['published'] ?></div>
    </div>
    <div class="bg-yellow-50 rounded-lg border border-yellow-200 p-4">
        <div class="text-sm text-yellow-700 mb-1">Draft</div>
        <div class="text-2xl font-bold text-yellow-900"><?= $stats['draft'] ?></div>
    </div>
    <div class="bg-gray-50 rounded-lg border border-gray-200 p-4">
        <div class="text-sm text-gray-700 mb-1">Archived</div>
        <div class="text-2xl font-bold text-gray-900"><?= $stats['archived'] ?></div>
    </div>
</div>

<!-- Filters -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
    <form method="GET" class="flex flex-wrap gap-4">
        <!-- Status Filter -->
        <div class="flex-1 min-w-[200px]">
            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
            <select name="status" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary focus:border-transparent">
                <option value="">All Statuses</option>
                <option value="published" <?= ($currentStatus ?? '') === 'published' ? 'selected' : '' ?>>Published</option>
                <option value="draft" <?= ($currentStatus ?? '') === 'draft' ? 'selected' : '' ?>>Draft</option>
                <option value="archived" <?= ($currentStatus ?? '') === 'archived' ? 'selected' : '' ?>>Archived</option>
            </select>
        </div>

        <!-- Category Filter -->
        <div class="flex-1 min-w-[200px]">
            <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
            <select name="category" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary focus:border-transparent">
                <option value="">All Categories</option>
                <option value="frontend" <?= ($currentCategory ?? '') === 'frontend' ? 'selected' : '' ?>>Front-End Development</option>
                <option value="backend" <?= ($currentCategory ?? '') === 'backend' ? 'selected' : '' ?>>Back-End Development</option>
                <option value="fullstack" <?= ($currentCategory ?? '') === 'fullstack' ? 'selected' : '' ?>>Full-Stack Development</option>
                <option value="database" <?= ($currentCategory ?? '') === 'database' ? 'selected' : '' ?>>Database</option>
                <option value="ai" <?= ($currentCategory ?? '') === 'ai' ? 'selected' : '' ?>>Artificial Intelligence</option>
                <option value="mobile" <?= ($currentCategory ?? '') === 'mobile' ? 'selected' : '' ?>>Mobile Development</option>
            </select>
        </div>

        <!-- Search -->
        <div class="flex-1 min-w-[200px]">
            <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
            <input type="text" name="search" value="<?= htmlspecialchars($currentSearch ?? '') ?>" 
                   placeholder="Search courses..." class="w-full border border-gray-300 rounded-lg px-4 py-2">
        </div>

        <!-- Actions -->
        <div class="flex items-end gap-2">
            <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-blue-700 transition font-medium">
                <i class="fas fa-filter mr-2"></i>Filter
            </button>
            <a href="<?= url('/admin/courses') ?>" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">
                Clear
            </a>
        </div>
    </form>
</div>

<!-- Courses Table -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Facilitator</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Enrollments</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php if (empty($courses)): ?>
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <i class="fas fa-book text-4xl text-gray-300 mb-3"></i>
                            <p class="text-gray-500">No courses found</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($courses as $course): ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <?php if ($course['thumbnail']): ?>
                                        <img src="<?= url('/' . $course['thumbnail']) ?>" alt="" class="w-12 h-12 rounded object-cover mr-3">
                                    <?php else: ?>
                                        <div class="w-12 h-12 bg-primary text-white rounded flex items-center justify-center font-bold text-sm mr-3">
                                            <?= strtoupper(substr($course['title'], 0, 2)) ?>
                                        </div>
                                    <?php endif; ?>
                                    <div>
                                        <div class="font-semibold text-gray-900"><?= htmlspecialchars($course['title']) ?></div>
                                        <div class="text-sm text-gray-500"><?= $course['duration_hours'] ?> hours</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <?php if (!empty($course['facilitator_first_name'])): ?>
                                    <span class="text-sm text-gray-900">
                                        <?= htmlspecialchars($course['facilitator_first_name'] . ' ' . $course['facilitator_last_name']) ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-sm text-gray-400">No facilitator</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-900"><?= htmlspecialchars(ucwords($course['category'])) ?></span>
                            </td>
                            <td class="px-6 py-4">
                                <?php
                                $statusConfig = [
                                    'published' => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'icon' => 'fa-check-circle'],
                                    'draft' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'icon' => 'fa-edit'],
                                    'archived' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'icon' => 'fa-archive']
                                ];
                                $config = $statusConfig[$course['status']] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'icon' => 'fa-circle'];
                                ?>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium <?= $config['bg'] ?> <?= $config['text'] ?>">
                                    <i class="fas <?= $config['icon'] ?> mr-1"></i>
                                    <?= ucfirst($course['status']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                <?= $course['enrollment_count'] ?? 0 ?>
                            </td>
                            <td class="px-6 py-4">
                                <a href="<?= url('/admin/courses/' . $course['id']) ?>" 
                                   class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                                    <i class="fas fa-eye mr-2"></i>View
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/dashboard.php';
?>
