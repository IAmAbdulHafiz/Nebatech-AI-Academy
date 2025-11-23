<?php
$title = 'Code Playground';
ob_start();
// Dynamically load sidebar based on user role
$sidebarFile = match($user['role']) {
    'admin' => 'admin-sidebar.php',
    'facilitator' => 'facilitator-sidebar.php',
    default => 'student-sidebar.php'
};
include __DIR__ . '/../partials/' . $sidebarFile;
$sidebarContent = ob_get_clean();
ob_start();
?>

<div class="h-[calc(100vh-8rem)]" x-data="codePlayground()">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-4">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div class="flex items-center gap-4">
                <h1 class="text-2xl font-bold text-gray-900">Code Playground</h1>
                <select x-model="language" @change="changeLanguage()" class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary">
                    <?php foreach ($languages as $key => $name): ?>
                        <option value="<?= $key ?>"><?= htmlspecialchars($name) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="flex items-center gap-2">
                <button @click="runCode()" :disabled="running" 
                        class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium disabled:opacity-50 disabled:cursor-not-allowed">
                    <i class="fas" :class="running ? 'fa-spinner fa-spin' : 'fa-play'" x-show="!running"></i>
                    <i class="fas fa-spinner fa-spin" x-show="running"></i>
                    <span x-text="running ? 'Running...' : 'Run Code'"></span>
                </button>
                <button @click="clearCode()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">
                    <i class="fas fa-trash mr-2"></i>Clear
                </button>
                <button @click="saveCode()" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-blue-700 transition font-medium">
                    <i class="fas fa-save mr-2"></i>Save
                </button>
            </div>
        </div>
    </div>

    <!-- Code Editor and Output -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 h-[calc(100%-5rem)]">
        <!-- Editor -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden flex flex-col">
            <div class="px-4 py-3 bg-gray-50 border-b border-gray-200 flex items-center justify-between">
                <span class="font-medium text-gray-700">
                    <i class="fas fa-code mr-2"></i>Code Editor
                </span>
                <span class="text-sm text-gray-500" x-text="language.toUpperCase()"></span>
            </div>
            <div class="flex-1 overflow-hidden">
                <textarea id="playgroundEditor" 
                          data-code-editor 
                          x-ref="codeEditor"
                          :data-language="language"
                          class="w-full h-full font-mono text-sm"
                          placeholder="Write your code here..."
                          spellcheck="false"></textarea>
            </div>
        </div>

        <!-- Output -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden flex flex-col">
            <div class="px-4 py-3 bg-gray-50 border-b border-gray-200 flex items-center justify-between">
                <span class="font-medium text-gray-700">
                    <i class="fas fa-terminal mr-2"></i>Output
                </span>
                <button @click="clearOutput()" class="text-sm text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times mr-1"></i>Clear
                </button>
            </div>
            <div class="flex-1 overflow-auto p-4">
                <div x-show="!output && !error" class="text-gray-400 text-sm">
                    Run your code to see the output here...
                </div>
                <div x-show="output" class="font-mono text-sm whitespace-pre-wrap" x-text="output"></div>
                <div x-show="error" class="text-red-600 font-mono text-sm whitespace-pre-wrap" x-text="error"></div>
            </div>
        </div>
    </div>
</div>

