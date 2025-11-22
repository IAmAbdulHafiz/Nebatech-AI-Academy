<!DOCTYPE html>
<html lang="en" x-data="codeEditor()">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code Editor - <?= htmlspecialchars($lesson['title'] ?? 'Coding Exercise') ?></title>
    <link href="<?= asset('css/main.css') ?>" rel="stylesheet">
    <!-- Alpine.js Collapse Plugin (must load before Alpine core) -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <!-- Alpine.js Core -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Monaco Editor -->
    <link rel="stylesheet" data-name="vs/editor/editor.main" href="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.44.0/min/vs/editor/editor.main.css">
    
    <style>
        .editor-container {
            height: calc(100vh - 200px);
            min-height: 400px;
        }
        .code-panel, .preview-panel {
            height: 100%;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
        }
        .editor-wrapper {
            height: calc(100% - 50px);
        }
        #htmlEditor, #cssEditor, #jsEditor {
            height: 100%;
            width: 100%;
        }
        .preview-frame {
            width: 100%;
            height: 100%;
            border: none;
            background: white;
        }
        .tab-button {
            padding: 10px 20px;
            cursor: pointer;
            border: none;
            background: #f3f4f6;
            transition: all 0.2s;
        }
        .tab-button.active {
            background: white;
            border-bottom: 2px solid #10b981;
            color: #10b981;
            font-weight: 600;
        }
        .tab-button:hover {
            background: #e5e7eb;
        }
        .console-output {
            height: 150px;
            overflow-y: auto;
            background: #1e1e1e;
            color: #d4d4d4;
            padding: 10px;
            font-family: 'Consolas', 'Monaco', monospace;
            font-size: 13px;
        }
        .console-line {
            margin: 2px 0;
            padding: 2px 5px;
        }
        .console-log { color: #d4d4d4; }
        .console-error { color: #f87171; }
        .console-warn { color: #fbbf24; }
        .console-info { color: #60a5fa; }
    </style>
</head>
<body class="bg-gray-50">
    <?php include __DIR__ . '/../partials/header.php'; ?>

    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <div class="mb-6">
            <a href="<?= url('/dashboard') ?>" class="text-primary hover:text-primary font-semibold mb-4 inline-block">
                <i class="fas fa-arrow-left mr-2"></i>Back to Lesson
            </a>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900"><?= htmlspecialchars($lesson['title'] ?? 'Code Editor') ?></h1>
                    <p class="text-gray-600 mt-2">Interactive coding environment with live preview</p>
                </div>
                <div class="flex gap-3">
                    <button @click="resetCode()" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">
                        <i class="fas fa-undo mr-2"></i>Reset
                    </button>
                    <button @click="runCode()" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                        <i class="fas fa-play mr-2"></i>Run Code
                    </button>
                    <button @click="downloadCode()" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/70 transition">
                        <i class="fas fa-download mr-2"></i>Download
                    </button>
                </div>
            </div>
        </div>

        <!-- Layout Toggle -->
        <div class="mb-4 flex gap-2">
            <button @click="layout = 'horizontal'" 
                    :class="layout === 'horizontal' ? 'bg-green-600 text-white' : 'bg-white text-gray-700'"
                    class="px-4 py-2 rounded-lg border border-gray-300 hover:bg-green-50 transition">
                <i class="fas fa-columns mr-2"></i>Horizontal Split
            </button>
            <button @click="layout = 'vertical'" 
                    :class="layout === 'vertical' ? 'bg-green-600 text-white' : 'bg-white text-gray-700'"
                    class="px-4 py-2 rounded-lg border border-gray-300 hover:bg-green-50 transition">
                <i class="fas fa-grip-lines mr-2"></i>Vertical Split
            </button>
            <button @click="layout = 'tabs'" 
                    :class="layout === 'tabs' ? 'bg-green-600 text-white' : 'bg-white text-gray-700'"
                    class="px-4 py-2 rounded-lg border border-gray-300 hover:bg-green-50 transition">
                <i class="fas fa-layer-group mr-2"></i>Tabbed View
            </button>
        </div>

        <!-- Code Editor and Preview -->
        <div class="editor-container" 
             :class="{
                 'grid grid-cols-2 gap-4': layout === 'horizontal',
                 'grid grid-rows-2 gap-4': layout === 'vertical',
                 'block': layout === 'tabs'
             }">
            
            <!-- Code Panel -->
            <div class="code-panel bg-white" x-show="layout !== 'tabs' || activeMainTab === 'code'">
                <!-- Tabs for HTML/CSS/JS -->
                <div class="flex border-b border-gray-200 bg-gray-50">
                    <button @click="activeTab = 'html'" 
                            :class="activeTab === 'html' ? 'active' : ''"
                            class="tab-button flex items-center gap-2">
                        <i class="fab fa-html5 text-orange-600"></i> HTML
                    </button>
                    <button @click="activeTab = 'css'" 
                            :class="activeTab === 'css' ? 'active' : ''"
                            class="tab-button flex items-center gap-2">
                        <i class="fab fa-css3-alt text-primary"></i> CSS
                    </button>
                    <button @click="activeTab = 'js'" 
                            :class="activeTab === 'js' ? 'active' : ''"
                            class="tab-button flex items-center gap-2">
                        <i class="fab fa-js text-yellow-500"></i> JavaScript
                    </button>
                    <div class="ml-auto flex items-center px-4 text-sm text-gray-600">
                        <i class="fas fa-lightbulb mr-2"></i>
                        Press <kbd class="px-2 py-1 bg-gray-200 rounded">Ctrl+S</kbd> to run
                    </div>
                </div>

                <!-- Editors -->
                <div class="editor-wrapper">
                    <div id="htmlEditor" x-show="activeTab === 'html'"></div>
                    <div id="cssEditor" x-show="activeTab === 'css'"></div>
                    <div id="jsEditor" x-show="activeTab === 'js'"></div>
                </div>
            </div>

            <!-- Preview Panel -->
            <div class="preview-panel bg-white" x-show="layout !== 'tabs' || activeMainTab === 'preview'">
                <div class="flex items-center justify-between border-b border-gray-200 bg-gray-50 p-3">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-eye text-green-600"></i>
                        <span class="font-semibold">Live Preview</span>
                    </div>
                    <div class="flex gap-2">
                        <button @click="clearConsole()" class="text-sm px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">
                            <i class="fas fa-broom mr-1"></i>Clear Console
                        </button>
                        <button @click="refreshPreview()" class="text-sm px-3 py-1 bg-primary text-white rounded hover:bg-primary/70">
                            <i class="fas fa-sync-alt mr-1"></i>Refresh
                        </button>
                    </div>
                </div>
                <iframe id="preview" class="preview-frame" sandbox="allow-scripts allow-modals"></iframe>
                
                <!-- Console -->
                <div class="border-t border-gray-200">
                    <div class="flex items-center justify-between bg-gray-800 text-white px-3 py-2">
                        <span class="text-sm font-semibold">
                            <i class="fas fa-terminal mr-2"></i>Console
                        </span>
                        <span class="text-xs text-gray-400" x-text="consoleMessages.length + ' message(s)'"></span>
                    </div>
                    <div id="console" class="console-output">
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

            <!-- Tabs View Controls -->
            <div x-show="layout === 'tabs'" class="flex gap-2 mb-4">
                <button @click="activeMainTab = 'code'" 
                        :class="activeMainTab === 'code' ? 'bg-green-600 text-white' : 'bg-white'"
                        class="flex-1 py-3 rounded-lg border border-gray-300 font-semibold">
                    <i class="fas fa-code mr-2"></i>Code Editor
                </button>
                <button @click="activeMainTab = 'preview'" 
                        :class="activeMainTab === 'preview' ? 'bg-green-600 text-white' : 'bg-white'"
                        class="flex-1 py-3 rounded-lg border border-gray-300 font-semibold">
                    <i class="fas fa-eye mr-2"></i>Preview
                </button>
            </div>
        </div>

        <!-- Instructions Panel -->
        <div class="mt-6 bg-blue-50 border-l-4 border-primary/90 p-4 rounded">
            <h3 class="font-bold text-blue-900 mb-2">
                <i class="fas fa-info-circle mr-2"></i>Instructions
            </h3>
            <div class="text-blue-800 text-sm">
                <p><?= htmlspecialchars($lesson['content'] ?? 'Complete the coding exercise in the editor above.') ?></p>
            </div>
        </div>
    </div>

    <!-- Monaco Editor Loader -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.44.0/min/vs/loader.min.js"></script>
    
    <script>
        function codeEditor() {
            return {
                layout: 'horizontal',
                activeTab: 'html',
                activeMainTab: 'code',
                htmlEditor: null,
                cssEditor: null,
                jsEditor: null,
                consoleMessages: [],
                
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
                        this.loadSavedCode();
                        this.setupAutoSave();
                    });
                },
                
                initializeEditors() {
                    // HTML Editor
                    this.htmlEditor = monaco.editor.create(document.getElementById('htmlEditor'), {
                        value: this.getStarterHTML(),
                        language: 'html',
                        theme: 'vs-light',
                        automaticLayout: true,
                        minimap: { enabled: false },
                        fontSize: 14,
                        wordWrap: 'on',
                        tabSize: 2
                    });
                    
                    // CSS Editor
                    this.cssEditor = monaco.editor.create(document.getElementById('cssEditor'), {
                        value: this.getStarterCSS(),
                        language: 'css',
                        theme: 'vs-light',
                        automaticLayout: true,
                        minimap: { enabled: false },
                        fontSize: 14,
                        wordWrap: 'on',
                        tabSize: 2
                    });
                    
                    // JavaScript Editor
                    this.jsEditor = monaco.editor.create(document.getElementById('jsEditor'), {
                        value: this.getStarterJS(),
                        language: 'javascript',
                        theme: 'vs-light',
                        automaticLayout: true,
                        minimap: { enabled: false },
                        fontSize: 14,
                        wordWrap: 'on',
                        tabSize: 2
                    });
                    
                    // Setup keyboard shortcuts
                    [this.htmlEditor, this.cssEditor, this.jsEditor].forEach(editor => {
                        editor.addCommand(monaco.KeyMod.CtrlCmd | monaco.KeyCode.KeyS, () => {
                            this.runCode();
                        });
                    });
                    
                    // Auto-run on changes (debounced)
                    let timeout;
                    [this.htmlEditor, this.cssEditor, this.jsEditor].forEach(editor => {
                        editor.onDidChangeModelContent(() => {
                            clearTimeout(timeout);
                            timeout = setTimeout(() => this.runCode(), 1000);
                        });
                    });
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
</body>
</html>`;
                },
                
                getStarterCSS() {
                    return `/* Add your styles here */
body {
    font-family: Arial, sans-serif;
    margin: 20px;
    padding: 0;
}

h1 {
    color: #2563eb;
}`;
                },
                
                getStarterJS() {
                    return `// Add your JavaScript here
console.log('Hello from JavaScript!');

// Example: Add click event
document.addEventListener('DOMContentLoaded', () => {
    console.log('Page loaded!');
});`;
                },
                
                runCode() {
                    const html = this.htmlEditor.getValue();
                    const css = this.cssEditor.getValue();
                    const js = this.jsEditor.getValue();
                    
                    // Clear console
                    this.consoleMessages = [];
                    
                    // Build complete HTML document
                    const fullHTML = this.buildHTMLDocument(html, css, js);
                    
                    // Update preview iframe
                    const iframe = document.getElementById('preview');
                    iframe.srcdoc = fullHTML;
                    
                    // Save code
                    this.saveCode();
                    
                    this.addConsoleMessage('Code executed successfully', 'log');
                },
                
                buildHTMLDocument(html, css, js) {
                    // Inject console capture
                    const consoleCapture = `
                        <script>
                            (function() {
                                const originalLog = console.log;
                                const originalError = console.error;
                                const originalWarn = console.warn;
                                const originalInfo = console.info;
                                
                                console.log = function(...args) {
                                    window.parent.postMessage({
                                        type: 'console',
                                        level: 'log',
                                        message: args.map(a => String(a)).join(' ')
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
                                        message: e.message + ' at ' + e.filename + ':' + e.lineno
                                    }, '*');
                                });
                            })();
                        </script>
                    `;
                    
                    // Check if HTML contains <!DOCTYPE html>
                    if (html.toLowerCase().includes('<!doctype html>')) {
                        // Insert console capture and CSS before </head>
                        let modifiedHTML = html.replace('</head>', 
                            `<style>${css}</style>${consoleCapture}</head>`);
                        // Insert JS before </body>
                        modifiedHTML = modifiedHTML.replace('</body>', 
                            `<script>${js}</script></body>`);
                        return modifiedHTML;
                    } else {
                        // Wrap in full HTML document
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
    <script>${js}</script>
</body>
</html>`;
                    }
                },
                
                refreshPreview() {
                    this.runCode();
                    this.addConsoleMessage('Preview refreshed', 'info');
                },
                
                resetCode() {
                    if (confirm('Are you sure you want to reset all code? This cannot be undone.')) {
                        this.htmlEditor.setValue(this.getStarterHTML());
                        this.cssEditor.setValue(this.getStarterCSS());
                        this.jsEditor.setValue(this.getStarterJS());
                        this.consoleMessages = [];
                        this.runCode();
                    }
                },
                
                downloadCode() {
                    const html = this.htmlEditor.getValue();
                    const css = this.cssEditor.getValue();
                    const js = this.jsEditor.getValue();
                    
                    const fullHTML = this.buildHTMLDocument(html, css, js);
                    
                    const blob = new Blob([fullHTML], { type: 'text/html' });
                    const url = URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = 'my-project.html';
                    a.click();
                    URL.revokeObjectURL(url);
                    
                    this.addConsoleMessage('Code downloaded successfully', 'info');
                },
                
                saveCode() {
                    const code = {
                        html: this.htmlEditor.getValue(),
                        css: this.cssEditor.getValue(),
                        js: this.jsEditor.getValue()
                    };
                    localStorage.setItem('nebatech_code_editor', JSON.stringify(code));
                },
                
                loadSavedCode() {
                    const saved = localStorage.getItem('nebatech_code_editor');
                    if (saved) {
                        try {
                            const code = JSON.parse(saved);
                            this.htmlEditor.setValue(code.html || this.getStarterHTML());
                            this.cssEditor.setValue(code.css || this.getStarterCSS());
                            this.jsEditor.setValue(code.js || this.getStarterJS());
                            this.runCode();
                        } catch (e) {
                            console.error('Failed to load saved code:', e);
                        }
                    }
                },
                
                setupAutoSave() {
                    setInterval(() => {
                        this.saveCode();
                    }, 30000); // Auto-save every 30 seconds
                },
                
                addConsoleMessage(message, type = 'log') {
                    const time = new Date().toLocaleTimeString();
                    this.consoleMessages.push({ message, type, time });
                    // Scroll to bottom
                    this.$nextTick(() => {
                        const console = document.getElementById('console');
                        console.scrollTop = console.scrollHeight;
                    });
                },
                
                clearConsole() {
                    this.consoleMessages = [];
                }
            };
        }
        
        // Listen for console messages from iframe
        window.addEventListener('message', (event) => {
            if (event.data.type === 'console') {
                const editorData = Alpine.store('editorInstance');
                if (editorData) {
                    editorData.addConsoleMessage(event.data.message, event.data.level);
                }
            }
        });
    </script>

    <?php include __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>


