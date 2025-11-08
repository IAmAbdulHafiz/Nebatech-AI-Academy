<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Applications - Nebatech AI Academy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <?php include __DIR__ . '/../partials/header.php'; ?>

    <div class="max-w-6xl mx-auto px-4 py-12">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">
                <i class="fas fa-file-alt text-purple-600 mr-2"></i>
                My Applications
            </h1>
            <p class="text-gray-600">Track the status of your program applications</p>
        </div>

        <?php if (empty($applications)): ?>
            <!-- Empty State -->
            <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                <div class="text-6xl mb-4">📋</div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">No Applications Yet</h2>
                <p class="text-gray-600 mb-6">You haven't applied for any programs yet.</p>
                <a href="<?= url('/courses') ?>" 
                   class="inline-block px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-800 text-white rounded-lg hover:from-purple-700 hover:to-purple-900 transition font-semibold">
                    <i class="fas fa-search mr-2"></i>Browse Programs
                </a>
            </div>
        <?php else: ?>
            <!-- Applications List -->
            <div class="space-y-6">
                <?php foreach ($applications as $app): ?>
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition">
                        <div class="p-6">
                            <div class="flex items-start justify-between">
                                <!-- Program Info -->
                                <div class="flex-1">
                                    <div class="flex items-center mb-3">
                                        <?php if ($app['thumbnail']): ?>
                                            <img src="<?= url('/public/assets/images/' . $app['thumbnail']) ?>" 
                                                 alt="<?= htmlspecialchars($app['program_name']) ?>"
                                                 class="w-16 h-16 rounded-lg object-cover mr-4">
                                        <?php else: ?>
                                            <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-700 rounded-lg flex items-center justify-center text-white text-2xl mr-4">
                                                <i class="fas fa-book"></i>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <div>
                                            <h3 class="text-xl font-bold text-gray-900">
                                                <?= htmlspecialchars($app['program_name']) ?>
                                            </h3>
                                            <p class="text-sm text-gray-500">
                                                Application ID: <span class="font-mono"><?= htmlspecialchars($app['uuid']) ?></span>
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <!-- Timeline -->
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                                        <div>
                                            <p class="text-xs text-gray-500 mb-1">Submitted</p>
                                            <p class="text-sm font-medium text-gray-900">
                                                <i class="fas fa-calendar mr-1"></i>
                                                <?= date('M j, Y', strtotime($app['submitted_at'])) ?>
                                            </p>
                                        </div>
                                        
                                        <?php if ($app['reviewed_at']): ?>
                                        <div>
                                            <p class="text-xs text-gray-500 mb-1">Reviewed</p>
                                            <p class="text-sm font-medium text-gray-900">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                <?= date('M j, Y', strtotime($app['reviewed_at'])) ?>
                                            </p>
                                        </div>
                                        <?php endif; ?>
                                        
                                        <?php if ($app['enrolled_at']): ?>
                                        <div>
                                            <p class="text-xs text-gray-500 mb-1">Enrolled</p>
                                            <p class="text-sm font-medium text-green-600">
                                                <i class="fas fa-graduation-cap mr-1"></i>
                                                <?= date('M j, Y', strtotime($app['enrolled_at'])) ?>
                                            </p>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <!-- Status Badge -->
                                <div class="ml-6 text-right">
                                    <?php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'under_review' => 'bg-blue-100 text-blue-800',
                                        'approved' => 'bg-green-100 text-green-800',
                                        'rejected' => 'bg-red-100 text-red-800',
                                        'waitlisted' => 'bg-purple-100 text-purple-800'
                                    ];
                                    $statusIcons = [
                                        'pending' => 'fa-clock',
                                        'under_review' => 'fa-search',
                                        'approved' => 'fa-check-circle',
                                        'rejected' => 'fa-times-circle',
                                        'waitlisted' => 'fa-list'
                                    ];
                                    $bgColor = $statusColors[$app['status']] ?? 'bg-gray-100 text-gray-800';
                                    $icon = $statusIcons[$app['status']] ?? 'fa-question-circle';
                                    ?>
                                    
                                    <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold <?= $bgColor ?> mb-4">
                                        <i class="fas <?= $icon ?> mr-1"></i>
                                        <?= ucwords(str_replace('_', ' ', $app['status'])) ?>
                                    </span>
                                    
                                    <?php if ($app['priority'] !== 'normal'): ?>
                                        <div class="text-xs text-gray-500">
                                            Priority: <span class="font-semibold"><?= ucfirst($app['priority']) ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <!-- Rejection Reason (if applicable) -->
                            <?php if ($app['status'] === 'rejected' && $app['rejection_reason']): ?>
                                <div class="mt-4 p-4 bg-red-50 border-l-4 border-red-500 rounded">
                                    <p class="text-sm text-red-800">
                                        <strong>Reason:</strong> <?= htmlspecialchars($app['rejection_reason']) ?>
                                    </p>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Approval Info (if applicable) -->
                            <?php if ($app['status'] === 'approved' && $app['cohort_name']): ?>
                                <div class="mt-4 p-4 bg-green-50 border-l-4 border-green-500 rounded">
                                    <p class="text-sm text-green-800">
                                        <i class="fas fa-users mr-2"></i>
                                        <strong>Cohort:</strong> <?= htmlspecialchars($app['cohort_name']) ?> 
                                        (<?= htmlspecialchars($app['cohort_code']) ?>)
                                    </p>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Actions -->
                            <div class="mt-6 flex items-center justify-between pt-4 border-t">
                                <div class="text-sm text-gray-500">
                                    <?php if ($app['status'] === 'pending'): ?>
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Your application is being reviewed. You'll be notified via email.
                                    <?php elseif ($app['status'] === 'under_review'): ?>
                                        <i class="fas fa-eye mr-1"></i>
                                        Your application is currently under review by our admissions team.
                                    <?php elseif ($app['status'] === 'approved'): ?>
                                        <i class="fas fa-check-circle mr-1 text-green-600"></i>
                                        Congratulations! You've been enrolled in the program.
                                    <?php elseif ($app['status'] === 'waitlisted'): ?>
                                        <i class="fas fa-clock mr-1"></i>
                                        You're on the waitlist. We'll notify you if a spot opens up.
                                    <?php endif; ?>
                                </div>
                                
                                <div class="flex gap-3">
                                    <a href="<?= url('/applications/' . $app['uuid']) ?>" 
                                       class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition text-sm font-medium">
                                        <i class="fas fa-eye mr-1"></i>View Details
                                    </a>
                                    
                                    <?php if ($app['status'] === 'approved'): ?>
                                        <a href="<?= url('/dashboard') ?>" 
                                           class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium">
                                            <i class="fas fa-arrow-right mr-1"></i>Go to Dashboard
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Apply for More Programs -->
            <div class="mt-8 text-center">
                <a href="<?= url('/courses') ?>" 
                   class="inline-block px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-semibold">
                    <i class="fas fa-plus mr-2"></i>Apply for Another Program
                </a>
            </div>
        <?php endif; ?>
    </div>

    <?php include __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>
