<?php
/**
 * CBT Sidebar Component
 * Shows learning objectives, quiz, and practical for a lesson
 * 
 * @var array $lesson Current lesson
 * @var array $learningObjectives Learning objectives for this lesson
 * @var array $practical Practical exercise for this lesson
 * @var array $quiz Quiz for this lesson
 * @var array $lessonProgress Current lesson progress
 */

$lessonId = $lesson['id'] ?? 0;
$hasObjectives = !empty($learningObjectives);
$hasPractical = !empty($practical);
$hasQuiz = !empty($quiz);
?>

<div class="bg-white rounded-xl shadow-sm overflow-hidden" x-data="{ 
    activeTab: 'objectives',
    hintContent: null,
    hintsUsed: 0,
    lessonId: <?= $lessonId ?>,
    async requestHint() {
        if (this.hintsUsed >= 3) {
            alert('You have used all available hints. Try asking the AI Tutor for more help!');
            return;
        }
        try {
            const response = await fetch('/ai-tutor/hint', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ practical_id: this.lessonId })
            });
            const data = await response.json();
            if (data.success) {
                this.hintContent = data.hint;
                this.hintsUsed = data.hint_level;
            } else {
                alert(data.message || data.error || 'Unable to get hint');
            }
        } catch (error) {
            console.error('Hint request failed:', error);
            alert('Unable to get hint. Please try again.');
        }
    }
}">
    <!-- Tab Navigation -->
    <div class="flex border-b border-gray-200">
        <button @click="activeTab = 'objectives'" 
                :class="activeTab === 'objectives' ? 'border-indigo-500 text-indigo-600 bg-indigo-50' : 'border-transparent text-gray-500 hover:text-gray-700'"
                class="flex-1 py-3 px-4 text-sm font-medium border-b-2 transition">
            <i class="fas fa-bullseye mr-1"></i>
            Objectives
        </button>
        <?php if ($hasQuiz): ?>
        <button @click="activeTab = 'quiz'" 
                :class="activeTab === 'quiz' ? 'border-indigo-500 text-indigo-600 bg-indigo-50' : 'border-transparent text-gray-500 hover:text-gray-700'"
                class="flex-1 py-3 px-4 text-sm font-medium border-b-2 transition">
            <i class="fas fa-question-circle mr-1"></i>
            Quiz
        </button>
        <?php endif; ?>
        <?php if ($hasPractical): ?>
        <button @click="activeTab = 'practical'" 
                :class="activeTab === 'practical' ? 'border-indigo-500 text-indigo-600 bg-indigo-50' : 'border-transparent text-gray-500 hover:text-gray-700'"
                class="flex-1 py-3 px-4 text-sm font-medium border-b-2 transition">
            <i class="fas fa-laptop-code mr-1"></i>
            Practical
        </button>
        <?php endif; ?>
    </div>

    <!-- Learning Objectives Tab -->
    <div x-show="activeTab === 'objectives'" class="p-4">
        <h4 class="font-semibold text-gray-900 mb-3 flex items-center">
            <i class="fas fa-graduation-cap text-indigo-500 mr-2"></i>
            Learning Objectives
        </h4>
        
        <?php if ($hasObjectives): ?>
        <ul class="space-y-3">
            <?php foreach ($learningObjectives as $index => $objective): ?>
            <li class="flex items-start gap-3 text-sm">
                <span class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center flex-shrink-0 text-xs font-semibold">
                    <?= $index + 1 ?>
                </span>
                <div>
                    <p class="text-gray-700"><?= htmlspecialchars($objective['objective_text']) ?></p>
                    <span class="inline-block mt-1 px-2 py-0.5 bg-gray-100 text-gray-500 text-xs rounded">
                        <?= ucfirst($objective['bloom_level']) ?>
                    </span>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php else: ?>
        <p class="text-gray-500 text-sm">No learning objectives defined for this lesson.</p>
        <?php endif; ?>
    </div>

    <!-- Quiz Tab -->
    <?php if ($hasQuiz): ?>
    <div x-show="activeTab === 'quiz'" class="p-4">
        <div class="text-center py-6">
            <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-question-circle text-3xl text-indigo-500"></i>
            </div>
            <h4 class="font-semibold text-gray-900 mb-2"><?= htmlspecialchars($quiz['title']) ?></h4>
            <p class="text-gray-500 text-sm mb-4"><?= htmlspecialchars($quiz['description'] ?? 'Test your understanding of this lesson') ?></p>
            
            <div class="flex justify-center gap-4 text-sm text-gray-600 mb-4">
                <span><i class="fas fa-list mr-1"></i><?= $quiz['question_count'] ?? 5 ?> Questions</span>
                <?php if (!empty($quiz['time_limit_minutes'])): ?>
                <span><i class="fas fa-clock mr-1"></i><?= $quiz['time_limit_minutes'] ?> min</span>
                <?php endif; ?>
                <span><i class="fas fa-check mr-1"></i><?= $quiz['passing_score'] ?? 70 ?>% to pass</span>
            </div>
            
            <?php if (!empty($quizAttempt)): ?>
                <?php if ($quizAttempt['passed']): ?>
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                    <div class="text-green-700 font-semibold mb-1">
                        <i class="fas fa-trophy mr-1"></i> Passed!
                    </div>
                    <div class="text-green-600 text-2xl font-bold"><?= $quizAttempt['score'] ?>%</div>
                </div>
                <?php else: ?>
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                    <div class="text-yellow-700 font-semibold mb-1">
                        <i class="fas fa-redo mr-1"></i> Keep trying!
                    </div>
                    <div class="text-yellow-600">Last score: <?= $quizAttempt['score'] ?>%</div>
                </div>
                <?php endif; ?>
            <?php endif; ?>
            
            <a href="<?= url('/quiz/' . $lessonId) ?>" 
               class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition">
                <i class="fas fa-play mr-2"></i>
                <?= !empty($quizAttempt) ? 'Retake Quiz' : 'Start Quiz' ?>
            </a>
        </div>
    </div>
    <?php endif; ?>

    <!-- Practical Tab -->
    <?php if ($hasPractical): ?>
    <div x-show="activeTab === 'practical'" class="p-4">
        <div class="mb-4">
            <div class="flex items-center justify-between mb-2">
                <h4 class="font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-laptop-code text-green-500 mr-2"></i>
                    <?= htmlspecialchars($practical['title']) ?>
                </h4>
                <span class="px-2 py-1 bg-<?= $practical['difficulty'] === 'beginner' ? 'green' : ($practical['difficulty'] === 'intermediate' ? 'yellow' : 'red') ?>-100 text-<?= $practical['difficulty'] === 'beginner' ? 'green' : ($practical['difficulty'] === 'intermediate' ? 'yellow' : 'red') ?>-700 text-xs rounded-full">
                    <?= ucfirst($practical['difficulty']) ?>
                </span>
            </div>
            <p class="text-gray-600 text-sm"><?= htmlspecialchars($practical['description']) ?></p>
        </div>

        <div class="bg-gray-50 rounded-lg p-4 mb-4">
            <h5 class="font-medium text-gray-700 mb-2">Instructions</h5>
            <div class="text-sm text-gray-600 prose prose-sm max-w-none markdown-content" 
                 id="practical-instructions-content"
                 data-markdown="<?= htmlspecialchars($practical['instructions'] ?? '', ENT_QUOTES) ?>">
                <!-- Loading... -->
            </div>
        </div>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const el = document.getElementById('practical-instructions-content');
            if (el && typeof marked !== 'undefined') {
                const md = el.getAttribute('data-markdown');
                el.innerHTML = marked.parse(md || '');
            }
        });
        </script>

        <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
            <span><i class="fas fa-clock mr-1"></i>~<?= $practical['estimated_time_minutes'] ?? 30 ?> min</span>
            <span><i class="fas fa-star mr-1"></i>Max <?= $practical['max_points'] ?? 100 ?> pts</span>
        </div>

        <?php if (!empty($practicalSubmission)): ?>
            <?php if ($practicalSubmission['status'] === 'approved'): ?>
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                <div class="text-green-700 font-semibold mb-1">
                    <i class="fas fa-check-circle mr-1"></i> Approved!
                </div>
                <div class="text-green-600">Score: <?= $practicalSubmission['score'] ?>/<?= $practical['max_points'] ?? 100 ?></div>
            </div>
            <?php elseif ($practicalSubmission['status'] === 'pending'): ?>
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                <div class="text-yellow-700">
                    <i class="fas fa-hourglass-half mr-1"></i> Submission pending review
                </div>
            </div>
            <?php else: ?>
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                <div class="text-red-700 font-semibold mb-1">
                    <i class="fas fa-times-circle mr-1"></i> Needs revision
                </div>
                <div class="text-red-600 text-sm"><?= htmlspecialchars($practicalSubmission['feedback'] ?? '') ?></div>
            </div>
            <?php endif; ?>
        <?php endif; ?>

        <div class="flex gap-3">
            <a href="<?= url('/practical/' . $lessonId) ?>" 
               class="flex-1 inline-flex items-center justify-center px-4 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition">
                <i class="fas fa-code mr-2"></i>
                <?= !empty($practicalSubmission) ? 'Continue Working' : 'Start Practical' ?>
            </a>
            
            <button @click="requestHint()" 
                    class="px-4 py-3 bg-gray-100 text-gray-700 rounded-lg font-semibold hover:bg-gray-200 transition"
                    title="Get a hint from AI Tutor">
                <i class="fas fa-lightbulb text-yellow-500"></i>
            </button>
        </div>
        
        <!-- Hint Display -->
        <div x-show="hintContent" x-cloak class="mt-4 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex items-start gap-3">
                <i class="fas fa-lightbulb text-yellow-500 mt-1"></i>
                <div>
                    <div class="font-medium text-yellow-800 mb-1">Hint (<?= 3 - ($hintCount ?? 0) ?> remaining)</div>
                    <p class="text-yellow-700 text-sm" x-text="hintContent"></p>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- AI Tutor Quick Access -->
<div class="bg-gradient-to-br from-indigo-600 to-purple-700 rounded-xl shadow-sm p-5 mt-6 text-white">
    <div class="flex items-center gap-3 mb-3">
        <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
            <i class="fas fa-robot"></i>
        </div>
        <div>
            <h4 class="font-semibold">Need Help?</h4>
            <p class="text-white/80 text-sm">Ask the AI Tutor</p>
        </div>
    </div>
    <p class="text-white/70 text-sm mb-4">
        Get personalized guidance, concept explanations, and hints without spoiling the answers.
    </p>
    <a href="<?= url('/ai-tutor?lesson=' . $lessonId) ?>" 
       class="inline-flex items-center px-4 py-2 bg-white text-indigo-700 rounded-lg font-semibold hover:bg-gray-100 transition text-sm">
        <i class="fas fa-comments mr-2"></i>
        Chat with Tutor
    </a>
</div>
