<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?> - Nebatech AI Academy</title>
    <link rel="stylesheet" href="<?= asset('css/main.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.44.0/min/vs/editor/editor.main.css">
    <!-- Alpine.js Collapse Plugin (must load before Alpine core) -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <!-- Alpine.js Core -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="h-full bg-gray-50" x-data="reviewSubmission()">
    
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-full px-4 py-3 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <a href="<?= url('/facilitator/submissions') ?>" class="text-gray-600 hover:text-gray-900">
                        <i class="fas fa-arrow-left"></i> Back to Submissions
                    </a>
                    <div class="border-l border-gray-300 h-6"></div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">
                            <?= htmlspecialchars($submission['assignment_title']) ?>
                        </h1>
                        <p class="text-sm text-gray-600">
                            <?= htmlspecialchars($submission['first_name'] . ' ' . $submission['last_name']) ?>
                            • Submitted <?= date('M d, Y g:i A', strtotime($submission['submitted_at'])) ?>
                        </p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <?php
                    $percentage = $submission['score'] && $submission['max_score'] 
                        ? round(($submission['score'] / $submission['max_score']) * 100, 1) 
                        : 0;
                    $scoreClass = $percentage >= 70 ? 'text-green-600' : 'text-orange-600';
                    ?>
                    <?php if ($submission['score'] !== null): ?>
                        <div class="text-right">
                            <div class="text-sm text-gray-600">Current Score</div>
                            <div class="text-2xl font-bold <?= $scoreClass ?>">
                                <?= $submission['score'] ?>/<?= $submission['max_score'] ?> 
                                <span class="text-sm">(<?= $percentage ?>%)</span>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="h-[calc(100vh-73px)] flex">
        
        <!-- Left Panel: Code Viewer -->
        <div class="w-1/2 border-r border-gray-200 flex flex-col bg-white">
            <!-- Code Tabs -->
            <div class="flex-shrink-0 bg-gray-50 border-b border-gray-200">
                <div class="flex items-center justify-between px-4 py-2">
                    <div class="flex space-x-1">
                        <button @click="activeTab = 'html'" 
                                :class="activeTab === 'html' ? 'bg-white border-b-2 border-orange-500 text-orange-600' : 'text-gray-600 hover:text-gray-900'"
                                class="px-4 py-2 text-sm font-medium rounded-t-lg">
                            <i class="fab fa-html5 text-orange-500"></i> HTML
                        </button>
                        <button @click="activeTab = 'css'" 
                                :class="activeTab === 'css' ? 'bg-white border-b-2 border-blue-500 text-blue-600' : 'text-gray-600 hover:text-gray-900'"
                                class="px-4 py-2 text-sm font-medium rounded-t-lg">
                            <i class="fab fa-css3-alt text-blue-500"></i> CSS
                        </button>
                        <button @click="activeTab = 'js'" 
                                :class="activeTab === 'js' ? 'bg-white border-b-2 border-yellow-500 text-yellow-600' : 'text-gray-600 hover:text-gray-900'"
                                class="px-4 py-2 text-sm font-medium rounded-t-lg">
                            <i class="fab fa-js-square text-yellow-500"></i> JavaScript
                        </button>
                        <button @click="activeTab = 'preview'" 
                                :class="activeTab === 'preview' ? 'bg-white border-b-2 border-green-500 text-green-600' : 'text-gray-600 hover:text-gray-900'"
                                class="px-4 py-2 text-sm font-medium rounded-t-lg">
                            <i class="fas fa-eye text-green-500"></i> Live Preview
                        </button>
                    </div>
                    <button @click="downloadCode()" class="px-3 py-1 text-sm text-blue-600 hover:text-blue-800">
                        <i class="fas fa-download"></i> Download Code
                    </button>
                </div>
            </div>
            
            <!-- Code Content -->
            <div class="flex-1 overflow-hidden">
                <div x-show="activeTab === 'html'" id="html-editor" class="h-full"></div>
                <div x-show="activeTab === 'css'" id="css-editor" class="h-full"></div>
                <div x-show="activeTab === 'js'" id="js-editor" class="h-full"></div>
                <div x-show="activeTab === 'preview'" class="h-full">
                    <iframe id="preview-frame" sandbox="allow-scripts allow-modals" class="w-full h-full border-0"></iframe>
                </div>
            </div>
        </div>

        <!-- Right Panel: Feedback & Grading -->
        <div class="w-1/2 overflow-y-auto bg-gray-50">
            <div class="p-6 space-y-6">
                
                <!-- AI Feedback Section -->
                <?php if ($submission['ai_feedback']): 
                    $feedback = is_string($submission['ai_feedback']) 
                        ? json_decode($submission['ai_feedback'], true) 
                        : $submission['ai_feedback'];
                ?>
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">
                            <i class="fas fa-robot text-blue-600"></i> AI Feedback
                        </h2>
                        
                        <!-- AI Score -->
                        <div class="mb-4 p-4 bg-blue-50 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-blue-700 font-medium">AI Generated Score</p>
                                    <p class="text-3xl font-bold text-blue-900">
                                        <?= $feedback['score'] ?>/<?= $feedback['max_score'] ?>
                                        <span class="text-lg text-blue-600">(<?= $feedback['percentage'] ?>%)</span>
                                    </p>
                                    <p class="text-sm text-blue-700 mt-1"><?= $feedback['grade_level'] ?></p>
                                </div>
                                <div class="text-right text-xs text-blue-600">
                                    Generated: <?= date('M d, g:i A', strtotime($feedback['generated_at'])) ?>
                                </div>
                            </div>
                        </div>

                        <!-- Overall Feedback -->
                        <div class="mb-4">
                            <h3 class="text-sm font-semibold text-gray-700 mb-2">Overall Assessment</h3>
                            <div class="bg-gray-50 p-3 rounded text-sm text-gray-700 leading-relaxed">
                                <?= nl2br(htmlspecialchars($feedback['ai_feedback']['overall_feedback'])) ?>
                            </div>
                        </div>

                        <!-- Strengths -->
                        <?php if (!empty($feedback['ai_feedback']['strengths'])): ?>
                            <div class="mb-4">
                                <h3 class="text-sm font-semibold text-green-700 mb-2">
                                    <i class="fas fa-check-circle"></i> Strengths
                                </h3>
                                <ul class="space-y-1">
                                    <?php foreach ($feedback['ai_feedback']['strengths'] as $strength): ?>
                                        <li class="flex items-start text-sm">
                                            <i class="fas fa-check text-green-500 mt-1 mr-2 text-xs"></i>
                                            <span class="text-gray-700"><?= htmlspecialchars($strength) ?></span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <!-- Improvements -->
                        <?php if (!empty($feedback['ai_feedback']['improvements'])): ?>
                            <div class="mb-4">
                                <h3 class="text-sm font-semibold text-orange-700 mb-2">
                                    <i class="fas fa-exclamation-triangle"></i> Areas for Improvement
                                </h3>
                                <ul class="space-y-1">
                                    <?php foreach ($feedback['ai_feedback']['improvements'] as $improvement): ?>
                                        <li class="flex items-start text-sm">
                                            <i class="fas fa-arrow-right text-orange-500 mt-1 mr-2 text-xs"></i>
                                            <span class="text-gray-700"><?= htmlspecialchars($improvement) ?></span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <!-- Validation Results -->
                        <?php if (!empty($feedback['validation']['issues'])): ?>
                            <div class="mb-4">
                                <h3 class="text-sm font-semibold text-purple-700 mb-2">
                                    <i class="fas fa-code"></i> Code Validation
                                </h3>
                                <p class="text-sm text-gray-600 mb-2"><?= htmlspecialchars($feedback['validation']['summary']) ?></p>
                                <?php foreach ($feedback['validation']['issues'] as $category => $issues): ?>
                                    <div class="mb-2">
                                        <p class="text-xs font-semibold text-gray-600 uppercase mb-1"><?= htmlspecialchars($category) ?></p>
                                        <?php foreach ($issues as $issue): ?>
                                            <div class="text-xs p-2 rounded mb-1 <?= 
                                                $issue['severity'] === 'error' ? 'bg-red-50 text-red-700 border-l-2 border-red-400' :
                                                ($issue['severity'] === 'warning' ? 'bg-yellow-50 text-yellow-700 border-l-2 border-yellow-400' : 
                                                'bg-blue-50 text-blue-700 border-l-2 border-blue-400') 
                                            ?>">
                                                <span class="font-semibold">[<?= ucfirst($issue['severity']) ?>]</span>
                                                <?= htmlspecialchars($issue['message']) ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <p class="text-yellow-800">
                            <i class="fas fa-exclamation-triangle"></i> 
                            No AI feedback available yet
                        </p>
                    </div>
                <?php endif; ?>

                <!-- Manual Grading Form -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">
                        <i class="fas fa-user-edit text-green-600"></i> Facilitator Review
                    </h2>
                    
                    <form @submit.prevent="submitGrade()">
                        <!-- Score Override -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Override Score (Optional)
                                <span class="text-xs text-gray-500 font-normal">
                                    Leave blank to keep AI score
                                </span>
                            </label>
                            <div class="flex items-center space-x-3">
                                <input type="number" 
                                       x-model="score" 
                                       min="0" 
                                       max="<?= $submission['max_score'] ?>"
                                       class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                       placeholder="Enter score (0-<?= $submission['max_score'] ?>)">
                                <span class="text-gray-600">/ <?= $submission['max_score'] ?></span>
                            </div>
                        </div>

                        <!-- Comments -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Facilitator Comments
                            </label>
                            <textarea x-model="comments" 
                                      rows="5" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                      placeholder="Add your feedback, suggestions, or notes for the student..."></textarea>
                        </div>

                        <!-- Status -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Submission Status
                            </label>
                            <select x-model="status" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                <option value="graded">✓ Approve & Grade</option>
                                <option value="revision_requested">↻ Request Revision</option>
                                <option value="submitted">⏸ Keep as Pending</option>
                            </select>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-between">
                            <button type="button" 
                                    @click="regenerateFeedback()"
                                    class="px-4 py-2 text-sm text-blue-600 border border-blue-300 rounded-lg hover:bg-blue-50">
                                <i class="fas fa-sync-alt"></i> Regenerate AI Feedback
                            </button>
                            <div class="flex space-x-3">
                                <button type="button" 
                                        @click="window.location.href='<?= url('/facilitator/submissions') ?>'"
                                        class="px-6 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                                    Cancel
                                </button>
                                <button type="submit" 
                                        class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                                    <i class="fas fa-save"></i> Save Grade
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Assignment Details -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-3">Assignment Details</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Course:</span>
                            <span class="font-medium"><?= htmlspecialchars($submission['course_title']) ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Module:</span>
                            <span class="font-medium"><?= htmlspecialchars($submission['module_title']) ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Lesson:</span>
                            <span class="font-medium"><?= htmlspecialchars($submission['lesson_title']) ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Max Score:</span>
                            <span class="font-medium"><?= $submission['max_score'] ?> points</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Monaco Editor CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.44.0/min/vs/loader.min.js"></script>
    
    <script>
    const SUBMISSION_ID = <?= $submission['id'] ?>;
    const BASE_URL = '<?= url('/') ?>';
    
    function reviewSubmission() {
        return {
            activeTab: 'html',
            score: <?= $submission['score'] ?? 'null' ?>,
            comments: <?= json_encode($submission['facilitator_comments'] ?? '') ?>,
            status: '<?= $submission['status'] ?>',
            htmlEditor: null,
            cssEditor: null,
            jsEditor: null,
            
            init() {
                this.loadMonaco();
            },
            
            loadMonaco() {
                require.config({ paths: { vs: 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.44.0/min/vs' }});
                require(['vs/editor/editor.main'], () => {
                    this.initializeEditors();
                });
            },
            
            initializeEditors() {
                const editorOptions = {
                    theme: 'vs-light',
                    readOnly: true,
                    automaticLayout: true,
                    fontSize: 13,
                    wordWrap: 'on',
                    minimap: { enabled: false }
                };
                
                this.htmlEditor = monaco.editor.create(document.getElementById('html-editor'), {
                    ...editorOptions,
                    language: 'html',
                    value: <?= json_encode($parsedCode['html']) ?>
                });
                
                this.cssEditor = monaco.editor.create(document.getElementById('css-editor'), {
                    ...editorOptions,
                    language: 'css',
                    value: <?= json_encode($parsedCode['css']) ?>
                });
                
                this.jsEditor = monaco.editor.create(document.getElementById('js-editor'), {
                    ...editorOptions,
                    language: 'javascript',
                    value: <?= json_encode($parsedCode['js']) ?>
                });
                
                // Load preview
                setTimeout(() => this.updatePreview(), 500);
            },
            
            updatePreview() {
                const html = <?= json_encode($parsedCode['html']) ?>;
                const css = <?= json_encode($parsedCode['css']) ?>;
                const js = <?= json_encode($parsedCode['js']) ?>;
                
                const fullHTML = `<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>${css}</style>
</head>
<body>
${html}
<script>${js}</script>
</body>
</html>`;
                
                const iframe = document.getElementById('preview-frame');
                iframe.srcdoc = fullHTML;
            },
            
            async submitGrade() {
                try {
                    const formData = new FormData();
                    formData.append('submission_id', SUBMISSION_ID);
                    if (this.score !== null && this.score !== '') {
                        formData.append('score', this.score);
                    }
                    formData.append('facilitator_comments', this.comments);
                    formData.append('status', this.status);
                    
                    const response = await fetch(BASE_URL + '/facilitator/submissions/update', {
                        method: 'POST',
                        body: formData
                    });
                    
                    const data = await response.json();
                    
                    if (data.success) {
                        alert('Grade saved successfully!');
                        window.location.href = BASE_URL + '/facilitator/submissions';
                    } else {
                        alert('Error: ' + data.error);
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Failed to save grade');
                }
            },
            
            async regenerateFeedback() {
                if (!confirm('Regenerate AI feedback? This will replace existing feedback.')) {
                    return;
                }
                
                try {
                    const response = await fetch(BASE_URL + '/api/submissions/' + SUBMISSION_ID + '/regenerate-feedback', {
                        method: 'POST'
                    });
                    
                    const data = await response.json();
                    
                    if (data.success) {
                        alert('Feedback regenerated successfully!');
                        window.location.reload();
                    } else {
                        alert('Error: ' + data.error);
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Failed to regenerate feedback');
                }
            },
            
            downloadCode() {
                const code = <?= json_encode($code) ?>;
                const blob = new Blob([code], { type: 'text/html' });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'submission_<?= $submission['id'] ?>.html';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                URL.revokeObjectURL(url);
            }
        };
    }
    </script>
</body>
</html>
