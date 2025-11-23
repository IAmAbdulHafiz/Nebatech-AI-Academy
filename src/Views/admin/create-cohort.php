<?php
$title = 'Create New Cohort';
ob_start();
include __DIR__ . '/../partials/admin-sidebar.php';
$sidebarContent = ob_get_clean();
ob_start();
?>

<!-- Page Header -->
<div class="mb-6">
    <div class="flex items-center gap-4 mb-4">
        <a href="<?= url('/admin/cohorts') ?>" class="text-gray-600 hover:text-primary">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Create New Cohort</h1>
            <p class="text-gray-600">Set up a new learning cohort for students</p>
        </div>
    </div>
</div>

<!-- Create Form -->
<div class="max-w-4xl">
    <form method="POST" action="<?= url('/admin/cohorts/create') ?>" class="bg-white rounded-lg shadow-sm border border-gray-200">
        <?= csrf_field() ?>
        <div class="p-6 space-y-6">
            <!-- Cohort Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Cohort Name <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                    placeholder="e.g., Frontend Dev - January 2025">
                <p class="mt-1 text-sm text-gray-500">Give your cohort a descriptive name</p>
            </div>

            <!-- Program -->
            <div>
                <label for="program" class="block text-sm font-medium text-gray-700 mb-2">
                    Program <span class="text-red-500">*</span>
                </label>
                <select id="program" name="program" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                    <option value="">Select a program</option>
                    <?php foreach ($programs as $slug => $program): ?>
                        <option value="<?= $slug ?>">
                            <?= htmlspecialchars($program['name']) ?> (<?= $program['duration_weeks'] ?> weeks)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Facilitator -->
            <div>
                <label for="facilitator_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Facilitator
                </label>
                <select id="facilitator_id" name="facilitator_id"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                    <option value="">Assign later</option>
                    <?php foreach ($facilitators as $facilitator): ?>
                        <option value="<?= $facilitator['id'] ?>">
                            <?= htmlspecialchars($facilitator['first_name'] . ' ' . $facilitator['last_name']) ?>
                            (<?= htmlspecialchars($facilitator['email']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Dates -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">
                        Start Date <span class="text-red-500">*</span>
                    </label>
                    <input type="date" id="start_date" name="start_date" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                        min="<?= date('Y-m-d') ?>">
                </div>

                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">
                        End Date
                    </label>
                    <input type="date" id="end_date" name="end_date"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>
            </div>

            <!-- Max Students & Status -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="max_students" class="block text-sm font-medium text-gray-700 mb-2">
                        Maximum Students
                    </label>
                    <input type="number" id="max_students" name="max_students" value="30" min="1" max="100"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                    <p class="mt-1 text-sm text-gray-500">Default: 30 students</p>
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        Status
                    </label>
                    <select id="status" name="status"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                        <option value="upcoming">Upcoming</option>
                        <option value="active">Active</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Description
                </label>
                <textarea id="description" name="description" rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                    placeholder="Add any additional information about this cohort..."></textarea>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-3">
            <a href="<?= url('/admin/cohorts') ?>" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2 bg-primary hover:bg-primary-dark text-white rounded-lg font-semibold transition">
                <i class="fas fa-plus mr-2"></i>Create Cohort
            </button>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/dashboard.php';
?>
