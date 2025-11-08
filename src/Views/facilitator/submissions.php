<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?> - Nebatech AI Academy</title>
    <link rel="stylesheet" href="<?= asset('css/main.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    
    <?php include __DIR__ . '/../partials/header.php'; ?>

    <div class="max-w-7xl mx-auto px-4 py-8">
        
        <!-- Page Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Review Submissions</h1>
                <p class="text-gray-600 mt-1">Manage and grade student assignments</p>
            </div>
            <a href="<?= url('/facilitator/dashboard') ?>" class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>

        <!-- Stats Summary -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow p-4 border-l-4 border-yellow-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Pending Review</p>
                        <p class="text-2xl font-bold text-gray-900">
                            <?= count(array_filter($submissions, fn($s) => $s['status'] === 'submitted')) ?>
                        </p>
                    </div>
                    <i class="fas fa-clock text-yellow-500 text-2xl"></i>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-4 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Graded</p>
                        <p class="text-2xl font-bold text-gray-900">
                            <?= count(array_filter($submissions, fn($s) => $s['status'] === 'graded')) ?>
                        </p>
                    </div>
                    <i class="fas fa-check-circle text-blue-500 text-2xl"></i>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-4 border-l-4 border-orange-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Needs Revision</p>
                        <p class="text-2xl font-bold text-gray-900">
                            <?= count(array_filter($submissions, fn($s) => $s['status'] === 'revision_requested')) ?>
                        </p>
                    </div>
                    <i class="fas fa-redo text-orange-500 text-2xl"></i>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-4 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Total Submissions</p>
                        <p class="text-2xl font-bold text-gray-900"><?= count($submissions) ?></p>
                    </div>
                    <i class="fas fa-clipboard-list text-green-500 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow p-4 mb-6">
            <form method="GET" action="<?= url('/facilitator/submissions') ?>" class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="all" <?= $currentStatus === 'all' ? 'selected' : '' ?>>All Submissions</option>
                        <option value="submitted" <?= $currentStatus === 'submitted' ? 'selected' : '' ?>>Pending Review</option>
                        <option value="graded" <?= $currentStatus === 'graded' ? 'selected' : '' ?>>Graded</option>
                        <option value="revision_requested" <?= $currentStatus === 'revision_requested' ? 'selected' : '' ?>>Needs Revision</option>
                    </select>
                </div>
                
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Course</label>
                    <select name="course_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">All Courses</option>
                        <?php foreach ($courses as $course): ?>
                            <option value="<?= $course['id'] ?>" <?= $currentCourseId == $course['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($course['title']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="flex items-end">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        <i class="fas fa-filter"></i> Apply Filters
                    </button>
                </div>
            </form>
        </div>

        <!-- Submissions Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <?php if (empty($submissions)): ?>
                <div class="text-center py-12">
                    <i class="fas fa-inbox text-gray-300 text-6xl mb-4"></i>
                    <p class="text-gray-600 text-lg">No submissions found</p>
                    <p class="text-gray-500 text-sm mt-2">Submissions will appear here when students complete assignments</p>
                </div>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Student
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Assignment
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Course
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Submitted
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Score
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($submissions as $submission): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <?php if ($submission['avatar']): ?>
                                                <img src="<?= htmlspecialchars($submission['avatar']) ?>" 
                                                     alt="Avatar" 
                                                     class="w-8 h-8 rounded-full mr-3">
                                            <?php else: ?>
                                                <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold mr-3">
                                                    <?= strtoupper(substr($submission['first_name'], 0, 1)) ?>
                                                </div>
                                            <?php endif; ?>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">
                                                    <?= htmlspecialchars($submission['first_name'] . ' ' . $submission['last_name']) ?>
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    <?= htmlspecialchars($submission['email']) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            <?= htmlspecialchars($submission['assignment_title']) ?>
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            <?= htmlspecialchars($submission['lesson_title']) ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            <?= htmlspecialchars($submission['course_title']) ?>
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            <?= htmlspecialchars($submission['module_title']) ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            <?= date('M d, Y', strtotime($submission['submitted_at'])) ?>
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            <?= date('g:i A', strtotime($submission['submitted_at'])) ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?php if ($submission['score'] !== null): ?>
                                            <div class="text-sm font-semibold <?= 
                                                ($submission['score'] / $submission['max_score'] * 100) >= 70 
                                                    ? 'text-green-600' 
                                                    : 'text-orange-600' 
                                            ?>">
                                                <?= $submission['score'] ?>/<?= $submission['max_score'] ?>
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                <?= round(($submission['score'] / $submission['max_score']) * 100, 1) ?>%
                                            </div>
                                        <?php else: ?>
                                            <span class="text-sm text-gray-400">Not graded</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?php
                                        $statusClasses = [
                                            'submitted' => 'bg-yellow-100 text-yellow-800',
                                            'graded' => 'bg-blue-100 text-blue-800',
                                            'revision_requested' => 'bg-orange-100 text-orange-800',
                                            'pending' => 'bg-gray-100 text-gray-800'
                                        ];
                                        $statusIcons = [
                                            'submitted' => 'fa-clock',
                                            'graded' => 'fa-check-circle',
                                            'revision_requested' => 'fa-redo',
                                            'pending' => 'fa-hourglass-half'
                                        ];
                                        $statusClass = $statusClasses[$submission['status']] ?? 'bg-gray-100 text-gray-800';
                                        $statusIcon = $statusIcons[$submission['status']] ?? 'fa-question-circle';
                                        ?>
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full <?= $statusClass ?>">
                                            <i class="fas <?= $statusIcon ?> mr-1"></i>
                                            <?= ucwords(str_replace('_', ' ', $submission['status'])) ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="<?= url('/facilitator/submissions/' . $submission['id'] . '/review') ?>" 
                                           class="text-blue-600 hover:text-blue-900 mr-3">
                                            <i class="fas fa-eye"></i> Review
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>