<script>
function codePlayground() {
    return {
        language: 'javascript',
        code: '// Write your code here\nconsole.log("Hello, World!");',
        output: '',
        error: '',
        running: false,
        editorInstance: null,
        editorId: null,

        init() {
            // Wait for code editor to initialize
            this.initEditor();
        },

        initEditor() {
            setTimeout(() => {
                if (window.codeEditorManager) {
                    const editors = window.codeEditorManager.editors;
                    
                    // Try to get editor by the playgroundEditor ID
                    let editorData = editors.get('playgroundEditor');
                    
                    // If not found, search through all editors
                    if (!editorData) {
                        editorData = Array.from(editors.values()).find(e => e.textarea && e.textarea.id === 'playgroundEditor');
                    }
                    
                    if (editorData) {
                        this.editorInstance = editorData.editor;
                        this.editorId = editorData.textarea.id;
                        // Set initial code
                        const currentCode = this.editorInstance.getValue();
                        if (!currentCode || currentCode.trim() === '') {
                            this.editorInstance.setValue(this.code);
                        }
                    } else {
                        // Retry after a longer delay
                        if (!this.retryCount || this.retryCount < 3) {
                            this.retryCount = (this.retryCount || 0) + 1;
                            setTimeout(() => this.initEditor(), 1000);
                        }
                    }
                }
            }, 500);
        },

        getCode() {
            if (this.editorInstance) {
                return this.editorInstance.getValue();
            }
            return this.$refs.codeEditor?.value || this.code;
        },

        setCode(newCode) {
            this.code = newCode;
            if (this.editorInstance) {
                this.editorInstance.setValue(newCode);
            } else if (this.$refs.codeEditor) {
                this.$refs.codeEditor.value = newCode;
            }
        },

        changeLanguage() {
            const templates = {
                javascript: '// Write your JavaScript code here\nconsole.log("Hello, World!");',
                python: '# Write your Python code here\nprint("Hello, World!")',
                java: 'public class Main {\n    public static void main(String[] args) {\n        System.out.println("Hello, World!");\n    }\n}',
                cpp: '#include <iostream>\nusing namespace std;\n\nint main() {\n    cout << "Hello, World!" << endl;\n    return 0;\n}',
                c: '#include <stdio.h>\n\nint main() {\n    printf("Hello, World!\\n");\n    return 0;\n}',
                php: '<?php\necho "Hello, World!";\n?>'
            };
            const newCode = templates[this.language] || '// Write your code here';
            
            // Update editor language mode and set new code
            if (this.editorInstance && window.codeEditorManager) {
                // Clear content first to avoid race conditions
                this.editorInstance.setValue('');
                // Update the language mode
                const mode = window.codeEditorManager.getMode(this.language);
                this.editorInstance.setOption('mode', mode);
                // Set the new template code after a small delay
                setTimeout(() => {
                    this.setCode(newCode);
                    this.editorInstance.refresh();
                }, 50);
            } else {
                this.setCode(newCode);
            }
            
            this.clearOutput();
        },

        async runCode() {
            this.running = true;
            this.output = '';
            this.error = '';

            // Get code from editor
            const codeToRun = this.getCode();

            try {
                const response = await fetch('<?= url('/code/execute') ?>', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    body: new URLSearchParams({
                        code: codeToRun,
                        language: this.language,
                        stdin: ''
                    })
                });

                const data = await response.json();

                if (data.success) {
                    const result = data.result;
                    if (result.status === 'Accepted' || result.stdout) {
                        this.output = result.stdout || 'Program executed successfully (no output)';
                    } else if (result.stderr) {
                        this.error = result.stderr;
                    } else if (result.compile_output) {
                        this.error = result.compile_output;
                    } else {
                        this.error = 'Status: ' + result.status;
                    }
                } else {
                    this.error = data.error || 'Execution failed';
                }
            } catch (error) {
                this.error = 'Error: ' + error.message;
            } finally {
                this.running = false;
            }
        },

        async clearCode() {
            const confirmed = await confirmAction('Are you sure you want to clear the code?', {
                title: 'Clear Code',
                confirmText: 'Clear',
                type: 'warning'
            });
            
            if (confirmed) {
                this.changeLanguage();
            }
        },

        clearOutput() {
            this.output = '';
            this.error = '';
        },

        saveCode() {
            const codeToSave = this.getCode();
            const blob = new Blob([codeToSave], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `code.${this.language}`;
            a.click();
            URL.revokeObjectURL(url);
            showSuccess('Code saved successfully!');
        }
    };
}
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/dashboard.php';
?>
