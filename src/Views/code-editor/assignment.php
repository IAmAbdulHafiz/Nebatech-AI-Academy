<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($assignment['title']) ?> - Nebatech AI Academy</title>
    <link rel="stylesheet" href="<?= asset('css/main.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.44.0/min/vs/editor/editor.main.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="h-full bg-gray-50" x-data="codeEditor()">
    
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-full px-4 py-3 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <a href="<?= url('/dashboard') ?>" class="text-gray-600 hover:text-gray-900">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                    <div class="border-l border-gray-300 h-6"></div>
                    <h1 class="text-xl font-bold text-gray-900">
                        <?= htmlspecialchars($assignment['title']) ?>
                    </h1>
                    <?php if ($submission): ?>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full 
                            <?= $submission['status'] === 'graded' ? 'bg-green-100 text-green-800' : 
                                ($submission['status'] === 'submitted' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800') ?>">
                            <?= ucfirst($submission['status']) ?>
                            <?php if ($submission['score'] !== null): ?>
                                - <?= $submission['score'] ?>/<?= $assignment['max_score'] ?>
                            <?php endif; ?>
                        </span>
                    <?php endif; ?>
                </div>
                <div class="flex items-center space-x-3">
                    <button @click="autoSave()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                        <i class="fas fa-save"></i> Save Draft
                    </button>
                    <button @click="submitAssignment()" class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">
                        <i class="fas fa-check"></i> Submit Assignment
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="h-[calc(100vh-73px)] flex flex-col">
        
        <!-- Layout Toggle -->
        <div class="bg-white border-b border-gray-200 px-4 py-2">
            <div class="flex items-center justify-between">
                <div class="flex space-x-2">
                    <button @click="layout = 'horizontal'" 
                            :class="layout === 'horizontal' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700'"
                            class="px-3 py-1.5 text-sm font-medium rounded-lg hover:bg-blue-50">
                        <i class="fas fa-columns"></i> Horizontal Split
                    </button>
                    <button @click="layout = 'vertical'" 
                            :class="layout === 'vertical' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700'"
                            class="px-3 py-1.5 text-sm font-medium rounded-lg hover:bg-blue-50">
                        <i class="fas fa-grip-lines"></i> Vertical Split
                    </button>
                    <button @click="layout = 'tabs'" 
                            :class="layout === 'tabs' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700'"
                            class="px-3 py-1.5 text-sm font-medium rounded-lg hover:bg-blue-50">
                        <i class="fas fa-window-maximize"></i> Tabbed View
                    </button>
                </div>
                <div class="text-sm text-gray-600">
                    <i class="fas fa-keyboard"></i> Ctrl+S to save, Ctrl+Enter to run
                </div>
            </div>
        </div>

        <!-- Editor and Preview Container -->
        <div class="flex-1 overflow-hidden">
            
            <!-- Horizontal Layout -->
            <div x-show="layout === 'horizontal'" class="h-full flex">
                
                <!-- Code Editor Panel -->
                <div class="w-1/2 flex flex-col border-r border-gray-200 bg-white">
                    <div class="flex-shrink-0 bg-gray-50 border-b border-gray-200">
                        <div class="flex space-x-1 px-2 py-2">
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
                        </div>
                    </div>
                    <div class="flex-1 overflow-hidden">
                        <div x-show="activeTab === 'html'" id="html-editor" class="h-full"></div>
                        <div x-show="activeTab === 'css'" id="css-editor" class="h-full"></div>
                        <div x-show="activeTab === 'js'" id="js-editor" class="h-full"></div>
                    </div>
                </div>

                <!-- Preview Panel -->
                <div class="w-1/2 flex flex-col bg-white">
                    <div class="flex-shrink-0 bg-gray-50 border-b border-gray-200 px-4 py-2 flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">
                            <i class="fas fa-eye"></i> Live Preview
                        </span>
                        <div class="flex items-center space-x-2">
                            <button @click="clearConsole()" class="text-sm text-gray-600 hover:text-gray-900">
                                <i class="fas fa-broom"></i> Clear Console
                            </button>
                            <button @click="refreshPreview()" class="text-sm text-gray-600 hover:text-gray-900">
                                <i class="fas fa-sync-alt"></i> Refresh
                            </button>
                        </div>
                    </div>
                    <div class="flex-1 overflow-hidden">
                        <iframe id="preview-frame" sandbox="allow-scripts allow-modals" class="w-full h-full border-0"></iframe>
                    </div>
                    <!-- Console Output -->
                    <div class="h-48 border-t border-gray-200 bg-gray-900 text-white p-4 overflow-y-auto font-mono text-sm">
                        <div class="mb-2 text-gray-400">Console Output:</div>
                        <template x-for="(msg, index) in consoleMessages" :key="index">
                            <div :class="{
                                'text-gray-300': msg.type === 'log',
                                'text-red-400': msg.type === 'error',
                                'text-yellow-400': msg.type === 'warn',
                                'text-blue-400': msg.type === 'info'
                            }" class="mb-1">
                                <span class="text-gray-500" x-text="msg.time"></span>
                                <span x-text="msg.message"></span>
                            </div>
                        </template>
                        <div x-show="consoleMessages.length === 0" class="text-gray-500 italic">
                            No console output yet. Run your code to see output here.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vertical Layout -->
            <div x-show="layout === 'vertical'" class="h-full flex flex-col">
                
                <!-- Code Editor Panel -->
                <div class="h-1/2 flex flex-col border-b border-gray-200 bg-white">
                    <div class="flex-shrink-0 bg-gray-50 border-b border-gray-200">
                        <div class="flex space-x-1 px-2 py-2">
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
                        </div>
                    </div>
                    <div class="flex-1 overflow-hidden">
                        <div x-show="activeTab === 'html'" id="html-editor-v" class="h-full"></div>
                        <div x-show="activeTab === 'css'" id="css-editor-v" class="h-full"></div>
                        <div x-show="activeTab === 'js'" id="js-editor-v" class="h-full"></div>
                    </div>
                </div>

                <!-- Preview Panel -->
                <div class="h-1/2 flex flex-col bg-white">
                    <div class="flex-shrink-0 bg-gray-50 border-b border-gray-200 px-4 py-2 flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">
                            <i class="fas fa-eye"></i> Live Preview
                        </span>
                        <div class="flex items-center space-x-2">
                            <button @click="clearConsole()" class="text-sm text-gray-600 hover:text-gray-900">
                                <i class="fas fa-broom"></i> Clear Console
                            </button>
                            <button @click="refreshPreview()" class="text-sm text-gray-600 hover:text-gray-900">
                                <i class="fas fa-sync-alt"></i> Refresh
                            </button>
                        </div>
                    </div>
                    <div class="flex-1 overflow-hidden flex">
                        <iframe id="preview-frame-v" sandbox="allow-scripts allow-modals" class="w-2/3 h-full border-0 border-r border-gray-200"></iframe>
                        <!-- Console Output -->
                        <div class="w-1/3 bg-gray-900 text-white p-4 overflow-y-auto font-mono text-sm">
                            <div class="mb-2 text-gray-400">Console:</div>
                            <template x-for="(msg, index) in consoleMessages" :key="index">
                                <div :class="{
                                    'text-gray-300': msg.type === 'log',
                                    'text-red-400': msg.type === 'error',
                                    'text-yellow-400': msg.type === 'warn',
                                    'text-blue-400': msg.type === 'info'
                                }" class="mb-1 text-xs break-words">
                                    <span class="text-gray-500" x-text="msg.time"></span>
                                    <span x-text="msg.message"></span>
                                </div>
                            </template>
                            <div x-show="consoleMessages.length === 0" class="text-gray-500 italic text-xs">
                                No output yet
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabbed Layout -->
            <div x-show="layout === 'tabs'" class="h-full flex flex-col bg-white">
                <div class="flex-shrink-0 bg-gray-50 border-b border-gray-200">
                    <div class="flex space-x-1 px-2 py-2">
                        <button @click="activeMainTab = 'code'" 
                                :class="activeMainTab === 'code' ? 'bg-white border-b-2 border-blue-500 text-blue-600' : 'text-gray-600 hover:text-gray-900'"
                                class="px-4 py-2 text-sm font-medium rounded-t-lg">
                            <i class="fas fa-code"></i> Code Editor
                        </button>
                        <button @click="activeMainTab = 'preview'" 
                                :class="activeMainTab === 'preview' ? 'bg-white border-b-2 border-green-500 text-green-600' : 'text-gray-600 hover:text-gray-900'"
                                class="px-4 py-2 text-sm font-medium rounded-t-lg">
                            <i class="fas fa-eye"></i> Preview
                        </button>
                    </div>
                </div>

                <!-- Code Tab -->
                <div x-show="activeMainTab === 'code'" class="flex-1 flex flex-col overflow-hidden">
                    <div class="flex-shrink-0 bg-gray-100 border-b border-gray-200">
                        <div class="flex space-x-1 px-2 py-2">
                            <button @click="activeTab = 'html'" 
                                    :class="activeTab === 'html' ? 'bg-white text-orange-600' : 'text-gray-600 hover:text-gray-900'"
                                    class="px-4 py-2 text-sm font-medium rounded-lg">
                                <i class="fab fa-html5 text-orange-500"></i> HTML
                            </button>
                            <button @click="activeTab = 'css'" 
                                    :class="activeTab === 'css' ? 'bg-white text-blue-600' : 'text-gray-600 hover:text-gray-900'"
                                    class="px-4 py-2 text-sm font-medium rounded-lg">
                                <i class="fab fa-css3-alt text-blue-500"></i> CSS
                            </button>
                            <button @click="activeTab = 'js'" 
                                    :class="activeTab === 'js' ? 'bg-white text-yellow-600' : 'text-gray-600 hover:text-gray-900'"
                                    class="px-4 py-2 text-sm font-medium rounded-lg">
                                <i class="fab fa-js-square text-yellow-500"></i> JavaScript
                            </button>
                        </div>
                    </div>
                    <div class="flex-1 overflow-hidden">
                        <div x-show="activeTab === 'html'" id="html-editor-t" class="h-full"></div>
                        <div x-show="activeTab === 'css'" id="css-editor-t" class="h-full"></div>
                        <div x-show="activeTab === 'js'" id="js-editor-t" class="h-full"></div>
                    </div>
                </div>

                <!-- Preview Tab -->
                <div x-show="activeMainTab === 'preview'" class="flex-1 flex flex-col overflow-hidden">
                    <div class="flex-shrink-0 bg-gray-50 border-b border-gray-200 px-4 py-2 flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Live Preview</span>
                        <div class="flex items-center space-x-2">
                            <button @click="clearConsole()" class="text-sm text-gray-600 hover:text-gray-900">
                                <i class="fas fa-broom"></i> Clear Console
                            </button>
                            <button @click="refreshPreview()" class="text-sm text-gray-600 hover:text-gray-900">
                                <i class="fas fa-sync-alt"></i> Refresh
                            </button>
                        </div>
                    </div>
                    <div class="flex-1 overflow-hidden">
                        <iframe id="preview-frame-t" sandbox="allow-scripts allow-modals" class="w-full h-full border-0"></iframe>
                    </div>
                    <!-- Console Output -->
                    <div class="h-48 border-t border-gray-200 bg-gray-900 text-white p-4 overflow-y-auto font-mono text-sm">
                        <div class="mb-2 text-gray-400">Console Output:</div>
                        <template x-for="(msg, index) in consoleMessages" :key="index">
                            <div :class="{
                                'text-gray-300': msg.type === 'log',
                                'text-red-400': msg.type === 'error',
                                'text-yellow-400': msg.type === 'warn',
                                'text-blue-400': msg.type === 'info'
                            }" class="mb-1">
                                <span class="text-gray-500" x-text="msg.time"></span>
                                <span x-text="msg.message"></span>
                            </div>
                        </template>
                        <div x-show="consoleMessages.length === 0" class="text-gray-500 italic">
                            No console output yet
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Assignment Instructions Panel -->
        <div class="bg-blue-50 border-t border-blue-200 px-6 py-4">
            <div class="flex items-start space-x-3">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-600 text-xl"></i>
                </div>
                <div class="flex-1">
                    <h3 class="text-sm font-semibold text-blue-900 mb-2">Assignment Instructions:</h3>
                    <div class="text-sm text-blue-800 prose prose-sm max-w-none">
                        <?= nl2br(htmlspecialchars($assignment['description'])) ?>
                    </div>
                    <?php if (!empty($assignment['requirements'])): ?>
                        <div class="mt-3">
                            <h4 class="text-sm font-semibold text-blue-900 mb-1">Requirements:</h4>
                            <ul class="text-sm text-blue-800 list-disc list-inside space-y-1">
                                <?php 
                                $requirements = is_string($assignment['requirements']) 
                                    ? json_decode($assignment['requirements'], true) 
                                    : $assignment['requirements'];
                                foreach ($requirements as $req): ?>
                                    <li><?= htmlspecialchars($req) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <div class="mt-3 flex items-center space-x-4 text-sm text-blue-700">
                        <span><i class="fas fa-trophy"></i> Max Score: <?= $assignment['max_score'] ?> points</span>
                        <?php if ($assignment['due_date']): ?>
                            <span><i class="fas fa-calendar"></i> Due: <?= date('M d, Y', strtotime($assignment['due_date'])) ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Monaco Editor CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.44.0/min/vs/loader.min.js"></script>
    
    <script>
    const ASSIGNMENT_ID = <?= $assignment['id'] ?>;
    const BASE_URL = '<?= url('/') ?>';
    
    function codeEditor() {
        return {
            layout: 'horizontal',
            activeTab: 'html',
            activeMainTab: 'code',
            htmlEditor: null,
            cssEditor: null,
            jsEditor: null,
            consoleMessages: [],
            autoRunTimeout: null,
            
            init() {
                this.loadMonaco();
                this.loadSavedCode();
                this.setupAutoSave();
                this.setupKeyboardShortcuts();
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
                    automaticLayout: true,
                    fontSize: 14,
                    wordWrap: 'on',
                    minimap: { enabled: false },
                    tabSize: 2
                };
                
                // Create editors for each layout
                this.htmlEditor = monaco.editor.create(document.getElementById('html-editor'), {
                    ...editorOptions,
                    language: 'html',
                    value: this.getStarterHTML()
                });
                
                this.cssEditor = monaco.editor.create(document.getElementById('css-editor'), {
                    ...editorOptions,
                    language: 'css',
                    value: this.getStarterCSS()
                });
                
                this.jsEditor = monaco.editor.create(document.getElementById('js-editor'), {
                    ...editorOptions,
                    language: 'javascript',
                    value: this.getStarterJS()
                });
                
                // Setup auto-run on code change
                [this.htmlEditor, this.cssEditor, this.jsEditor].forEach(editor => {
                    editor.onDidChangeModelContent(() => {
                        clearTimeout(this.autoRunTimeout);
                        this.autoRunTimeout = setTimeout(() => this.runCode(), 1000);
                    });
                });
                
                // Initial run
                setTimeout(() => this.runCode(), 500);
            },
            
            runCode() {
                const html = this.htmlEditor.getValue();
                const css = this.cssEditor.getValue();
                const js = this.jsEditor.getValue();
                
                const fullHTML = this.buildHTMLDocument(html, css, js);
                
                // Update all preview frames
                ['preview-frame', 'preview-frame-v', 'preview-frame-t'].forEach(id => {
                    const iframe = document.getElementById(id);
                    if (iframe) {
                        iframe.srcdoc = fullHTML;
                    }
                });
            },
            
            buildHTMLDocument(html, css, js) {
                return `<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>${css}</style>
</head>
<body>
${html}
<script>
// Console capture
(function() {
    const originalLog = console.log;
    const originalError = console.error;
    const originalWarn = console.warn;
    const originalInfo = console.info;
    
    console.log = function(...args) {
        window.parent.postMessage({ type: 'log', message: args.join(' ') }, '*');
        originalLog.apply(console, args);
    };
    
    console.error = function(...args) {
        window.parent.postMessage({ type: 'error', message: args.join(' ') }, '*');
        originalError.apply(console, args);
    };
    
    console.warn = function(...args) {
        window.parent.postMessage({ type: 'warn', message: args.join(' ') }, '*');
        originalWarn.apply(console, args);
    };
    
    console.info = function(...args) {
        window.parent.postMessage({ type: 'info', message: args.join(' ') }, '*');
        originalInfo.apply(console, args);
    };
    
    window.onerror = function(message, source, lineno, colno, error) {
        window.parent.postMessage({ type: 'error', message: 'Error: ' + message + ' (Line ' + lineno + ')' }, '*');
        return false;
    };
})();

${js}
</script>
</body>
</html>`;
            },
            
            refreshPreview() {
                this.runCode();
            },
            
            clearConsole() {
                this.consoleMessages = [];
            },
            
            addConsoleMessage(message, type) {
                const time = new Date().toLocaleTimeString();
                this.consoleMessages.push({ message, type, time });
            },
            
            async autoSave() {
                const html = this.htmlEditor.getValue();
                const css = this.cssEditor.getValue();
                const js = this.jsEditor.getValue();
                
                try {
                    const response = await fetch(BASE_URL + '/assignments/save', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: new URLSearchParams({
                            assignment_id: ASSIGNMENT_ID,
                            code: this.buildHTMLDocument(html, css, js)
                        })
                    });
                    
                    const data = await response.json();
                    if (data.success) {
                        this.showNotification('Draft saved successfully', 'success');
                    } else {
                        this.showNotification('Failed to save draft', 'error');
                    }
                } catch (error) {
                    console.error('Save error:', error);
                    this.showNotification('Failed to save draft', 'error');
                }
            },
            
            async submitAssignment() {
                if (!confirm('Are you sure you want to submit this assignment? You can resubmit later if needed.')) {
                    return;
                }
                
                const html = this.htmlEditor.getValue();
                const css = this.cssEditor.getValue();
                const js = this.jsEditor.getValue();
                
                try {
                    const response = await fetch(BASE_URL + '/assignments/submit', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: new URLSearchParams({
                            assignment_id: ASSIGNMENT_ID,
                            html: html,
                            css: css,
                            js: js
                        })
                    });
                    
                    const data = await response.json();
                    if (data.success) {
                        this.showNotification('Assignment submitted successfully!', 'success');
                        setTimeout(() => {
                            window.location.href = BASE_URL + '/dashboard';
                        }, 2000);
                    } else {
                        this.showNotification(data.error || 'Failed to submit assignment', 'error');
                    }
                } catch (error) {
                    console.error('Submit error:', error);
                    this.showNotification('Failed to submit assignment', 'error');
                }
            },
            
            async loadSavedCode() {
                try {
                    const response = await fetch(BASE_URL + '/assignments/' + ASSIGNMENT_ID + '/load-code');
                    const data = await response.json();
                    
                    if (data.success && data.html) {
                        this.htmlEditor.setValue(data.html);
                        this.cssEditor.setValue(data.css);
                        this.jsEditor.setValue(data.js);
                        this.runCode();
                    }
                } catch (error) {
                    console.log('No saved code found');
                }
            },
            
            setupAutoSave() {
                setInterval(() => {
                    this.autoSave();
                }, 60000); // Auto-save every 60 seconds
            },
            
            setupKeyboardShortcuts() {
                document.addEventListener('keydown', (e) => {
                    if (e.ctrlKey && e.key === 's') {
                        e.preventDefault();
                        this.autoSave();
                    }
                    if (e.ctrlKey && e.key === 'Enter') {
                        e.preventDefault();
                        this.runCode();
                    }
                });
            },
            
            getStarterHTML() {
                return `<!-- Start coding here -->
<div class="container">
    <h1>Hello, World!</h1>
    <p>Your code goes here...</p>
</div>`;
            },
            
            getStarterCSS() {
                return `/* Add your styles here */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 20px;
    background-color: #f0f0f0;
}

.container {
    max-width: 800px;
    margin: 0 auto;
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}`;
            },
            
            getStarterJS() {
                return `// Add your JavaScript here
console.log('Code editor ready!');

document.addEventListener('DOMContentLoaded', function() {
    // Your code here
});`;
            },
            
            showNotification(message, type) {
                // Simple alert for now
                alert(message);
            }
        };
    }
    
    // Listen for console messages from iframe
    window.addEventListener('message', (event) => {
        if (event.data.type && event.data.message) {
            const editor = Alpine.$data(document.querySelector('[x-data]'));
            if (editor) {
                editor.addConsoleMessage(event.data.message, event.data.type);
            }
        }
    });
    </script>
</body>
</html>
