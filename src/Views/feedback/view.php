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

    <div class="max-w-6xl mx-auto px-4 py-8">
        
        <!-- Back Navigation -->
        <div class="mb-6">
            <a href="<?= url('/dashboard') ?>" class="text-blue-600 hover:text-blue-800">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>

        <!-- Assignment Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex items-start justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">
                        <?= htmlspecialchars($submission['assignment_title']) ?>
                    </h1>
                    <p class="text-gray-600">
                        <?= htmlspecialchars($submission['course_title']) ?> • 
                        <?= htmlspecialchars($submission['module_title']) ?>
                    </p>
                </div>
                <div class="text-right">
                    <div class="text-sm text-gray-500 mb-2">
                        Submitted: <?= date('M d, Y g:i A', strtotime($submission['submitted_at'])) ?>
                    </div>
                    <?php if ($submission['graded_at']): ?>
                        <div class="text-sm text-gray-500">
                            Graded: <?= date('M d, Y g:i A', strtotime($submission['graded_at'])) ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php if (!$feedback): ?>
            <!-- No Feedback Yet -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 text-center">
                <i class="fas fa-clock text-yellow-500 text-4xl mb-3"></i>
                <h2 class="text-xl font-semibold text-yellow-800 mb-2">Feedback Pending</h2>
                <p class="text-yellow-700">
                    Your assignment is being reviewed. AI feedback will be available shortly.
                </p>
                <button onclick="window.location.reload()" class="mt-4 px-6 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700">
                    <i class="fas fa-sync-alt"></i> Refresh Page
                </button>
            </div>
        <?php else: ?>
            
            <!-- Score Card -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-md p-6 text-white">
                    <div class="text-sm font-medium mb-2">Your Score</div>
                    <div class="text-4xl font-bold">
                        <?= $feedback['score'] ?>/<span class="text-2xl"><?= $feedback['max_score'] ?></span>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-md p-6 text-white">
                    <div class="text-sm font-medium mb-2">Percentage</div>
                    <div class="text-4xl font-bold"><?= $feedback['percentage'] ?>%</div>
                </div>
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-md p-6 text-white">
                    <div class="text-sm font-medium mb-2">Grade</div>
                    <div class="text-2xl font-bold"><?= $feedback['grade_level'] ?></div>
                </div>
                <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg shadow-md p-6 text-white">
                    <div class="text-sm font-medium mb-2">Status</div>
                    <div class="text-xl font-bold">
                        <?php if ($feedback['percentage'] >= 70): ?>
                            <i class="fas fa-check-circle"></i> Passed
                        <?php else: ?>
                            <i class="fas fa-exclamation-circle"></i> Review
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- AI Feedback Section -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                    <i class="fas fa-robot text-blue-600"></i> AI Feedback
                </h2>
                
                <!-- Overall Feedback -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Overall Assessment</h3>
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                        <p class="text-gray-700 leading-relaxed">
                            <?= nl2br(htmlspecialchars($feedback['ai_feedback']['overall_feedback'])) ?>
                        </p>
                    </div>
                </div>

                <!-- Strengths -->
                <?php if (!empty($feedback['ai_feedback']['strengths'])): ?>
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-green-800 mb-3">
                            <i class="fas fa-thumbs-up"></i> Strengths
                        </h3>
                        <ul class="space-y-2">
                            <?php foreach ($feedback['ai_feedback']['strengths'] as $strength): ?>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                    <span class="text-gray-700"><?= htmlspecialchars($strength) ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- Areas for Improvement -->
                <?php if (!empty($feedback['ai_feedback']['improvements'])): ?>
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-orange-800 mb-3">
                            <i class="fas fa-exclamation-triangle"></i> Areas for Improvement
                        </h3>
                        <ul class="space-y-2">
                            <?php foreach ($feedback['ai_feedback']['improvements'] as $improvement): ?>
                                <li class="flex items-start">
                                    <i class="fas fa-arrow-right text-orange-500 mt-1 mr-2"></i>
                                    <span class="text-gray-700"><?= htmlspecialchars($improvement) ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- Suggestions -->
                <?php if (!empty($feedback['ai_feedback']['suggestions'])): ?>
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-blue-800 mb-3">
                            <i class="fas fa-lightbulb"></i> Suggestions for Next Steps
                        </h3>
                        <ul class="space-y-2">
                            <?php foreach ($feedback['ai_feedback']['suggestions'] as $suggestion): ?>
                                <li class="flex items-start">
                                    <i class="fas fa-star text-blue-500 mt-1 mr-2"></i>
                                    <span class="text-gray-700"><?= htmlspecialchars($suggestion) ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Code Validation Results -->
            <?php if ($feedback['validation']['has_issues']): ?>
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">
                        <i class="fas fa-code text-purple-600"></i> Code Validation
                    </h2>
                    
                    <div class="mb-4">
                        <p class="text-gray-700">
                            <i class="fas fa-info-circle text-blue-500"></i> 
                            <?= htmlspecialchars($feedback['validation']['summary']) ?>
                        </p>
                    </div>

                    <?php foreach ($feedback['validation']['issues'] as $category => $issues): ?>
                        <div class="mb-4">
                            <h3 class="text-lg font-semibold text-gray-800 mb-2 capitalize">
                                <?= htmlspecialchars($category) ?> Issues
                            </h3>
                            <ul class="space-y-2">
                                <?php foreach ($issues as $issue): ?>
                                    <li class="flex items-start p-3 rounded <?= 
                                        $issue['severity'] === 'error' ? 'bg-red-50 border-l-4 border-red-500' :
                                        ($issue['severity'] === 'warning' ? 'bg-yellow-50 border-l-4 border-yellow-500' : 
                                        'bg-blue-50 border-l-4 border-blue-500') 
                                    ?>">
                                        <i class="fas <?= 
                                            $issue['severity'] === 'error' ? 'fa-times-circle text-red-500' :
                                            ($issue['severity'] === 'warning' ? 'fa-exclamation-triangle text-yellow-500' : 
                                            'fa-info-circle text-blue-500') 
                                        ?> mt-1 mr-2"></i>
                                        <div>
                                            <span class="font-semibold text-gray-700 capitalize"><?= $issue['severity'] ?>:</span>
                                            <span class="text-gray-700"><?= htmlspecialchars($issue['message']) ?></span>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <!-- No Issues -->
                <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 text-3xl mr-4"></i>
                        <div>
                            <h3 class="text-lg font-semibold text-green-800">Clean Code!</h3>
                            <p class="text-green-700"><?= htmlspecialchars($feedback['validation']['summary']) ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Actions -->
            <div class="flex items-center justify-between bg-white rounded-lg shadow-md p-6">
                <div class="text-sm text-gray-600">
                    <i class="fas fa-clock"></i> 
                    Feedback generated on <?= date('M d, Y g:i A', strtotime($feedback['generated_at'])) ?>
                </div>
                <div class="flex space-x-3">
                    <a href="<?= url('/assignments/' . $submission['assignment_id'] . '/code-editor') ?>" 
                       class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        <i class="fas fa-code"></i> View My Code
                    </a>
                    <?php if ($feedback['percentage'] < 70): ?>
                        <a href="<?= url('/assignments/' . $submission['assignment_id'] . '/code-editor') ?>" 
                           class="px-6 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700">
                            <i class="fas fa-redo"></i> Resubmit Assignment
                        </a>
                    <?php endif; ?>
                </div>
            </div>

        <?php endif; ?>
    </div>

    <?php include __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>
