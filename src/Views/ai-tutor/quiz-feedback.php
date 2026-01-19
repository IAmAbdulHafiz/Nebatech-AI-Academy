<?php
/**
 * Quiz Feedback View
 * 
 * @var array $feedback AI-generated feedback data
 * @var array $attempt Quiz attempt details
 * @var array $quiz Quiz details
 * @var array $lesson Lesson details
 */

$score = $feedback['score'] ?? 0;
$passed = $feedback['passed'] ?? false;
$feedbackText = $feedback['feedback'] ?? 'No feedback available.';
$topicsToReview = $feedback['topics_to_review'] ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Feedback | Nebatech Software Solutions Ltd</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <style>
        .feedback-content h3 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1f2937;
            margin-top: 1.5rem;
            margin-bottom: 0.75rem;
        }
        .feedback-content p {
            margin-bottom: 1rem;
            line-height: 1.7;
        }
        .feedback-content ol, .feedback-content ul {
            margin-left: 1.5rem;
            margin-bottom: 1rem;
        }
        .feedback-content li {
            margin-bottom: 0.5rem;
        }
        .feedback-content strong {
            color: #4f46e5;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">

    <!-- Header -->
    <header class="bg-white border-b border-gray-200 py-4 px-6 shadow-sm">
        <div class="max-w-4xl mx-auto flex items-center justify-between">
            <div>
                <a href="<?= url('/dashboard') ?>" class="text-gray-500 hover:text-gray-700 text-sm mb-1 inline-block">
                    <i class="fas fa-arrow-left mr-1"></i> Back to Dashboard
                </a>
                <h1 class="text-xl font-bold text-gray-900">
                    <i class="fas fa-robot text-purple-600 mr-2"></i>AI Quiz Feedback
                </h1>
            </div>
        </div>
    </header>

    <main class="py-8 px-6">
        <div class="max-w-4xl mx-auto">
            
            <!-- Score Card -->
            <div class="bg-white rounded-xl shadow-sm p-8 mb-6 text-center">
                <div class="w-32 h-32 mx-auto mb-6 rounded-full flex items-center justify-center <?= $passed ? 'bg-green-100' : 'bg-yellow-100' ?>">
                    <span class="text-5xl font-bold <?= $passed ? 'text-green-600' : 'text-yellow-600' ?>">
                        <?= $score ?>%
                    </span>
                </div>
                
                <?php if ($passed): ?>
                    <h2 class="text-2xl font-bold text-green-700 mb-2">
                        <i class="fas fa-trophy mr-2"></i>Congratulations!
                    </h2>
                    <p class="text-gray-600">You passed the quiz! Great job understanding the material.</p>
                <?php else: ?>
                    <h2 class="text-2xl font-bold text-yellow-700 mb-2">
                        <i class="fas fa-book-reader mr-2"></i>Keep Learning!
                    </h2>
                    <p class="text-gray-600">Review the AI feedback below to improve your understanding.</p>
                <?php endif; ?>
                
                <?php if (!empty($topicsToReview)): ?>
                    <div class="mt-4">
                        <span class="text-sm text-gray-500">Topics to review:</span>
                        <div class="flex flex-wrap justify-center gap-2 mt-2">
                            <?php foreach ($topicsToReview as $topic): ?>
                                <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-sm">
                                    <?= htmlspecialchars($topic) ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- AI Feedback -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-6 py-4">
                    <h2 class="text-white font-semibold flex items-center">
                        <i class="fas fa-comments mr-2"></i>
                        Personalized Feedback from AI Tutor
                    </h2>
                </div>
                <div class="p-6">
                    <div id="feedback-content" class="feedback-content text-gray-700 prose max-w-none">
                        <!-- Feedback will be rendered here -->
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-6 flex justify-center gap-4">
                <?php if (isset($lesson['id'])): ?>
                    <a href="<?= url('/courses/' . ($lesson['course_slug'] ?? '') . '/lesson/' . $lesson['id']) ?>" 
                       class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-semibold">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Lesson
                    </a>
                    <a href="<?= url('/quiz/' . $lesson['id']) ?>" 
                       class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-semibold">
                        <i class="fas fa-redo mr-2"></i>Try Quiz Again
                    </a>
                <?php else: ?>
                    <a href="<?= url('/dashboard') ?>" 
                       class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-semibold">
                        <i class="fas fa-home mr-2"></i>Go to Dashboard
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <script>
        // Render the markdown feedback
        const feedbackText = <?= json_encode($feedbackText) ?>;
        document.getElementById('feedback-content').innerHTML = marked.parse(feedbackText);
    </script>
</body>
</html>
