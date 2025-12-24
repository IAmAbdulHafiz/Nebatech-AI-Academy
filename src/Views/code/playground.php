<?php
$title = 'Code Playground';
?>

<style>
    [x-cloak] { display: none !important; }
    .editor-container { height: calc(100vh - 240px); min-height: 450px; }
    .ace-editor { height: 100%; width: 100%; font-size: 14px; }
    .preview-frame { width: 100%; border: none; background: white; }
    .console-output { 
        height: 130px; 
        overflow-y: auto; 
        background: #1e1e1e; 
        color: #d4d4d4; 
        padding: 10px; 
        font-family: 'Consolas', 'Monaco', monospace; 
        font-size: 13px; 
    }
    .console-log { color: #d4d4d4; }
    .console-error { color: #f87171; }
    .console-warn { color: #fbbf24; }
    .console-info { color: #60a5fa; }
    .tab-btn { 
        padding: 10px 20px; 
        cursor: pointer; 
        border: none; 
        background: #f3f4f6; 
        transition: all 0.2s; 
        font-weight: 500;
    }
    .tab-btn:hover { background: #e5e7eb; }
    .tab-btn.active { 
        background: white; 
        border-bottom: 2px solid #10b981; 
        color: #10b981; 
        font-weight: 600; 
    }
    kbd { 
        font-family: ui-monospace, monospace; 
        padding: 2px 6px; 
        background: #f3f4f6; 
        border-radius: 4px; 
        font-size: 11px;
    }
    .dark-editor { background: #1e1e1e; }
    /* Hide inactive editors */
    .editor-wrapper { display: none; height: 100%; }
    .editor-wrapper.active { display: block; }
</style>

<div x-data="playground()" x-init="init()" class="min-h-screen bg-gray-100">
    
    <!-- Sticky Header -->
    <div class="bg-white border-b shadow-sm sticky top-0 z-20">
        <div class="container mx-auto px-4 py-3">
            <div class="flex items-center justify-between flex-wrap gap-3">
                <!-- Left: Title & Language -->
                <div class="flex items-center gap-4 flex-wrap">
                    <h1 class="text-xl font-bold text-gray-900">
                        <i class="fas fa-code text-primary mr-2"></i>Code Playground
                    </h1>
                    
                    <!-- Language/Mode Selector -->
                    <select x-model="mode" @change="onModeChange()" 
                            class="border border-gray-300 rounded-lg px-3 py-2 font-medium focus:ring-2 focus:ring-primary">
                        <optgroup label="Web Development">
                            <option value="web">HTML / CSS / JS</option>
                        </optgroup>
                        <optgroup label="Languages">
                            <?php foreach ($languages ?? [] as $key => $lang): ?>
                                <?php if (!in_array($key, ['html', 'css'])): ?>
                                <option value="<?= $key ?>"><?= htmlspecialchars($lang['name']) ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </optgroup>
                    </select>
                    
                    <!-- Theme Toggle -->
                    <button @click="toggleTheme()" 
                            class="p-2 rounded-lg border hover:bg-gray-100" 
                            :title="darkTheme ? 'Light Theme' : 'Dark Theme'">
                        <i class="fas" :class="darkTheme ? 'fa-sun text-yellow-500' : 'fa-moon text-gray-600'"></i>
                    </button>
                    
                    <!-- Font Size -->
                    <div class="flex items-center border rounded-lg">
                        <button @click="changeFontSize(-1)" class="px-2 py-1 hover:bg-gray-100 rounded-l-lg">
                            <i class="fas fa-minus text-xs"></i>
                        </button>
                        <span class="px-2 text-sm text-gray-600" x-text="fontSize + 'px'"></span>
                        <button @click="changeFontSize(1)" class="px-2 py-1 hover:bg-gray-100 rounded-r-lg">
                            <i class="fas fa-plus text-xs"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Right: Actions -->
                <div class="flex items-center gap-2 flex-wrap">
                    <!-- Run -->
                    <button @click="runCode()" :disabled="running" 
                            class="px-5 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 disabled:opacity-50 font-medium flex items-center gap-2">
                        <i class="fas" :class="running ? 'fa-spinner fa-spin' : 'fa-play'"></i>
                        <span x-text="running ? 'Running...' : 'Run'"></span>
                    </button>
                    
                    <!-- AI Review -->
                    <button @click="requestAIReview()" :disabled="aiLoading"
                            class="px-4 py-2 bg-violet-600 text-white rounded-lg hover:bg-violet-700 disabled:opacity-50 font-medium flex items-center gap-2">
                        <i class="fas fa-robot" :class="aiLoading && 'animate-pulse'"></i>
                        <span x-text="aiLoading ? 'Reviewing...' : 'AI Review'"></span>
                    </button>
                    
                    <!-- Reset -->
                    <button @click="resetCode()" 
                            class="px-3 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300" title="Reset">
                        <i class="fas fa-undo"></i>
                    </button>
                    
                    <!-- Download -->
                    <button @click="downloadCode()" 
                            class="px-3 py-2 bg-primary text-white rounded-lg hover:bg-blue-700" title="Download">
                        <i class="fas fa-download"></i>
                    </button>
                    
                    <!-- Fullscreen -->
                    <button @click="toggleFullscreen()" 
                            class="px-3 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-800" title="Fullscreen">
                        <i class="fas" :class="isFullscreen ? 'fa-compress' : 'fa-expand'"></i>
                    </button>
                </div>
            </div>
            
            <!-- Shortcuts hint -->
            <div class="mt-2 flex items-center gap-4 text-xs text-gray-500">
                <span><kbd>Ctrl+Enter</kbd> Run</span>
                <span><kbd>Ctrl+S</kbd> Save</span>
                <span x-show="autoSaved" x-transition class="text-green-600 ml-auto">
                    <i class="fas fa-check"></i> Auto-saved
                </span>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-4">
        <!-- Layout Toggle (Web mode) -->
        <div x-show="mode === 'web'" class="mb-3 flex gap-2">
            <button @click="layout = 'horizontal'" 
                    :class="layout === 'horizontal' ? 'bg-green-600 text-white' : 'bg-white'"
                    class="px-3 py-1.5 rounded-lg border text-sm">
                <i class="fas fa-columns mr-1"></i> Side by Side
            </button>
            <button @click="layout = 'vertical'" 
                    :class="layout === 'vertical' ? 'bg-green-600 text-white' : 'bg-white'"
                    class="px-3 py-1.5 rounded-lg border text-sm">
                <i class="fas fa-grip-lines mr-1"></i> Stacked
            </button>
        </div>

        <!-- Editor Grid -->
        <div class="editor-container" 
             :class="{
                 'grid grid-cols-2 gap-4': mode === 'web' && layout === 'horizontal',
                 'grid grid-rows-2 gap-4': mode === 'web' && layout === 'vertical',
                 'grid grid-cols-1 lg:grid-cols-2 gap-4': mode !== 'web'
             }">
            
            <!-- Code Panel -->
            <div class="bg-white rounded-lg shadow overflow-hidden flex flex-col" :class="darkTheme && 'dark-editor'">
                <!-- Web Mode Tabs -->
                <div x-show="mode === 'web'" class="flex border-b" :class="darkTheme ? 'bg-gray-800 border-gray-700' : 'bg-gray-50'">
                    <button @click="switchTab('html')" :class="activeTab === 'html' && 'active'" class="tab-btn">
                        <i class="fab fa-html5 text-orange-500 mr-1"></i> HTML
                    </button>
                    <button @click="switchTab('css')" :class="activeTab === 'css' && 'active'" class="tab-btn">
                        <i class="fab fa-css3-alt text-blue-500 mr-1"></i> CSS
                    </button>
                    <button @click="switchTab('js')" :class="activeTab === 'js' && 'active'" class="tab-btn">
                        <i class="fab fa-js text-yellow-500 mr-1"></i> JavaScript
                    </button>
                </div>
                
                <!-- Single Language Header -->
                <div x-show="mode !== 'web'" class="px-4 py-2 border-b flex items-center justify-between"
                     :class="darkTheme ? 'bg-gray-800 border-gray-700 text-gray-200' : 'bg-gray-50'">
                    <span class="font-medium">
                        <i class="fas fa-code mr-2"></i><span x-text="getLanguageName()"></span>
                    </span>
                </div>
                
                <!-- Ace Editors - One per tab, show/hide with CSS -->
                <div class="flex-1 relative">
                    <div id="htmlEditor" class="editor-wrapper ace-editor" :class="mode === 'web' && activeTab === 'html' && 'active'"></div>
                    <div id="cssEditor" class="editor-wrapper ace-editor" :class="mode === 'web' && activeTab === 'css' && 'active'"></div>
                    <div id="jsEditor" class="editor-wrapper ace-editor" :class="mode === 'web' && activeTab === 'js' && 'active'"></div>
                    <div id="singleEditor" class="editor-wrapper ace-editor" :class="mode !== 'web' && 'active'"></div>
                </div>
            </div>

            <!-- Output Panel -->
            <div class="bg-white rounded-lg shadow overflow-hidden flex flex-col" :class="darkTheme && 'dark-editor'">
                <!-- Header -->
                <div class="px-4 py-2 border-b flex items-center justify-between"
                     :class="darkTheme ? 'bg-gray-800 border-gray-700 text-gray-200' : 'bg-gray-50'">
                    <span class="font-medium">
                        <i class="fas" :class="mode === 'web' ? 'fa-eye' : 'fa-terminal'"></i>
                        <span x-text="mode === 'web' ? ' Live Preview' : ' Output'"></span>
                    </span>
                    <div class="flex items-center gap-2">
                        <button @click="clearOutput()" class="text-sm px-2 py-1 rounded hover:bg-gray-200"
                                :class="darkTheme && 'hover:bg-gray-700 text-gray-300'">
                            <i class="fas fa-times"></i> Clear
                        </button>
                        <button x-show="mode === 'web'" @click="runCode()" 
                                class="text-sm px-2 py-1 bg-primary text-white rounded hover:bg-blue-700">
                            <i class="fas fa-sync-alt"></i> Refresh
                        </button>
                    </div>
                </div>
                
                <!-- Web Mode: Preview + Console -->
                <div x-show="mode === 'web'" class="flex-1 flex flex-col">
                    <iframe id="preview" class="flex-1 preview-frame" sandbox="allow-scripts allow-modals"></iframe>
                    <div class="border-t" :class="darkTheme && 'border-gray-700'">
                        <div class="flex items-center justify-between bg-gray-800 text-white px-3 py-1.5 text-sm">
                            <span><i class="fas fa-terminal mr-2"></i>Console</span>
                            <span class="text-gray-400 text-xs" x-text="consoleMessages.length + ' message(s)'"></span>
                        </div>
                        <div class="console-output">
                            <template x-for="(msg, i) in consoleMessages" :key="i">
                                <div :class="'console-' + msg.type">
                                    <span class="text-gray-500" x-text="'[' + msg.time + '] '"></span>
                                    <span x-text="msg.text"></span>
                                </div>
                            </template>
                            <div x-show="consoleMessages.length === 0" class="text-gray-500 text-sm">
                                Console is empty. Run your code to see output.
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Single Language: Input + Output -->
                <div x-show="mode !== 'web'" class="flex-1 flex flex-col overflow-hidden">
                    <!-- stdin -->
                    <div class="border-b" :class="darkTheme ? 'border-gray-700' : ''">
                        <div class="px-4 py-2 cursor-pointer flex items-center justify-between text-sm"
                             :class="darkTheme ? 'bg-gray-800 text-gray-200' : 'bg-gray-50'"
                             @click="showStdin = !showStdin">
                            <span><i class="fas fa-keyboard mr-2"></i>Input (stdin)</span>
                            <i class="fas" :class="showStdin ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                        </div>
                        <div x-show="showStdin" x-transition class="p-2">
                            <textarea x-model="stdin" 
                                      class="w-full h-16 p-2 font-mono text-sm border rounded resize-none"
                                      :class="darkTheme && 'bg-gray-900 text-gray-100 border-gray-700'"
                                      placeholder="Enter input for your program..."></textarea>
                        </div>
                    </div>
                    
                    <!-- Output -->
                    <div class="flex-1 overflow-auto p-4" :class="darkTheme && 'bg-gray-900'">
                        <div x-show="!output && !error && !running" 
                             class="h-full flex flex-col items-center justify-center text-gray-400">
                            <i class="fas fa-play-circle text-4xl mb-2"></i>
                            <p>Run your code to see output</p>
                            <p class="text-xs mt-1">Press <kbd>Ctrl+Enter</kbd></p>
                        </div>
                        <div x-show="running" class="text-center py-8 text-blue-500">
                            <i class="fas fa-spinner fa-spin text-4xl"></i>
                            <p class="mt-2">Executing...</p>
                        </div>
                        <pre x-show="output && !running" class="font-mono text-sm whitespace-pre-wrap"
                             :class="darkTheme ? 'text-green-400' : 'text-gray-800'" x-text="output"></pre>
                        <pre x-show="error && !running" class="font-mono text-sm whitespace-pre-wrap text-red-500" x-text="error"></pre>
                    </div>
                    
                    <!-- Execution Stats -->
                    <div x-show="execStats.time !== null" 
                         class="border-t p-3 text-sm"
                         :class="darkTheme ? 'bg-gray-800 border-gray-700 text-gray-300' : 'bg-gray-50'">
                        <div class="flex items-center justify-between">
                            <span><i class="fas fa-clock mr-1"></i><span x-text="formatTime(execStats.time)"></span></span>
                            <span><i class="fas fa-memory mr-1"></i><span x-text="formatMemory(execStats.memory)"></span></span>
                            <span class="px-2 py-0.5 rounded-full text-xs"
                                  :class="execStats.status === 'Accepted' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'"
                                  x-text="execStats.status"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Code Templates (Single language mode) -->
        <div x-show="mode !== 'web' && templates[mode]?.length > 0" class="mt-4">
            <div class="bg-white rounded-lg shadow p-4" :class="darkTheme && 'bg-gray-800'">
                <h3 class="font-medium mb-3" :class="darkTheme && 'text-gray-200'">
                    <i class="fas fa-file-code mr-2 text-primary"></i>Code Templates
                </h3>
                <div class="flex flex-wrap gap-2">
                    <template x-for="tpl in templates[mode] || []" :key="tpl.name">
                        <button @click="loadTemplate(tpl.code)"
                                class="px-3 py-1.5 rounded border text-sm hover:border-primary hover:bg-primary/5"
                                :class="darkTheme ? 'border-gray-600 text-gray-300' : 'border-gray-200'">
                            <i class="fas fa-file-alt mr-1 text-primary"></i>
                            <span x-text="tpl.name"></span>
                        </button>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <!-- AI Review Modal -->
    <div x-show="showAIModal" x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4"
         @click.self="showAIModal = false"
         @keydown.escape.window="showAIModal = false">
        <div x-show="showAIModal"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[80vh] overflow-hidden">
            
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
                <button @click="showAIModal = false" class="text-white/80 hover:text-white">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <div class="p-6 overflow-y-auto max-h-[60vh] space-y-6">
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
                
                <div x-show="aiReview?.review?.summary" class="bg-gray-50 rounded-xl p-4">
                    <h4 class="font-semibold text-gray-900 mb-2">
                        <i class="fas fa-clipboard-list text-violet-600 mr-2"></i>Summary
                    </h4>
                    <p class="text-gray-600" x-text="aiReview?.review?.summary"></p>
                </div>
                
                <div x-show="aiReview?.review?.issues?.length > 0">
                    <h4 class="font-semibold text-gray-900 mb-3">
                        <i class="fas fa-exclamation-triangle text-amber-500 mr-2"></i>Issues Found
                    </h4>
                    <template x-for="(issue, i) in aiReview?.review?.issues || []" :key="i">
                        <div class="border-l-4 pl-4 py-2 mb-3"
                             :class="{
                                 'border-red-500 bg-red-50': issue.severity === 'error',
                                 'border-yellow-500 bg-yellow-50': issue.severity === 'warning',
                                 'border-blue-500 bg-blue-50': !issue.severity || issue.severity === 'info'
                             }">
                            <p class="font-medium text-gray-900" x-text="issue.title || issue.message"></p>
                            <p class="text-sm text-gray-600 mt-1" x-text="issue.description || issue.suggestion || ''"></p>
                        </div>
                    </template>
                </div>
                
                <div x-show="aiReview?.review?.suggestions?.length > 0">
                    <h4 class="font-semibold text-gray-900 mb-3">
                        <i class="fas fa-lightbulb text-green-500 mr-2"></i>Suggestions
                    </h4>
                    <template x-for="(s, i) in aiReview?.review?.suggestions || []" :key="i">
                        <div class="flex items-start gap-2 mb-2 text-gray-600">
                            <i class="fas fa-check-circle text-green-500 mt-1"></i>
                            <span x-text="s"></span>
                        </div>
                    </template>
                </div>
            </div>
            
            <div class="border-t px-6 py-4 bg-gray-50 flex justify-end gap-3">
                <button @click="showAIModal = false" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                    Close
                </button>
                <button @click="showAIModal = false; requestAIReview();" class="px-4 py-2 bg-violet-600 text-white rounded-lg hover:bg-violet-700">
                    <i class="fas fa-redo mr-2"></i>Review Again
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Ace Editor (Much lighter than Monaco) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.32.2/ace.min.js"></script>
<script>
function playground() {
    return {
        // State
        mode: 'web',
        activeTab: 'html',
        layout: 'horizontal',
        darkTheme: localStorage.getItem('playground_theme') === 'dark',
        fontSize: parseInt(localStorage.getItem('playground_fontsize')) || 14,
        isFullscreen: false,
        autoSaved: false,
        
        // Separate editors - key to performance
        editors: {},
        
        // Execution
        stdin: '',
        output: '',
        error: '',
        running: false,
        showStdin: false,
        execStats: { time: null, memory: null, status: null, simulated: false },
        
        // Console (web mode)
        consoleMessages: [],
        
        // AI Review
        aiLoading: false,
        aiReview: null,
        showAIModal: false,
        
        // Templates
        templates: {
            javascript: [
                { name: 'Hello World', code: '// JavaScript\nconsole.log("Hello, World!");' },
                { name: 'Array Operations', code: 'const nums = [1, 2, 3, 4, 5];\nconst doubled = nums.map(n => n * 2);\nconsole.log("Doubled:", doubled);' }
            ],
            python: [
                { name: 'Hello World', code: '# Python\nprint("Hello, World!")' },
                { name: 'List Comprehension', code: 'numbers = [1, 2, 3, 4, 5]\nsquared = [x**2 for x in numbers]\nprint("Squared:", squared)' }
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
                { name: 'Hello World', code: '<' + '?php\necho "Hello, World!\\n";?' + '>' }
            ],
            ruby: [
                { name: 'Hello World', code: '# Ruby\nputs "Hello, World!"' }
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
            // Wait for Ace to load
            if (typeof ace === 'undefined') {
                setTimeout(() => this.init(), 100);
                return;
            }
            
            // Create 4 separate Ace editors
            this.setupAceEditors();
            
            // Listen for console messages from iframe
            window.addEventListener('message', (e) => {
                if (e.data?.type === 'console') {
                    const time = new Date().toLocaleTimeString();
                    this.consoleMessages.push({ type: e.data.level, text: e.data.message, time });
                }
            });
            
            // Keyboard shortcuts
            document.addEventListener('keydown', (e) => {
                if (e.ctrlKey && e.key === 'Enter') {
                    e.preventDefault();
                    this.runCode();
                } else if (e.ctrlKey && e.key === 's') {
                    e.preventDefault();
                    this.saveCode();
                }
            });
        },
        
        setupAceEditors() {
            const theme = this.darkTheme ? 'ace/theme/monokai' : 'ace/theme/chrome';
            
            // HTML Editor
            this.editors.html = ace.edit('htmlEditor');
            this.editors.html.setTheme(theme);
            this.editors.html.session.setMode('ace/mode/html');
            this.editors.html.setValue(this.defaultHTML(), -1);
            this.editors.html.setFontSize(this.fontSize);
            
            // CSS Editor
            this.editors.css = ace.edit('cssEditor');
            this.editors.css.setTheme(theme);
            this.editors.css.session.setMode('ace/mode/css');
            this.editors.css.setValue(this.defaultCSS(), -1);
            this.editors.css.setFontSize(this.fontSize);
            
            // JS Editor
            this.editors.js = ace.edit('jsEditor');
            this.editors.js.setTheme(theme);
            this.editors.js.session.setMode('ace/mode/javascript');
            this.editors.js.setValue(this.defaultJS(), -1);
            this.editors.js.setFontSize(this.fontSize);
            
            // Single language editor
            this.editors.single = ace.edit('singleEditor');
            this.editors.single.setTheme(theme);
            this.editors.single.session.setMode('ace/mode/javascript');
            this.editors.single.setValue('// Select a language to start\nconsole.log("Hello!");', -1);
            this.editors.single.setFontSize(this.fontSize);
            
            // Load saved code
            this.loadSavedCode();
            
            // Set common options for all editors
            Object.values(this.editors).forEach(editor => {
                editor.setOptions({
                    showPrintMargin: false,
                    wrap: true,
                    tabSize: 2
                });
            });
        },
        
        // Tab switching is now instant - just CSS show/hide!
        switchTab(tab) {
            this.activeTab = tab;
            // Force Ace to resize after tab becomes visible
            setTimeout(() => {
                if (this.editors[tab]) {
                    this.editors[tab].resize();
                }
            }, 10);
        },
        
        onModeChange() {
            if (this.mode === 'web') {
                this.activeTab = 'html';
                setTimeout(() => this.editors.html?.resize(), 10);
            } else {
                // Load saved or default code for this language
                const saved = localStorage.getItem('playground_code_' + this.mode);
                if (saved) {
                    this.editors.single.setValue(saved, -1);
                } else {
                    const tpls = this.templates[this.mode];
                    const code = tpls && tpls.length > 0 ? tpls[0].code : '// Write your code here';
                    this.editors.single.setValue(code, -1);
                }
                
                const modeMap = {
                    javascript: 'javascript', python: 'python', java: 'java', 
                    cpp: 'c_cpp', c: 'c_cpp', php: 'php', ruby: 'ruby', go: 'golang',
                    rust: 'rust', typescript: 'typescript', csharp: 'csharp'
                };
                this.editors.single.session.setMode('ace/mode/' + (modeMap[this.mode] || 'text'));
                setTimeout(() => this.editors.single?.resize(), 10);
            }
            
            this.output = '';
            this.error = '';
            this.execStats = { time: null, memory: null, status: null, simulated: false };
        },
        
        runCode() {
            if (this.mode === 'web') {
                this.runWebCode();
            } else {
                this.runSingleCode();
            }
        },
        
        runWebCode() {
            this.consoleMessages = [];
            
            const htmlCode = this.editors.html.getValue();
            const cssCode = this.editors.css.getValue();
            const jsCode = this.editors.js.getValue();
            
            const consoleCapture = `<script>
                (function(){
                    const log=console.log, err=console.error, warn=console.warn;
                    console.log=(...a)=>{parent.postMessage({type:'console',level:'log',message:a.map(x=>typeof x==='object'?JSON.stringify(x):String(x)).join(' ')},'*');log(...a);};
                    console.error=(...a)=>{parent.postMessage({type:'console',level:'error',message:a.join(' ')},'*');err(...a);};
                    console.warn=(...a)=>{parent.postMessage({type:'console',level:'warn',message:a.join(' ')},'*');warn(...a);};
                    window.onerror=(m,s,l)=>parent.postMessage({type:'console',level:'error',message:m+' (line '+l+')'},'*');
                })();
            <\/script>`;
            
            const html = `<!DOCTYPE html><html><head><meta charset="UTF-8"><style>${cssCode}</style>${consoleCapture}</head><body>${htmlCode}<script>${jsCode}<\/script></body></html>`;
            
            const iframe = document.getElementById('preview');
            if (iframe) iframe.srcdoc = html;
        },
        
        async runSingleCode() {
            this.running = true;
            this.output = '';
            this.error = '';
            
            const code = this.editors.single.getValue();
            if (!code.trim()) {
                this.error = 'Please write some code first.';
                this.running = false;
                return;
            }
            
            try {
                const resp = await fetch('<?= url('/code/execute') ?>', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({ code, language: this.mode, stdin: this.stdin })
                });
                const data = await resp.json();
                
                if (data.success) {
                    const r = data.result;
                    this.output = r.stdout || '';
                    this.error = r.stderr || r.compile_output || '';
                    if (!this.output && !this.error && r.status === 'Accepted') {
                        this.output = 'Program executed successfully (no output)';
                    }
                    this.execStats = {
                        time: r.time,
                        memory: r.memory,
                        status: r.status,
                        simulated: r.simulated || false
                    };
                } else {
                    this.error = data.error || 'Execution failed';
                }
            } catch (e) {
                this.error = 'Error: ' + e.message;
            }
            
            this.running = false;
        },
        
        async requestAIReview() {
            this.aiLoading = true;
            
            let code, language;
            if (this.mode === 'web') {
                code = `<!-- HTML -->\n${this.editors.html.getValue()}\n\n/* CSS */\n${this.editors.css.getValue()}\n\n// JavaScript\n${this.editors.js.getValue()}`;
                language = 'html';
            } else {
                code = this.editors.single.getValue();
                language = this.mode;
            }
            
            try {
                const resp = await fetch('<?= url('/api/ai/review-code') ?>', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ code, language, assignment_description: 'Code Playground exercise' })
                });
                const data = await resp.json();
                
                if (data.success) {
                    this.aiReview = data;
                    this.showAIModal = true;
                } else {
                    alert('AI review failed: ' + (data.error || 'Unknown error'));
                }
            } catch (e) {
                alert('AI review failed: ' + e.message);
            }
            
            this.aiLoading = false;
        },
        
        loadTemplate(code) {
            if (this.editors.single) {
                this.editors.single.setValue(code, -1);
            }
        },
        
        resetCode() {
            if (!confirm('Reset all code to default?')) return;
            
            if (this.mode === 'web') {
                this.editors.html.setValue(this.defaultHTML(), -1);
                this.editors.css.setValue(this.defaultCSS(), -1);
                this.editors.js.setValue(this.defaultJS(), -1);
                this.activeTab = 'html';
                localStorage.removeItem('playground_web');
            } else {
                localStorage.removeItem('playground_code_' + this.mode);
                this.onModeChange();
            }
        },
        
        downloadCode() {
            let content, filename;
            
            if (this.mode === 'web') {
                content = `<!DOCTYPE html>\n<html>\n<head>\n<style>\n${this.editors.css.getValue()}\n</style>\n</head>\n<body>\n${this.editors.html.getValue()}\n<script>\n${this.editors.js.getValue()}\n<\/script>\n</body>\n</html>`;
                filename = 'project.html';
            } else {
                content = this.editors.single.getValue();
                const ext = { javascript: 'js', python: 'py', java: 'java', cpp: 'cpp', c: 'c', php: 'php', ruby: 'rb', go: 'go', rust: 'rs', typescript: 'ts', csharp: 'cs' };
                filename = 'code.' + (ext[this.mode] || 'txt');
            }
            
            const a = document.createElement('a');
            a.href = URL.createObjectURL(new Blob([content], { type: 'text/plain' }));
            a.download = filename;
            a.click();
        },
        
        saveCode() {
            if (this.mode === 'web') {
                localStorage.setItem('playground_web', JSON.stringify({
                    html: this.editors.html.getValue(),
                    css: this.editors.css.getValue(),
                    js: this.editors.js.getValue()
                }));
            } else {
                localStorage.setItem('playground_code_' + this.mode, this.editors.single.getValue());
            }
            this.autoSaved = true;
            setTimeout(() => this.autoSaved = false, 2000);
        },
        
        loadSavedCode() {
            const saved = localStorage.getItem('playground_web');
            if (saved) {
                try {
                    const c = JSON.parse(saved);
                    if (c.html) this.editors.html.setValue(c.html, -1);
                    if (c.css) this.editors.css.setValue(c.css, -1);
                    if (c.js) this.editors.js.setValue(c.js, -1);
                } catch (e) {}
            }
        },
        
        clearOutput() {
            this.output = '';
            this.error = '';
            this.consoleMessages = [];
        },
        
        toggleTheme() {
            this.darkTheme = !this.darkTheme;
            localStorage.setItem('playground_theme', this.darkTheme ? 'dark' : 'light');
            const theme = this.darkTheme ? 'ace/theme/monokai' : 'ace/theme/chrome';
            Object.values(this.editors).forEach(editor => editor.setTheme(theme));
        },
        
        changeFontSize(delta) {
            const newSize = this.fontSize + (delta * 2);
            if (newSize >= 10 && newSize <= 24) {
                this.fontSize = newSize;
                localStorage.setItem('playground_fontsize', newSize);
                Object.values(this.editors).forEach(editor => editor.setFontSize(newSize));
            }
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
        
        getLanguageName() {
            const names = {
                javascript: 'JavaScript', python: 'Python 3', java: 'Java', cpp: 'C++', c: 'C',
                php: 'PHP', ruby: 'Ruby', go: 'Go', rust: 'Rust', typescript: 'TypeScript',
                csharp: 'C#', swift: 'Swift', kotlin: 'Kotlin', bash: 'Bash', sql: 'SQL'
            };
            return names[this.mode] || this.mode;
        },
        
        formatTime(s) {
            if (s === null) return '-';
            return s < 1 ? (s * 1000).toFixed(0) + 'ms' : s.toFixed(2) + 's';
        },
        
        formatMemory(kb) {
            if (kb === null) return '-';
            return kb < 1024 ? kb + ' KB' : (kb / 1024).toFixed(1) + ' MB';
        },
        
        defaultHTML() {
            return '<h1>Hello World!</h1>\n<p>Welcome to the Code Playground</p>\n<button id="btn">Click me!</button>';
        },
        
        defaultCSS() {
            return 'body {\n    font-family: "Segoe UI", Arial, sans-serif;\n    padding: 20px;\n    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);\n    min-height: 100vh;\n    color: white;\n}\n\nh1 {\n    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);\n}\n\nbutton {\n    background: #10b981;\n    color: white;\n    border: none;\n    padding: 12px 24px;\n    border-radius: 8px;\n    font-size: 16px;\n    cursor: pointer;\n}';
        },
        
        defaultJS() {
            return 'console.log("Hello from JavaScript!");\n\nlet clicks = 0;\ndocument.getElementById("btn").addEventListener("click", () => {\n    clicks++;\n    console.log("Button clicked " + clicks + " time(s)");\n});';
        }
    };
}
</script>
