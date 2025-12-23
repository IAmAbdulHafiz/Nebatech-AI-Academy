<?php
$title = 'Code Playground';
$isWebMode = in_array($selectedLanguage ?? 'javascript', ['html', 'web']);
?>

<style>
    [x-cloak] { display: none !important; }
    .editor-container { height: calc(100vh - 220px); min-height: 500px; }
    .code-panel, .output-panel { height: 100%; border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden; }
    .editor-wrapper { height: calc(100% - 50px); }
    .monaco-editor-container { height: 100%; width: 100%; }
    .preview-frame { width: 100%; height: calc(100% - 180px); border: none; background: white; }
    .console-output { height: 150px; overflow-y: auto; background: #1e1e1e; color: #d4d4d4; padding: 10px; font-family: 'Consolas', 'Monaco', monospace; font-size: 13px; }
    .console-line { margin: 2px 0; padding: 2px 5px; }
    .console-log { color: #d4d4d4; }
    .console-error { color: #f87171; }
    .console-warn { color: #fbbf24; }
    .console-info { color: #60a5fa; }
    .tab-button { padding: 10px 20px; cursor: pointer; border: none; background: #f3f4f6; transition: all 0.2s; }
    .tab-button.active { background: white; border-bottom: 2px solid #10b981; color: #10b981; font-weight: 600; }
    .tab-button:hover { background: #e5e7eb; }
    kbd { font-family: ui-monospace, monospace; }
</style>

<div class="min-h-screen bg-gray-50" x-data="codePlayground()" @keydown.window="handleKeydown($event)">
    <!-- Header -->
    <div class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-10">
        <div class="container mx-auto px-4 py-3">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <!-- Left Section -->
                <div class="flex items-center gap-4 flex-wrap">
                    <h1 class="text-2xl font-bold text-gray-900">
                        <i class="fas fa-code text-primary mr-2"></i>Code Playground
                    </h1>
                    
                    <!-- Language/Mode Selector -->
                    <select x-model="mode" @change="changeMode()" 
                            class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary focus:border-primary font-medium">
                        <optgroup label="Web Development">
                            <option value="web">HTML / CSS / JS</option>
                        </optgroup>
                        <optgroup label="Programming Languages">
                            <?php foreach ($languages as $key => $lang): ?>
                                <?php if ($key !== 'html'): ?>
                                <option value="<?= $key ?>"><?= htmlspecialchars($lang['name']) ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </optgroup>
                    </select>
                    
                    <!-- Theme Toggle -->
                    <button @click="toggleTheme()" 
                            class="px-3 py-2 rounded-lg border border-gray-300 hover:bg-gray-100 transition"
                            :title="darkTheme ? 'Switch to Light Theme' : 'Switch to Dark Theme'">
                        <i class="fas" :class="darkTheme ? 'fa-sun text-yellow-500' : 'fa-moon text-gray-600'"></i>
                    </button>
                    
                    <!-- Font Size Controls -->
                    <div class="flex items-center gap-1 border border-gray-300 rounded-lg">
                        <button @click="decreaseFontSize()" class="px-3 py-2 hover:bg-gray-100 transition rounded-l-lg" title="Decrease Font Size">
                            <i class="fas fa-minus text-xs"></i>
                        </button>
                        <span class="px-2 text-sm text-gray-600" x-text="fontSize + 'px'"></span>
                        <button @click="increaseFontSize()" class="px-3 py-2 hover:bg-gray-100 transition rounded-r-lg" title="Increase Font Size">
                            <i class="fas fa-plus text-xs"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Right Section - Actions -->
                <div class="flex items-center gap-2 flex-wrap">
                    <!-- Run Button -->
                    <button @click="runCode()" :disabled="running" 
                            class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2"
                            title="Run Code (Ctrl+Enter)">
                        <i class="fas" :class="running ? 'fa-spinner fa-spin' : 'fa-play'"></i>
                        <span x-text="running ? 'Running...' : 'Run'"></span>
                    </button>
                    
                    <!-- AI Review Button -->
                    <button @click="requestAIReview()" :disabled="aiReviewLoading"
                            class="px-4 py-2 bg-violet-600 text-white rounded-lg hover:bg-violet-700 transition font-medium disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2"
                            title="Get AI Code Review">
                        <i class="fas fa-robot" :class="aiReviewLoading && 'animate-pulse'"></i>
                        <span x-text="aiReviewLoading ? 'Reviewing...' : 'AI Review'"></span>
                    </button>
                    
                    <!-- Reset Button -->
                    <button @click="resetCode()" 
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium"
                            title="Reset Code">
                        <i class="fas fa-undo"></i>
                    </button>
                    
                    <!-- Download Button -->
                    <button @click="downloadCode()" 
                            class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-blue-700 transition font-medium"
                            title="Download Code (Ctrl+S)">
                        <i class="fas fa-download"></i>
                    </button>
                    
                    <!-- Fullscreen Toggle -->
                    <button @click="toggleFullscreen()" 
                            class="px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-800 transition font-medium"
                            title="Toggle Fullscreen (F11)">
                        <i class="fas" :class="isFullscreen ? 'fa-compress' : 'fa-expand'"></i>
                    </button>
                </div>
            </div>
            
            <!-- Keyboard Shortcuts Hint -->
            <div class="mt-2 flex items-center gap-4 text-xs text-gray-500 flex-wrap">
                <span><kbd class="px-1.5 py-0.5 bg-gray-100 rounded text-gray-700">Ctrl+Enter</kbd> Run</span>
                <span><kbd class="px-1.5 py-0.5 bg-gray-100 rounded text-gray-700">Ctrl+S</kbd> Download</span>
                <span><kbd class="px-1.5 py-0.5 bg-gray-100 rounded text-gray-700">F11</kbd> Fullscreen</span>
                <span class="ml-auto text-green-600" x-show="autoSaved" x-transition>
                    <i class="fas fa-check mr-1"></i>Auto-saved
                </span>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-4">
        <!-- Layout Toggle (Web mode only) -->
        <div x-show="mode === 'web'" class="mb-4 flex gap-2">
            <button @click="layout = 'horizontal'" 
                    :class="layout === 'horizontal' ? 'bg-green-600 text-white' : 'bg-white text-gray-700'"
                    class="px-4 py-2 rounded-lg border border-gray-300 hover:bg-green-50 transition">
                <i class="fas fa-columns mr-2"></i>Side by Side
            </button>
            <button @click="layout = 'vertical'" 
                    :class="layout === 'vertical' ? 'bg-green-600 text-white' : 'bg-white text-gray-700'"
                    class="px-4 py-2 rounded-lg border border-gray-300 hover:bg-green-50 transition">
                <i class="fas fa-grip-lines mr-2"></i>Stacked
            </button>
        </div>

        <!-- Editor Container -->
        <div class="editor-container" 
             :class="{
                 'grid grid-cols-2 gap-4': mode === 'web' && layout === 'horizontal',
                 'grid grid-rows-2 gap-4': mode === 'web' && layout === 'vertical',
                 'grid grid-cols-1 lg:grid-cols-2 gap-4': mode !== 'web'
             }">
            
            <!-- Code Panel -->
            <div class="code-panel bg-white" :class="darkTheme && 'bg-gray-900 border-gray-700'">
                <!-- Web Mode: Tabs for HTML/CSS/JS -->
                <div x-show="mode === 'web'" class="flex border-b border-gray-200 bg-gray-50" :class="darkTheme && 'bg-gray-800 border-gray-700'">
                        <button @click="activeTab = 'html'" 
                                :class="activeTab === 'html' ? 'active' : ''"
                                class="tab-button flex items-center gap-2">
                            <i class="fab fa-html5 text-orange-600"></i> HTML
                        </button>
                        <button @click="activeTab = 'css'" 
                                :class="activeTab === 'css' ? 'active' : ''"
                                class="tab-button flex items-center gap-2">
                            <i class="fab fa-css3-alt text-blue-600"></i> CSS
                        </button>
                        <button @click="activeTab = 'js'" 
                                :class="activeTab === 'js' ? 'active' : ''"
                                class="tab-button flex items-center gap-2">
                            <i class="fab fa-js text-yellow-500"></i> JavaScript
                        </button>
                </div>
                
                <!-- Single Language Mode: Header -->
                <div x-show="mode !== 'web'" class="px-4 py-3 border-b flex items-center justify-between"
                     :class="darkTheme ? 'bg-gray-800 border-gray-700' : 'bg-gray-50 border-gray-200'">
                    <span class="font-medium" :class="darkTheme ? 'text-gray-200' : 'text-gray-700'">
                        <i class="fas fa-code mr-2"></i>Code Editor
                    </span>
                        <div class="flex items-center gap-2">
                            <span class="text-sm px-2 py-1 rounded" 
                                  :class="darkTheme ? 'bg-gray-700 text-gray-300' : 'bg-gray-200 text-gray-600'"
                                  x-text="getLanguageDisplay()"></span>
                        </div>
                </div>
                
                <!-- Monaco Editors -->
                <div class="editor-wrapper">
                    <!-- Web Mode Editors -->
                    <div x-show="mode === 'web'" class="h-full">
                        <div id="htmlEditor" class="monaco-editor-container" x-show="activeTab === 'html'"></div>
                        <div id="cssEditor" class="monaco-editor-container" x-show="activeTab === 'css'"></div>
                        <div id="jsEditor" class="monaco-editor-container" x-show="activeTab === 'js'"></div>
                    </div>
                    <!-- Single Language Editor -->
                    <div x-show="mode !== 'web'" class="h-full">
                        <div id="codeEditor" class="monaco-editor-container"></div>
                    </div>
                </div>
            </div>

            <!-- Output Panel -->
            <div class="output-panel bg-white flex flex-col" :class="darkTheme && 'bg-gray-900 border-gray-700'">
                <!-- Header -->
                <div class="px-4 py-3 border-b flex items-center justify-between"
                     :class="darkTheme ? 'bg-gray-800 border-gray-700' : 'bg-gray-50 border-gray-200'">
                    <span class="font-medium" :class="darkTheme ? 'text-gray-200' : 'text-gray-700'">
                        <i class="fas" :class="mode === 'web' ? 'fa-eye' : 'fa-terminal'" class="mr-2"></i>
                        <span x-text="mode === 'web' ? 'Live Preview' : 'Output'"></span>
                    </span>
                    <div class="flex items-center gap-2">
                        <button @click="clearOutput()" 
                                class="text-sm px-2 py-1 rounded hover:bg-gray-200 transition"
                                :class="darkTheme ? 'text-gray-300 hover:bg-gray-700' : 'text-gray-600'">
                            <i class="fas fa-times mr-1"></i>Clear
                        </button>
                        <button x-show="mode === 'web'" @click="runCode()" 
                                class="text-sm px-3 py-1 bg-primary text-white rounded hover:bg-primary/80">
                            <i class="fas fa-sync-alt mr-1"></i>Refresh
                        </button>
                    </div>
                </div>
                
                <!-- Web Mode: Preview Frame -->
                <div x-show="mode === 'web'" class="flex-1 flex flex-col">
                        <iframe id="preview" class="preview-frame flex-1" sandbox="allow-scripts allow-modals"></iframe>
                        
                        <!-- Console -->
                        <div class="border-t border-gray-200">
                            <div class="flex items-center justify-between bg-gray-800 text-white px-3 py-2">
                                <span class="text-sm font-semibold">
                                    <i class="fas fa-terminal mr-2"></i>Console
                                </span>
                                <span class="text-xs text-gray-400" x-text="consoleMessages.length + ' message(s)'"></span>
                            </div>
                            <div class="console-output">
                                <template x-for="(msg, index) in consoleMessages" :key="index">
                                    <div :class="'console-line console-' + msg.type">
                                        <span class="text-gray-500" x-text="'[' + msg.time + ']'"></span>
                                        <span x-text="msg.message"></span>
                                    </div>
                                </template>
                                <div x-show="consoleMessages.length === 0" class="text-gray-500 text-sm">
                                    Console is empty. Run your code to see output here.
                                </div>
                            </div>
                        </div>
                </div>
                
                <!-- Single Language Mode: Output -->
                <div x-show="mode !== 'web'" class="flex-1 flex flex-col">
                        <!-- Input (stdin) Section -->
                        <div class="border-b" :class="darkTheme ? 'border-gray-700' : 'border-gray-200'">
                            <div class="px-4 py-2 cursor-pointer flex items-center justify-between"
                                 :class="darkTheme ? 'bg-gray-800' : 'bg-gray-50'"
                                 @click="showInput = !showInput">
                                <span class="font-medium text-sm" :class="darkTheme ? 'text-gray-200' : 'text-gray-700'">
                                    <i class="fas fa-keyboard mr-2"></i>Input (stdin)
                                </span>
                                <i class="fas transition-transform" 
                                   :class="[showInput ? 'fa-chevron-up' : 'fa-chevron-down', darkTheme ? 'text-gray-400' : 'text-gray-500']"></i>
                            </div>
                            <div x-show="showInput" x-transition class="p-0">
                                <textarea x-model="stdin" 
                                          class="w-full h-20 font-mono text-sm resize-none p-3 focus:outline-none"
                                          :class="darkTheme ? 'bg-gray-900 text-gray-100' : 'bg-white text-gray-800'"
                                          placeholder="Enter input for your program (one value per line)..."
                                          spellcheck="false"></textarea>
                            </div>
                        </div>
                        
                        <!-- Output Area -->
                        <div class="flex-1 overflow-auto p-4">
                            <!-- Empty State -->
                            <div x-show="!output && !error && !running" 
                                 class="h-full flex flex-col items-center justify-center"
                                 :class="darkTheme ? 'text-gray-500' : 'text-gray-400'">
                                <i class="fas fa-play-circle text-4xl mb-3"></i>
                                <p class="text-sm">Run your code to see the output here...</p>
                                <p class="text-xs mt-1">Press <kbd class="px-1.5 py-0.5 bg-gray-200 rounded">Ctrl+Enter</kbd></p>
                            </div>
                            
                            <!-- Loading State -->
                            <div x-show="running" class="h-full flex flex-col items-center justify-center text-blue-500">
                                <i class="fas fa-spinner fa-spin text-4xl mb-3"></i>
                                <p class="text-sm">Executing code...</p>
                            </div>
                            
                            <!-- Output -->
                            <pre x-show="output && !running" 
                                 class="font-mono text-sm whitespace-pre-wrap"
                                 :class="darkTheme ? 'text-green-400' : 'text-gray-800'"
                                 x-text="output"></pre>
                            
                            <!-- Error -->
                            <pre x-show="error && !running" 
                                 class="font-mono text-sm whitespace-pre-wrap text-red-500"
                                 x-text="error"></pre>
                        </div>
                        
                        <!-- Execution Stats -->
                        <div x-show="executionStats.time !== null" 
                             class="border-t p-3"
                             :class="darkTheme ? 'bg-gray-800 border-gray-700' : 'bg-gray-50 border-gray-200'">
                            <div class="flex items-center justify-between text-sm">
                                <span :class="darkTheme ? 'text-gray-300' : 'text-gray-600'">
                                    <i class="fas fa-clock mr-1"></i>
                                    <span x-text="formatTime(executionStats.time)"></span>
                                </span>
                                <span :class="darkTheme ? 'text-gray-300' : 'text-gray-600'">
                                    <i class="fas fa-memory mr-1"></i>
                                    <span x-text="formatMemory(executionStats.memory)"></span>
                                </span>
                                <span class="px-2 py-0.5 rounded-full text-xs"
                                      :class="executionStats.status === 'Accepted' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'"
                                      x-text="executionStats.status"></span>
                            </div>
                            <div x-show="executionStats.simulated" class="mt-1 text-xs text-center text-yellow-600">
                                <i class="fas fa-info-circle mr-1"></i>Simulated execution
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Code Templates (Single language mode) -->
        <div x-show="mode !== 'web'" class="mt-4">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4"
                 :class="darkTheme && 'bg-gray-900 border-gray-700'">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-medium" :class="darkTheme ? 'text-gray-200' : 'text-gray-700'">
                        <i class="fas fa-file-code mr-2"></i>Code Templates
                    </h3>
                </div>
                <div class="flex flex-wrap gap-2">
                    <template x-for="template in getTemplatesForLanguage()" :key="template.name">
                        <button @click="loadTemplate(template.code)"
                                class="px-3 py-1.5 rounded border text-sm hover:border-primary hover:bg-primary/5 transition"
                                :class="darkTheme ? 'border-gray-700 text-gray-300' : 'border-gray-200 text-gray-700'">
                            <i class="fas fa-file-alt mr-1 text-primary"></i>
                            <span x-text="template.name"></span>
                        </button>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <!-- AI Review Modal -->
    <div x-show="showAIReviewModal" 
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4"
         @click.self="closeAIReviewModal()"
         @keydown.escape.window="showAIReviewModal && closeAIReviewModal()">
        <div x-show="showAIReviewModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-95"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-95"
             class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[80vh] overflow-hidden">
            
            <!-- Header -->
            <div class="bg-gradient-to-r from-violet-600 to-indigo-600 px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-robot text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-white font-bold text-lg">AI Code Review</h3>
                        <p class="text-white/70 text-sm">Powered by AI Tutor</p>
                    </div>
                </div>
                <button @click="closeAIReviewModal()" class="text-white/80 hover:text-white transition">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <!-- Content -->
            <div class="p-6 overflow-y-auto max-h-[60vh] space-y-6">
                <!-- Score -->
                <div class="flex items-center justify-center">
                    <div class="text-center">
                        <div class="w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-2"
                             :class="{
                                 'bg-green-100 text-green-600': (aiReview?.review?.score || 0) >= 80,
                                 'bg-yellow-100 text-yellow-600': (aiReview?.review?.score || 0) >= 60 && (aiReview?.review?.score || 0) < 80,
                                 'bg-red-100 text-red-600': (aiReview?.review?.score || 0) < 60
                             }">
                            <span class="text-3xl font-bold" x-text="aiReview?.review?.score || '?'"></span>
                        </div>
                        <p class="text-gray-600 font-medium">Code Quality Score</p>
                    </div>
                </div>
                
                <!-- Summary -->
                <div x-show="aiReview?.review?.summary" class="bg-gray-50 rounded-xl p-4">
                    <h4 class="font-semibold text-gray-900 mb-2 flex items-center gap-2">
                        <i class="fas fa-clipboard-list text-violet-600"></i> Summary
                    </h4>
                    <p class="text-gray-600" x-text="aiReview?.review?.summary"></p>
                </div>
                
                <!-- Issues -->
                <template x-if="aiReview?.review?.issues && aiReview.review.issues.length > 0">
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
                            <i class="fas fa-exclamation-triangle text-amber-500"></i> Issues Found
                        </h4>
                        <div class="space-y-3">
                            <template x-for="(issue, i) in aiReview?.review?.issues || []" :key="i">
                                <div class="border-l-4 pl-4 py-2"
                                     :class="{
                                         'border-red-500 bg-red-50': issue.severity === 'error',
                                         'border-yellow-500 bg-yellow-50': issue.severity === 'warning',
                                         'border-blue-500 bg-blue-50': issue.severity === 'info' || !issue.severity
                                     }">
                                    <p class="font-medium text-gray-900" x-text="issue.title || issue.message"></p>
                                    <p class="text-sm text-gray-600 mt-1" x-text="issue.description || issue.suggestion || ''"></p>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
                
                <!-- Suggestions -->
                <template x-if="aiReview?.review?.suggestions && aiReview.review.suggestions.length > 0">
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
                            <i class="fas fa-lightbulb text-green-500"></i> Suggestions
                        </h4>
                        <ul class="space-y-2">
                            <template x-for="(suggestion, i) in aiReview?.review?.suggestions || []" :key="i">
                                <li class="flex items-start gap-2 text-gray-600">
                                    <i class="fas fa-check-circle text-green-500 mt-1 flex-shrink-0"></i>
                                    <span x-text="suggestion"></span>
                                </li>
                            </template>
                        </ul>
                    </div>
                </template>
            </div>
            
            <!-- Footer -->
            <div class="border-t border-gray-200 px-6 py-4 bg-gray-50 flex justify-end gap-3">
                <button @click="closeAIReviewModal()" 
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                    Close
                </button>
                <button @click="closeAIReviewModal(); requestAIReview();" 
                        class="px-4 py-2 bg-violet-600 text-white rounded-lg hover:bg-violet-700 transition">
                    <i class="fas fa-redo mr-2"></i> Review Again
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Monaco Editor -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.44.0/min/vs/loader.min.js"></script>

<script>
function codePlayground() {
    return {
        // Mode and Layout
        mode: 'web',
        layout: 'horizontal',
        activeTab: 'html',
        
        // Editors
        htmlEditor: null,
        cssEditor: null,
        jsEditor: null,
        codeEditor: null,
        editorsInitialized: false,
        
        // State
        stdin: '',
        output: '',
        error: '',
        running: false,
        darkTheme: localStorage.getItem('playground_theme') === 'dark',
        fontSize: parseInt(localStorage.getItem('playground_fontsize')) || 14,
        showInput: false,
        isFullscreen: false,
        autoSaved: false,
        saveTimeout: null,
        
        // AI Review
        aiReviewLoading: false,
        aiReview: null,
        showAIReviewModal: false,
        
        // Console (for web mode)
        consoleMessages: [],
        
        // Execution stats (for single language mode)
        executionStats: {
            time: null,
            memory: null,
            status: null,
            runs: 0,
            simulated: false
        },
        
        // Code templates
        templates: {
            javascript: [
                { name: 'Hello World', code: '// JavaScript Hello World\nconsole.log("Hello, World!");' },
                { name: 'Array Operations', code: 'const numbers = [1, 2, 3, 4, 5];\nconst doubled = numbers.map(n => n * 2);\nconsole.log("Doubled:", doubled);' },
                { name: 'Async/Await', code: 'async function fetchData() {\n    return new Promise(resolve => {\n        setTimeout(() => resolve("Data loaded!"), 1000);\n    });\n}\n\nfetchData().then(data => console.log(data));' }
            ],
            python: [
                { name: 'Hello World', code: '# Python Hello World\nprint("Hello, World!")' },
                { name: 'List Comprehension', code: 'numbers = [1, 2, 3, 4, 5]\nsquared = [x**2 for x in numbers]\nprint("Squared:", squared)' },
                { name: 'Class Example', code: 'class Person:\n    def __init__(self, name, age):\n        self.name = name\n        self.age = age\n    \n    def greet(self):\n        print(f"Hello, I am {self.name}")\n\nperson = Person("John", 30)\nperson.greet()' }
            ],
            java: [
                { name: 'Hello World', code: 'public class Main {\n    public static void main(String[] args) {\n        System.out.println("Hello, World!");\n    }\n}' }
            ],
            cpp: [
                { name: 'Hello World', code: '#include <iostream>\nusing namespace std;\n\nint main() {\n    cout << "Hello, World!" << endl;\n    return 0;\n}' }
            ],
            c: [
                { name: 'Hello World', code: '#include <stdio.h>\n\nint main() {\n    printf("Hello, World!\\n");\n    return 0;\n}' }
            ],
            php: [
                { name: 'Hello World', code: '<?php\necho "Hello, World!\\n";' }
            ],
            ruby: [
                { name: 'Hello World', code: '# Ruby Hello World\nputs "Hello, World!"' }
            ],
            go: [
                { name: 'Hello World', code: 'package main\n\nimport "fmt"\n\nfunc main() {\n    fmt.Println("Hello, World!")\n}' }
            ],
            rust: [
                { name: 'Hello World', code: 'fn main() {\n    println!("Hello, World!");\n}' }
            ],
            typescript: [
                { name: 'Hello World', code: 'const greeting: string = "Hello, World!";\nconsole.log(greeting);' }
            ],
            csharp: [
                { name: 'Hello World', code: 'using System;\n\nclass Program {\n    static void Main() {\n        Console.WriteLine("Hello, World!");\n    }\n}' }
            ]
        },

        init() {
            // Configure Monaco Loader
            require.config({ 
                paths: { 
                    'vs': 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.44.0/min/vs' 
                } 
            });
            
            // Load Monaco Editor
            require(['vs/editor/editor.main'], () => {
                this.initializeEditors();
            });
            
            // Listen for console messages from iframe
            window.addEventListener('message', (event) => {
                if (event.data.type === 'console') {
                    this.addConsoleMessage(event.data.message, event.data.level);
                }
            });
        },
        
        initializeEditors() {
            const theme = this.darkTheme ? 'vs-dark' : 'vs-light';
            
            // Web Mode Editors (HTML, CSS, JS)
            this.htmlEditor = monaco.editor.create(document.getElementById('htmlEditor'), {
                value: this.getStarterHTML(),
                language: 'html',
                theme: theme,
                automaticLayout: true,
                minimap: { enabled: false },
                fontSize: this.fontSize,
                wordWrap: 'on',
                tabSize: 2
            });
            
            this.cssEditor = monaco.editor.create(document.getElementById('cssEditor'), {
                value: this.getStarterCSS(),
                language: 'css',
                theme: theme,
                automaticLayout: true,
                minimap: { enabled: false },
                fontSize: this.fontSize,
                wordWrap: 'on',
                tabSize: 2
            });
            
            this.jsEditor = monaco.editor.create(document.getElementById('jsEditor'), {
                value: this.getStarterJS(),
                language: 'javascript',
                theme: theme,
                automaticLayout: true,
                minimap: { enabled: false },
                fontSize: this.fontSize,
                wordWrap: 'on',
                tabSize: 2
            });
            
            // Single Language Editor
            this.codeEditor = monaco.editor.create(document.getElementById('codeEditor'), {
                value: '// Select a language to start coding',
                language: 'javascript',
                theme: theme,
                automaticLayout: true,
                minimap: { enabled: false },
                fontSize: this.fontSize,
                wordWrap: 'on',
                tabSize: 2
            });
            
            // Setup keyboard shortcuts
            const allEditors = [this.htmlEditor, this.cssEditor, this.jsEditor, this.codeEditor];
            allEditors.forEach(editor => {
                editor.addCommand(monaco.KeyMod.CtrlCmd | monaco.KeyCode.KeyS, () => {
                    this.downloadCode();
                });
                editor.addCommand(monaco.KeyMod.CtrlCmd | monaco.KeyCode.Enter, () => {
                    this.runCode();
                });
            });
            
            // Auto-run on changes for web mode (debounced)
            let timeout;
            [this.htmlEditor, this.cssEditor, this.jsEditor].forEach(editor => {
                editor.onDidChangeModelContent(() => {
                    if (this.mode === 'web') {
                        clearTimeout(timeout);
                        timeout = setTimeout(() => this.runCode(), 1000);
                    }
                    this.autoSaveCode();
                });
            });
            
            this.codeEditor.onDidChangeModelContent(() => {
                this.autoSaveCode();
            });
            
            this.editorsInitialized = true;
            
            // Load saved code
            this.loadSavedCode();
            
            // Initial run for web mode
            if (this.mode === 'web') {
                this.runCode();
            }
        },
        
        getStarterHTML() {
            return `<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Project</title>
</head>
<body>
    <h1>Hello, World!</h1>
    <p>Start coding here...</p>
    <button id="myBtn">Click Me!</button>
</body>
</html>`;
        },
        
        getStarterCSS() {
            return `/* Add your styles here */
body {
    font-family: 'Segoe UI', Arial, sans-serif;
    margin: 20px;
    padding: 0;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    color: white;
}

h1 {
    color: #fff;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

button {
    background: #10b981;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 16px;
    transition: transform 0.2s, box-shadow 0.2s;
}

button:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.3);
}`;
        },
        
        getStarterJS() {
            return `// Add your JavaScript here
console.log('Hello from JavaScript!');

document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('myBtn');
    let clicks = 0;
    
    btn.addEventListener('click', () => {
        clicks++;
        console.log('Button clicked ' + clicks + ' times!');
        btn.textContent = 'Clicked ' + clicks + ' times';
    });
});`;
        },
        
        handleKeydown(event) {
            if (event.ctrlKey && event.key === 'Enter') {
                event.preventDefault();
                this.runCode();
            } else if (event.ctrlKey && event.key === 's') {
                event.preventDefault();
                this.downloadCode();
            } else if (event.key === 'F11') {
                event.preventDefault();
                this.toggleFullscreen();
            }
        },
        
        changeMode() {
            if (this.mode === 'web') {
                // Load saved web code
                this.loadSavedCode();
                this.runCode();
            } else {
                // Update single language editor
                this.updateSingleLanguageEditor();
            }
            this.clearOutput();
        },
        
        updateSingleLanguageEditor() {
            if (!this.codeEditor) return;
            
            const languageMap = {
                javascript: 'javascript',
                python: 'python',
                java: 'java',
                cpp: 'cpp',
                c: 'c',
                php: 'php',
                ruby: 'ruby',
                go: 'go',
                rust: 'rust',
                typescript: 'typescript',
                csharp: 'csharp',
                swift: 'swift',
                kotlin: 'kotlin',
                bash: 'shell',
                sql: 'sql'
            };
            
            const monacoLang = languageMap[this.mode] || 'plaintext';
            monaco.editor.setModelLanguage(this.codeEditor.getModel(), monacoLang);
            
            // Load saved code or default template
            const savedCode = localStorage.getItem('playground_code_' + this.mode);
            if (savedCode) {
                this.codeEditor.setValue(savedCode);
            } else {
                const templates = this.templates[this.mode];
                if (templates && templates.length > 0) {
                    this.codeEditor.setValue(templates[0].code);
                } else {
                    this.codeEditor.setValue('// Write your ' + this.getLanguageDisplay() + ' code here');
                }
            }
        },
        
        getLanguageDisplay() {
            const names = {
                web: 'HTML / CSS / JS',
                javascript: 'JavaScript',
                python: 'Python 3',
                java: 'Java',
                cpp: 'C++',
                c: 'C',
                php: 'PHP',
                ruby: 'Ruby',
                go: 'Go',
                rust: 'Rust',
                typescript: 'TypeScript',
                csharp: 'C#',
                swift: 'Swift',
                kotlin: 'Kotlin',
                bash: 'Bash',
                sql: 'SQL'
            };
            return names[this.mode] || this.mode.toUpperCase();
        },
        
        getTemplatesForLanguage() {
            return this.templates[this.mode] || [];
        },
        
        loadTemplate(code) {
            if (this.codeEditor) {
                this.codeEditor.setValue(code);
            }
        },
        
        async runCode() {
            if (this.mode === 'web') {
                this.runWebCode();
            } else {
                await this.runSingleLanguageCode();
            }
        },
        
        runWebCode() {
            const html = this.htmlEditor?.getValue() || '';
            const css = this.cssEditor?.getValue() || '';
            const js = this.jsEditor?.getValue() || '';
            
            this.consoleMessages = [];
            
            const fullHTML = this.buildHTMLDocument(html, css, js);
            
            const iframe = document.getElementById('preview');
            iframe.srcdoc = fullHTML;
            
            this.saveWebCode();
            this.addConsoleMessage('Code executed successfully', 'log');
        },
        
        buildHTMLDocument(html, css, js) {
            const consoleCapture = `
                <script>
                    (function() {
                        const originalLog = console.log;
                        const originalError = console.error;
                        const originalWarn = console.warn;
                        
                        console.log = function(...args) {
                            window.parent.postMessage({
                                type: 'console',
                                level: 'log',
                                message: args.map(a => typeof a === 'object' ? JSON.stringify(a) : String(a)).join(' ')
                            }, '*');
                            originalLog.apply(console, args);
                        };
                        
                        console.error = function(...args) {
                            window.parent.postMessage({
                                type: 'console',
                                level: 'error',
                                message: args.map(a => String(a)).join(' ')
                            }, '*');
                            originalError.apply(console, args);
                        };
                        
                        console.warn = function(...args) {
                            window.parent.postMessage({
                                type: 'console',
                                level: 'warn',
                                message: args.map(a => String(a)).join(' ')
                            }, '*');
                            originalWarn.apply(console, args);
                        };
                        
                        window.addEventListener('error', function(e) {
                            window.parent.postMessage({
                                type: 'console',
                                level: 'error',
                                message: e.message + ' at line ' + e.lineno
                            }, '*');
                        });
                    })();
                <\/script>
            `;
            
            if (html.toLowerCase().includes('<!doctype html>')) {
                let modifiedHTML = html.replace('</head>', `<style>${css}</style>${consoleCapture}</head>`);
                modifiedHTML = modifiedHTML.replace('</body>', `<script>${js}<\/script></body>`);
                return modifiedHTML;
            } else {
                return `<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>${css}</style>
    ${consoleCapture}
</head>
<body>
    ${html}
    <script>${js}<\/script>
</body>
</html>`;
            }
        },
        
        async runSingleLanguageCode() {
            this.running = true;
            this.output = '';
            this.error = '';

            const code = this.codeEditor?.getValue() || '';
            
            if (!code.trim()) {
                this.error = 'Please write some code first.';
                this.running = false;
                return;
            }

            try {
                const response = await fetch('<?= url('/code/execute') ?>', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    body: new URLSearchParams({
                        code: code,
                        language: this.mode,
                        stdin: this.stdin
                    })
                });

                const data = await response.json();

                if (data.success) {
                    const result = data.result;
                    if (result.stdout) {
                        this.output = result.stdout;
                    } else if (result.stderr) {
                        this.error = result.stderr;
                    } else if (result.compile_output) {
                        this.error = result.compile_output;
                    } else if (result.status === 'Accepted') {
                        this.output = 'Program executed successfully (no output)';
                    } else {
                        this.error = 'Status: ' + result.status;
                    }
                    
                    this.executionStats = {
                        time: result.time,
                        memory: result.memory,
                        status: result.status,
                        runs: this.executionStats.runs + 1,
                        simulated: result.simulated || false
                    };
                } else {
                    this.error = data.error || 'Execution failed';
                }
            } catch (error) {
                this.error = 'Error: ' + error.message;
            } finally {
                this.running = false;
            }
        },
        
        formatTime(seconds) {
            if (seconds === null) return '-';
            if (seconds < 1) return (seconds * 1000).toFixed(0) + 'ms';
            return seconds.toFixed(2) + 's';
        },
        
        formatMemory(kb) {
            if (kb === null) return '-';
            if (kb < 1024) return kb + ' KB';
            return (kb / 1024).toFixed(1) + ' MB';
        },
        
        clearOutput() {
            this.output = '';
            this.error = '';
            this.consoleMessages = [];
        },
        
        resetCode() {
            if (!confirm('Are you sure you want to reset all code?')) return;
            
            if (this.mode === 'web') {
                this.htmlEditor?.setValue(this.getStarterHTML());
                this.cssEditor?.setValue(this.getStarterCSS());
                this.jsEditor?.setValue(this.getStarterJS());
                localStorage.removeItem('nebatech_playground_web');
                this.runCode();
            } else {
                localStorage.removeItem('playground_code_' + this.mode);
                this.updateSingleLanguageEditor();
            }
            this.clearOutput();
        },
        
        downloadCode() {
            let content, filename;
            
            if (this.mode === 'web') {
                const html = this.htmlEditor?.getValue() || '';
                const css = this.cssEditor?.getValue() || '';
                const js = this.jsEditor?.getValue() || '';
                content = this.buildHTMLDocument(html, css, js);
                filename = 'project.html';
            } else {
                content = this.codeEditor?.getValue() || '';
                const extensions = {
                    javascript: 'js', python: 'py', java: 'java', cpp: 'cpp', c: 'c',
                    php: 'php', ruby: 'rb', go: 'go', rust: 'rs', typescript: 'ts',
                    csharp: 'cs', swift: 'swift', kotlin: 'kt', bash: 'sh', sql: 'sql'
                };
                filename = 'code.' + (extensions[this.mode] || 'txt');
            }
            
            const blob = new Blob([content], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = filename;
            a.click();
            URL.revokeObjectURL(url);
        },
        
        saveWebCode() {
            const code = {
                html: this.htmlEditor?.getValue() || '',
                css: this.cssEditor?.getValue() || '',
                js: this.jsEditor?.getValue() || ''
            };
            localStorage.setItem('nebatech_playground_web', JSON.stringify(code));
        },
        
        autoSaveCode() {
            clearTimeout(this.saveTimeout);
            this.saveTimeout = setTimeout(() => {
                if (this.mode === 'web') {
                    this.saveWebCode();
                } else {
                    localStorage.setItem('playground_code_' + this.mode, this.codeEditor?.getValue() || '');
                }
                this.autoSaved = true;
                setTimeout(() => this.autoSaved = false, 2000);
            }, 1000);
        },
        
        loadSavedCode() {
            if (this.mode === 'web') {
                const saved = localStorage.getItem('nebatech_playground_web');
                if (saved) {
                    try {
                        const code = JSON.parse(saved);
                        this.htmlEditor?.setValue(code.html || this.getStarterHTML());
                        this.cssEditor?.setValue(code.css || this.getStarterCSS());
                        this.jsEditor?.setValue(code.js || this.getStarterJS());
                    } catch (e) {
                        console.error('Failed to load saved code:', e);
                    }
                }
            } else {
                this.updateSingleLanguageEditor();
            }
        },
        
        addConsoleMessage(message, type = 'log') {
            const time = new Date().toLocaleTimeString();
            this.consoleMessages.push({ message, type, time });
        },
        
        toggleTheme() {
            this.darkTheme = !this.darkTheme;
            localStorage.setItem('playground_theme', this.darkTheme ? 'dark' : 'light');
            
            const theme = this.darkTheme ? 'vs-dark' : 'vs-light';
            [this.htmlEditor, this.cssEditor, this.jsEditor, this.codeEditor].forEach(editor => {
                if (editor) {
                    monaco.editor.setTheme(theme);
                }
            });
        },
        
        increaseFontSize() {
            if (this.fontSize < 24) {
                this.fontSize += 2;
                localStorage.setItem('playground_fontsize', this.fontSize);
                this.updateEditorFontSize();
            }
        },
        
        decreaseFontSize() {
            if (this.fontSize > 10) {
                this.fontSize -= 2;
                localStorage.setItem('playground_fontsize', this.fontSize);
                this.updateEditorFontSize();
            }
        },
        
        updateEditorFontSize() {
            [this.htmlEditor, this.cssEditor, this.jsEditor, this.codeEditor].forEach(editor => {
                if (editor) {
                    editor.updateOptions({ fontSize: this.fontSize });
                }
            });
        },
        
        toggleFullscreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen();
                this.isFullscreen = true;
            } else {
                document.exitFullscreen();
                this.isFullscreen = false;
            }
        },
        
        // AI Review
        async requestAIReview() {
            if (this.aiReviewLoading) return;
            
            this.aiReviewLoading = true;
            
            let code, language;
            
            if (this.mode === 'web') {
                const html = this.htmlEditor?.getValue() || '';
                const css = this.cssEditor?.getValue() || '';
                const js = this.jsEditor?.getValue() || '';
                code = `<!-- HTML -->\n${html}\n\n/* CSS */\n${css}\n\n// JavaScript\n${js}`;
                language = 'html';
            } else {
                code = this.codeEditor?.getValue() || '';
                language = this.mode;
            }
            
            try {
                const response = await fetch('/api/ai/review-code', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        code: code,
                        language: language,
                        assignment_description: 'Code Playground exercise'
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    this.aiReview = data;
                    this.showAIReviewModal = true;
                } else {
                    alert('AI review failed: ' + (data.error || 'Unknown error'));
                    if (data.error === 'Authentication required') {
                        alert('Please log in to use AI code review.');
                    }
                }
            } catch (error) {
                console.error('AI Review Error:', error);
                alert('Failed to get AI review. Please try again.');
            } finally {
                this.aiReviewLoading = false;
            }
        },
        
        closeAIReviewModal() {
            this.showAIReviewModal = false;
        }
    };
}
</script>
