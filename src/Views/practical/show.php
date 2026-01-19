<?php
/**
 * Practical Exercise View
 * 
 * @var array $practical Practical exercise data
 * @var array $lesson Associated lesson
 * @var array $course Associated course
 * @var array|null $submission Existing submission
 * @var int $hintCount Number of hints used
 * @var int $hintsRemaining Hints remaining
 */

$practicalTitle = $practical['title'] ?? 'Practical Exercise';
$difficulty = $practical['difficulty'] ?? 'beginner';
$difficultyColors = [
    'beginner' => 'bg-green-100 text-green-700',
    'intermediate' => 'bg-yellow-100 text-yellow-700',
    'advanced' => 'bg-red-100 text-red-700'
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($practicalTitle) ?> | Nebatech Software Solutions Ltd</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- CodeMirror for code editing -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/codemirror.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/theme/dracula.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/codemirror.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/javascript/javascript.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/python/python.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/php/php.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/htmlmixed/htmlmixed.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/css/css.min.js"></script>
    <!-- Marked.js for Markdown rendering -->
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <style>
        .CodeMirror { height: 400px; border-radius: 0.5rem; }
        .markdown-content h2 { font-size: 1.25rem; font-weight: 700; margin-top: 1.5rem; margin-bottom: 0.75rem; color: #1f2937; }
        .markdown-content h3 { font-size: 1.1rem; font-weight: 600; margin-top: 1.25rem; margin-bottom: 0.5rem; color: #374151; }
        .markdown-content ul, .markdown-content ol { margin-left: 1.5rem; margin-bottom: 1rem; }
        .markdown-content ul { list-style-type: disc; }
        .markdown-content ol { list-style-type: decimal; }
        .markdown-content li { margin-bottom: 0.5rem; }
        .markdown-content p { margin-bottom: 0.75rem; }
        .markdown-content strong { font-weight: 600; }
        .markdown-content code { background: #f3f4f6; padding: 0.125rem 0.375rem; border-radius: 0.25rem; font-size: 0.875rem; }
        .markdown-content pre { background: #1f2937; color: #f9fafb; padding: 1rem; border-radius: 0.5rem; overflow-x: auto; margin-bottom: 1rem; }
        .markdown-content pre code { background: transparent; padding: 0; color: inherit; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">

<div x-data="practicalApp()" class="min-h-screen flex flex-col">

    <!-- Header -->
    <header class="bg-white border-b border-gray-200 py-4 px-6 shadow-sm">
        <div class="max-w-6xl mx-auto flex items-center justify-between">
            <div>
                <a href="<?= url('/courses/' . ($course['slug'] ?? '') . '/lesson/' . ($lesson['id'] ?? '')) ?>" 
                   class="text-gray-500 hover:text-gray-700 text-sm mb-1 inline-block">
                    <i class="fas fa-arrow-left mr-1"></i> Back to Lesson
                </a>
                <h1 class="text-xl font-bold text-gray-900"><?= htmlspecialchars($practicalTitle) ?></h1>
            </div>
            
            <div class="flex items-center gap-4">
                <span class="px-3 py-1 rounded-full text-sm font-medium <?= $difficultyColors[$difficulty] ?>">
                    <?= ucfirst($difficulty) ?>
                </span>
                <span class="text-sm text-gray-600">
                    <i class="fas fa-clock mr-1"></i>
                    ~<?= $practical['estimated_time_minutes'] ?? 30 ?> min
                </span>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 py-8 px-6">
        <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Column - Instructions -->
            <div class="lg:col-span-1 space-y-6">
                
                <!-- Description Card -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                        Description
                    </h2>
                    <div class="text-gray-700 markdown-content" id="description-content"></div>
                </div>

                <!-- Instructions Card -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-list-ol text-indigo-500 mr-2"></i>
                        Instructions
                    </h2>
                    <div class="prose prose-sm max-w-none text-gray-700 markdown-content" id="instructions-content"></div>
                </div>

                <!-- Expected Outcome -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-bullseye text-green-500 mr-2"></i>
                        Expected Outcome
                    </h2>
                    <div class="text-gray-700 markdown-content" id="outcome-content"></div>
                </div>

                <!-- Hints Section -->
                <div class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-xl p-6 border border-purple-100">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>
                        Need Help?
                    </h2>
                    <p class="text-sm text-gray-600 mb-4">
                        You have <strong><?= $hintsRemaining ?></strong> hints remaining.
                        Hints guide you without giving away the answer.
                    </p>
                    <button @click="getHint()" 
                            :disabled="hintsRemaining <= 0 || isLoadingHint"
                            class="w-full px-4 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-semibold disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fas fa-magic mr-2"></i>
                        <span x-text="isLoadingHint ? 'Getting hint...' : 'Get a Hint'"></span>
                    </button>
                    
                    <!-- Display hints -->
                    <template x-if="hints.length > 0">
                        <div class="mt-4 space-y-3">
                            <template x-for="(hint, index) in hints" :key="index">
                                <div class="bg-white rounded-lg p-4 border border-purple-200">
                                    <div class="flex items-center gap-2 text-purple-700 font-semibold mb-2">
                                        <i class="fas fa-lightbulb"></i>
                                        <span>Hint #<span x-text="index + 1"></span></span>
                                    </div>
                                    <p class="text-gray-700 text-sm" x-text="hint"></p>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Right Column - Code Editor & Submission -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Starter Code (if provided) -->
                <?php if (!empty($practical['starter_code'])): ?>
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="bg-gray-800 px-4 py-3 flex items-center justify-between">
                        <span class="text-gray-300 text-sm font-medium">
                            <i class="fas fa-code mr-2"></i>Starter Code
                        </span>
                        <button onclick="copyStarterCode()" class="text-gray-400 hover:text-white text-sm">
                            <i class="fas fa-copy mr-1"></i>Copy
                        </button>
                    </div>
                    <pre class="bg-gray-900 text-gray-100 p-4 overflow-x-auto text-sm"><code id="starterCode"><?= htmlspecialchars($practical['starter_code']) ?></code></pre>
                </div>
                <?php endif; ?>

                <!-- Code Editor -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="bg-gray-800 px-4 py-3 flex items-center justify-between">
                        <span class="text-gray-300 text-sm font-medium">
                            <i class="fas fa-edit mr-2"></i>Your Solution
                        </span>
                        <select x-model="codeLanguage" @change="changeLanguage()" 
                                class="bg-gray-700 text-gray-200 text-sm rounded px-3 py-1 border-0">
                            <option value="javascript">JavaScript</option>
                            <option value="python">Python</option>
                            <option value="php">PHP</option>
                            <option value="htmlmixed">HTML</option>
                            <option value="css">CSS</option>
                        </select>
                    </div>
                    <textarea id="codeEditor"><?= htmlspecialchars($submission['submitted_code'] ?? $practical['starter_code'] ?? '') ?></textarea>
                </div>

                <!-- Notes -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">
                        <i class="fas fa-sticky-note text-yellow-500 mr-2"></i>
                        Notes (Optional)
                    </h3>
                    <textarea x-model="notes" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent resize-none"
                              rows="3"
                              placeholder="Add any notes about your approach or questions you have..."><?= htmlspecialchars($submission['notes'] ?? '') ?></textarea>
                </div>

                <!-- Previous Feedback (if exists) -->
                <?php if ($submission && !empty($submission['ai_feedback'])): ?>
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                    <h3 class="text-lg font-bold text-blue-900 mb-4">
                        <i class="fas fa-robot mr-2"></i>
                        Previous Feedback
                    </h3>
                    <?php $feedback = json_decode($submission['ai_feedback'], true); ?>
                    <?php if (is_array($feedback)): ?>
                        <ul class="space-y-2">
                            <?php foreach ($feedback as $item): ?>
                            <li class="text-blue-800"><?= htmlspecialchars($item) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                    <?php if (!empty($submission['ai_score'])): ?>
                    <div class="mt-4 pt-4 border-t border-blue-200">
                        <span class="text-blue-900 font-semibold">Score: <?= $submission['ai_score'] ?>%</span>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <!-- Submit Button -->
                <div class="flex justify-end gap-4">
                    <a href="<?= url('/courses/' . ($course['slug'] ?? '') . '/lesson/' . ($lesson['id'] ?? '')) ?>" 
                       class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-semibold">
                        Cancel
                    </a>
                    <button @click="submitPractical()" 
                            :disabled="isSubmitting"
                            class="px-8 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold disabled:opacity-50">
                        <i class="fas fa-paper-plane mr-2"></i>
                        <span x-text="isSubmitting ? 'Submitting...' : 'Submit Solution'"></span>
                    </button>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
let editor;

function practicalApp() {
    return {
        practicalId: <?= $practical['id'] ?>,
        codeLanguage: 'javascript',
        notes: <?= json_encode($submission['notes'] ?? '') ?>,
        hints: [],
        hintsRemaining: <?= $hintsRemaining ?>,
        isLoadingHint: false,
        isSubmitting: false,
        
        init() {
            // Initialize CodeMirror
            editor = CodeMirror.fromTextArea(document.getElementById('codeEditor'), {
                mode: this.codeLanguage,
                theme: 'dracula',
                lineNumbers: true,
                indentUnit: 4,
                tabSize: 4,
                indentWithTabs: false,
                lineWrapping: true,
                autoCloseBrackets: true,
                matchBrackets: true
            });
        },
        
        changeLanguage() {
            editor.setOption('mode', this.codeLanguage);
        },
        
        async getHint() {
            if (this.hintsRemaining <= 0 || this.isLoadingHint) return;
            
            this.isLoadingHint = true;
            
            try {
                const response = await fetch('<?= url('/ai-tutor/hint') ?>', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        practical_id: this.practicalId
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    this.hints.push(data.hint);
                    this.hintsRemaining = data.hints_remaining;
                } else {
                    alert(data.error || 'Failed to get hint');
                }
            } catch (error) {
                console.error('Hint error:', error);
                alert('Failed to get hint. Please try again.');
            } finally {
                this.isLoadingHint = false;
            }
        },
        
        async submitPractical() {
            const code = editor.getValue().trim();
            
            if (!code) {
                alert('Please enter your solution before submitting.');
                return;
            }
            
            this.isSubmitting = true;
            
            try {
                const response = await fetch('<?= url('/api/practical/submit') ?>', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        practical_id: this.practicalId,
                        code: code,
                        notes: this.notes
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    alert('Your solution has been submitted successfully!');
                    if (data.auto_review) {
                        // Reload to show feedback
                        window.location.reload();
                    }
                } else {
                    alert(data.error || 'Failed to submit');
                }
            } catch (error) {
                console.error('Submit error:', error);
                alert('Failed to submit. Please try again.');
            } finally {
                this.isSubmitting = false;
            }
        }
    }
}

function copyStarterCode() {
    const code = document.getElementById('starterCode').textContent;
    navigator.clipboard.writeText(code).then(() => {
        alert('Starter code copied to clipboard!');
    });
}

// Render Markdown content
document.addEventListener('DOMContentLoaded', function() {
    const descriptionContent = <?= json_encode($practical['description'] ?? '') ?>;
    const instructionsContent = <?= json_encode($practical['instructions'] ?? 'Follow the exercise requirements.') ?>;
    const outcomeContent = <?= json_encode($practical['expected_outcome'] ?? '') ?>;
    
    if (typeof marked !== 'undefined') {
        document.getElementById('description-content').innerHTML = marked.parse(descriptionContent);
        document.getElementById('instructions-content').innerHTML = marked.parse(instructionsContent);
        document.getElementById('outcome-content').innerHTML = marked.parse(outcomeContent);
    } else {
        // Fallback if marked.js not loaded
        document.getElementById('description-content').innerHTML = descriptionContent.replace(/\n/g, '<br>');
        document.getElementById('instructions-content').innerHTML = instructionsContent.replace(/\n/g, '<br>');
        document.getElementById('outcome-content').innerHTML = outcomeContent.replace(/\n/g, '<br>');
    }
});
</script>

</body>
</html>
