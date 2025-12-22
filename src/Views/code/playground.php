<?php
$title = 'Code Playground';
?>

<div class="h-[calc(100vh-8rem)]" x-data="codePlayground()" @keydown.window="handleKeydown($event)">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-4">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <!-- Left Section -->
            <div class="flex items-center gap-4 flex-wrap">
                <h1 class="text-2xl font-bold text-gray-900">
                    <i class="fas fa-code text-primary mr-2"></i>Code Playground
                </h1>
                
                <!-- Language Selector -->
                <select x-model="language" @change="changeLanguage()" 
                        class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary focus:border-primary">
                    <?php foreach ($languages as $key => $lang): ?>
                        <option value="<?= $key ?>"><?= htmlspecialchars($lang['name']) ?></option>
                    <?php endforeach; ?>
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
                
                <!-- Clear Button -->
                <button @click="clearCode()" 
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium"
                        title="Clear Code">
                    <i class="fas fa-trash"></i>
                </button>
                
                <!-- Save Button -->
                <button @click="saveCode()" 
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
        <div class="mt-3 flex items-center gap-4 text-xs text-gray-500 flex-wrap">
            <span><kbd class="px-1.5 py-0.5 bg-gray-100 rounded text-gray-700">Ctrl+Enter</kbd> Run</span>
            <span><kbd class="px-1.5 py-0.5 bg-gray-100 rounded text-gray-700">Ctrl+S</kbd> Save</span>
            <span><kbd class="px-1.5 py-0.5 bg-gray-100 rounded text-gray-700">F11</kbd> Fullscreen</span>
            <span class="ml-auto text-green-600" x-show="autoSaved" x-transition>
                <i class="fas fa-check mr-1"></i>Auto-saved
            </span>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 h-[calc(100%-8rem)]">
        <!-- Left Panel: Code Editor + Input -->
        <div class="flex flex-col gap-4 h-full">
            <!-- Code Editor -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden flex flex-col flex-1"
                 :class="darkTheme ? 'bg-gray-900 border-gray-700' : ''">
                <div class="px-4 py-3 border-b flex items-center justify-between"
                     :class="darkTheme ? 'bg-gray-800 border-gray-700' : 'bg-gray-50 border-gray-200'">
                    <span class="font-medium" :class="darkTheme ? 'text-gray-200' : 'text-gray-700'">
                        <i class="fas fa-code mr-2"></i>Code Editor
                    </span>
                    <div class="flex items-center gap-2">
                        <span class="text-sm px-2 py-1 rounded" 
                              :class="darkTheme ? 'bg-gray-700 text-gray-300' : 'bg-gray-200 text-gray-600'"
                              x-text="getLanguageDisplay()"></span>
                        <span class="text-xs" :class="darkTheme ? 'text-gray-400' : 'text-gray-500'" x-text="lineCount + ' lines'"></span>
                    </div>
                </div>
                <div class="flex-1 overflow-hidden relative">
                    <textarea id="playgroundEditor" 
                              x-ref="codeEditor"
                              @input="onCodeChange()"
                              class="w-full h-full font-mono resize-none p-4 focus:outline-none"
                              :class="darkTheme ? 'bg-gray-900 text-gray-100' : 'bg-white text-gray-800'"
                              :style="'font-size: ' + fontSize + 'px; line-height: 1.6;'"
                              placeholder="Write your code here..."
                              spellcheck="false"></textarea>
                </div>
            </div>
            
            <!-- Input (stdin) Section -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden"
                 :class="darkTheme ? 'bg-gray-900 border-gray-700' : ''">
                <div class="px-4 py-2 border-b flex items-center justify-between cursor-pointer"
                     :class="darkTheme ? 'bg-gray-800 border-gray-700' : 'bg-gray-50 border-gray-200'"
                     @click="showInput = !showInput">
                    <span class="font-medium text-sm" :class="darkTheme ? 'text-gray-200' : 'text-gray-700'">
                        <i class="fas fa-keyboard mr-2"></i>Input (stdin)
                    </span>
                    <i class="fas transition-transform" 
                       :class="[showInput ? 'fa-chevron-up' : 'fa-chevron-down', darkTheme ? 'text-gray-400' : 'text-gray-500']"></i>
                </div>
                <div x-show="showInput" x-collapse class="p-0">
                    <textarea x-model="stdin" 
                              class="w-full h-24 font-mono text-sm resize-none p-3 focus:outline-none"
                              :class="darkTheme ? 'bg-gray-900 text-gray-100' : 'bg-white text-gray-800'"
                              placeholder="Enter input for your program (one value per line)..."
                              spellcheck="false"></textarea>
                </div>
            </div>
        </div>
        
        <!-- Right Panel: Output + Stats -->
        <div class="flex flex-col gap-4 h-full">
            <!-- Output Section -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden flex flex-col flex-1"
                 :class="darkTheme ? 'bg-gray-900 border-gray-700' : ''">
                <div class="px-4 py-3 border-b flex items-center justify-between"
                     :class="darkTheme ? 'bg-gray-800 border-gray-700' : 'bg-gray-50 border-gray-200'">
                    <span class="font-medium" :class="darkTheme ? 'text-gray-200' : 'text-gray-700'">
                        <i class="fas fa-terminal mr-2"></i>Output
                    </span>
                    <div class="flex items-center gap-2">
                        <button @click="copyOutput()" 
                                x-show="output || error"
                                class="text-sm px-2 py-1 rounded hover:bg-gray-200 transition"
                                :class="darkTheme ? 'text-gray-300 hover:bg-gray-700' : 'text-gray-600'"
                                title="Copy Output">
                            <i class="fas" :class="copied ? 'fa-check text-green-500' : 'fa-copy'"></i>
                        </button>
                        <button @click="clearOutput()" 
                                class="text-sm px-2 py-1 rounded hover:bg-gray-200 transition"
                                :class="darkTheme ? 'text-gray-300 hover:bg-gray-700' : 'text-gray-600'">
                            <i class="fas fa-times mr-1"></i>Clear
                        </button>
                    </div>
                </div>
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
            </div>
            
            <!-- Execution Stats -->
            <div x-show="executionStats.time !== null" 
                 x-transition
                 class="bg-white rounded-lg shadow-sm border border-gray-200 p-4"
                 :class="darkTheme ? 'bg-gray-900 border-gray-700' : ''">
                <div class="flex items-center justify-between">
                    <h3 class="font-medium text-sm" :class="darkTheme ? 'text-gray-200' : 'text-gray-700'">
                        <i class="fas fa-chart-bar mr-2"></i>Execution Stats
                    </h3>
                    <span class="text-xs px-2 py-1 rounded-full"
                          :class="executionStats.status === 'Accepted' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'"
                          x-text="executionStats.status"></span>
                </div>
                <div class="grid grid-cols-3 gap-4 mt-3">
                    <div class="text-center">
                        <p class="text-2xl font-bold" :class="darkTheme ? 'text-blue-400' : 'text-blue-600'" x-text="formatTime(executionStats.time)"></p>
                        <p class="text-xs" :class="darkTheme ? 'text-gray-400' : 'text-gray-500'">Time</p>
                    </div>
                    <div class="text-center">
                        <p class="text-2xl font-bold" :class="darkTheme ? 'text-purple-400' : 'text-purple-600'" x-text="formatMemory(executionStats.memory)"></p>
                        <p class="text-xs" :class="darkTheme ? 'text-gray-400' : 'text-gray-500'">Memory</p>
                    </div>
                    <div class="text-center">
                        <p class="text-2xl font-bold" :class="darkTheme ? 'text-green-400' : 'text-green-600'" x-text="executionStats.runs"></p>
                        <p class="text-xs" :class="darkTheme ? 'text-gray-400' : 'text-gray-500'">Runs</p>
                    </div>
                </div>
                <div x-show="executionStats.simulated" class="mt-2 text-xs text-center text-yellow-600">
                    <i class="fas fa-info-circle mr-1"></i>Simulated execution (Configure Judge0 API for real execution)
                </div>
            </div>
            
            <!-- Code Templates -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200"
                 :class="darkTheme ? 'bg-gray-900 border-gray-700' : ''">
                <div class="px-4 py-2 border-b cursor-pointer flex items-center justify-between"
                     :class="darkTheme ? 'bg-gray-800 border-gray-700' : 'bg-gray-50 border-gray-200'"
                     @click="showTemplates = !showTemplates">
                    <span class="font-medium text-sm" :class="darkTheme ? 'text-gray-200' : 'text-gray-700'">
                        <i class="fas fa-file-code mr-2"></i>Code Templates
                    </span>
                    <i class="fas transition-transform" 
                       :class="[showTemplates ? 'fa-chevron-up' : 'fa-chevron-down', darkTheme ? 'text-gray-400' : 'text-gray-500']"></i>
                </div>
                <div x-show="showTemplates" x-collapse class="p-3">
                    <div class="grid grid-cols-2 gap-2">
                        <template x-for="template in getTemplatesForLanguage()" :key="template.name">
                            <button @click="loadTemplate(template.code)"
                                    class="text-left p-2 rounded border text-sm hover:border-primary hover:bg-primary/5 transition"
                                    :class="darkTheme ? 'border-gray-700 text-gray-300' : 'border-gray-200 text-gray-700'">
                                <i class="fas fa-file-alt mr-2 text-primary"></i>
                                <span x-text="template.name"></span>
                            </button>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function codePlayground() {
    return {
        // State
        language: 'javascript',
        stdin: '',
        output: '',
        error: '',
        running: false,
        darkTheme: localStorage.getItem('playground_theme') === 'dark',
        fontSize: parseInt(localStorage.getItem('playground_fontsize')) || 14,
        showInput: false,
        showTemplates: false,
        isFullscreen: false,
        autoSaved: false,
        copied: false,
        lineCount: 1,
        saveTimeout: null,
        
        // Execution stats
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
                { name: 'Array Operations', code: '// Array operations\nconst numbers = [1, 2, 3, 4, 5];\nconst doubled = numbers.map(n => n * 2);\nconsole.log("Original:", numbers);\nconsole.log("Doubled:", doubled);' },
                { name: 'Async/Await', code: '// Async/Await example\nasync function fetchData() {\n    return new Promise(resolve => {\n        setTimeout(() => resolve("Data loaded!"), 1000);\n    });\n}\n\nfetchData().then(data => console.log(data));' }
            ],
            python: [
                { name: 'Hello World', code: '# Python Hello World\nprint("Hello, World!")' },
                { name: 'List Comprehension', code: '# List comprehension\nnumbers = [1, 2, 3, 4, 5]\nsquared = [x**2 for x in numbers]\nprint("Original:", numbers)\nprint("Squared:", squared)' },
                { name: 'Class Example', code: '# Python Class\nclass Person:\n    def __init__(self, name, age):\n        self.name = name\n        self.age = age\n    \n    def greet(self):\n        print(f"Hello, I am {self.name}")\n\nperson = Person("John", 30)\nperson.greet()' }
            ],
            java: [
                { name: 'Hello World', code: 'public class Main {\n    public static void main(String[] args) {\n        System.out.println("Hello, World!");\n    }\n}' },
                { name: 'Array Example', code: 'import java.util.Arrays;\n\npublic class Main {\n    public static void main(String[] args) {\n        int[] numbers = {1, 2, 3, 4, 5};\n        System.out.println("Array: " + Arrays.toString(numbers));\n    }\n}' }
            ],
            cpp: [
                { name: 'Hello World', code: '#include <iostream>\nusing namespace std;\n\nint main() {\n    cout << "Hello, World!" << endl;\n    return 0;\n}' },
                { name: 'Vector Example', code: '#include <iostream>\n#include <vector>\nusing namespace std;\n\nint main() {\n    vector<int> numbers = {1, 2, 3, 4, 5};\n    for(int n : numbers) {\n        cout << n << " ";\n    }\n    cout << endl;\n    return 0;\n}' }
            ],
            c: [
                { name: 'Hello World', code: '#include <stdio.h>\n\nint main() {\n    printf("Hello, World!\\n");\n    return 0;\n}' },
                { name: 'Array Example', code: '#include <stdio.h>\n\nint main() {\n    int numbers[] = {1, 2, 3, 4, 5};\n    int size = sizeof(numbers) / sizeof(numbers[0]);\n    for(int i = 0; i < size; i++) {\n        printf("%d ", numbers[i]);\n    }\n    printf("\\n");\n    return 0;\n}' }
            ],
            php: [
                { name: 'Hello World', code: '<' + '?php\necho "Hello, World!\\n";\n?' + '>' },
                { name: 'Array Example', code: '<' + '?php\n$numbers = [1, 2, 3, 4, 5];\n$squared = array_map(fn($n) => $n ** 2, $numbers);\nprint_r($squared);\n?' + '>' }
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
                { name: 'Hello World', code: '// TypeScript Hello World\nconst greeting: string = "Hello, World!";\nconsole.log(greeting);' }
            ],
            csharp: [
                { name: 'Hello World', code: 'using System;\n\nclass Program {\n    static void Main() {\n        Console.WriteLine("Hello, World!");\n    }\n}' }
            ],
            swift: [
                { name: 'Hello World', code: '// Swift Hello World\nprint("Hello, World!")' }
            ],
            kotlin: [
                { name: 'Hello World', code: 'fun main() {\n    println("Hello, World!")\n}' }
            ],
            bash: [
                { name: 'Hello World', code: '#!/bin/bash\necho "Hello, World!"' }
            ],
            sql: [
                { name: 'Select Example', code: '-- SQL Select Example\nSELECT "Hello, World!" as greeting;' }
            ]
        },

        init() {
            // Load saved code from localStorage
            const savedCode = localStorage.getItem('playground_code_' + this.language);
            if (savedCode) {
                this.$refs.codeEditor.value = savedCode;
            } else {
                this.changeLanguage();
            }
            this.updateLineCount();
        },
        
        handleKeydown(event) {
            // Ctrl+Enter - Run Code
            if (event.ctrlKey && event.key === 'Enter') {
                event.preventDefault();
                this.runCode();
            }
            // Ctrl+S - Save Code
            else if (event.ctrlKey && event.key === 's') {
                event.preventDefault();
                this.saveCode();
            }
            // F11 - Fullscreen
            else if (event.key === 'F11') {
                event.preventDefault();
                this.toggleFullscreen();
            }
        },
        
        getCode() {
            return this.$refs.codeEditor?.value || '';
        },
        
        setCode(code) {
            if (this.$refs.codeEditor) {
                this.$refs.codeEditor.value = code;
                this.updateLineCount();
                this.autoSaveCode();
            }
        },
        
        onCodeChange() {
            this.updateLineCount();
            this.autoSaveCode();
        },
        
        updateLineCount() {
            const code = this.getCode();
            this.lineCount = code.split('\n').length;
        },
        
        autoSaveCode() {
            clearTimeout(this.saveTimeout);
            this.saveTimeout = setTimeout(() => {
                localStorage.setItem('playground_code_' + this.language, this.getCode());
                this.autoSaved = true;
                setTimeout(() => this.autoSaved = false, 2000);
            }, 1000);
        },
        
        changeLanguage() {
            const defaultTemplates = {
                javascript: '// Write your JavaScript code here\nconsole.log("Hello, World!");',
                python: '# Write your Python code here\nprint("Hello, World!")',
                java: 'public class Main {\n    public static void main(String[] args) {\n        System.out.println("Hello, World!");\n    }\n}',
                cpp: '#include <iostream>\nusing namespace std;\n\nint main() {\n    cout << "Hello, World!" << endl;\n    return 0;\n}',
                c: '#include <stdio.h>\n\nint main() {\n    printf("Hello, World!\\n");\n    return 0;\n}',
                php: '<' + '?php\necho "Hello, World!";\n?' + '>',
                ruby: '# Write your Ruby code here\nputs "Hello, World!"',
                go: 'package main\n\nimport "fmt"\n\nfunc main() {\n    fmt.Println("Hello, World!")\n}',
                rust: 'fn main() {\n    println!("Hello, World!");\n}',
                typescript: '// Write your TypeScript code here\nconst greeting: string = "Hello, World!";\nconsole.log(greeting);',
                csharp: 'using System;\n\nclass Program {\n    static void Main() {\n        Console.WriteLine("Hello, World!");\n    }\n}',
                swift: '// Write your Swift code here\nprint("Hello, World!")',
                kotlin: 'fun main() {\n    println("Hello, World!")\n}',
                bash: '#!/bin/bash\necho "Hello, World!"',
                sql: '-- Write your SQL query here\nSELECT "Hello, World!" as greeting;'
            };
            
            // Check for saved code first
            const savedCode = localStorage.getItem('playground_code_' + this.language);
            if (savedCode) {
                this.setCode(savedCode);
            } else {
                this.setCode(defaultTemplates[this.language] || '// Write your code here');
            }
            
            this.clearOutput();
        },
        
        getLanguageDisplay() {
            const names = {
                javascript: 'JavaScript', python: 'Python 3', java: 'Java', cpp: 'C++', c: 'C',
                php: 'PHP', ruby: 'Ruby', go: 'Go', rust: 'Rust', typescript: 'TypeScript',
                csharp: 'C#', swift: 'Swift', kotlin: 'Kotlin', bash: 'Bash', sql: 'SQL'
            };
            return names[this.language] || this.language.toUpperCase();
        },
        
        getTemplatesForLanguage() {
            return this.templates[this.language] || [];
        },
        
        loadTemplate(code) {
            this.setCode(code);
            this.showTemplates = false;
        },
        
        async runCode() {
            this.running = true;
            this.output = '';
            this.error = '';

            const code = this.getCode();
            
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
                        language: this.language,
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
                    
                    // Update stats
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
        
        clearCode() {
            if (confirm('Are you sure you want to clear the code?')) {
                localStorage.removeItem('playground_code_' + this.language);
                this.changeLanguage();
            }
        },
        
        clearOutput() {
            this.output = '';
            this.error = '';
        },
        
        saveCode() {
            const code = this.getCode();
            const extensions = {
                javascript: 'js', python: 'py', java: 'java', cpp: 'cpp', c: 'c',
                php: 'php', ruby: 'rb', go: 'go', rust: 'rs', typescript: 'ts',
                csharp: 'cs', swift: 'swift', kotlin: 'kt', bash: 'sh', sql: 'sql'
            };
            const ext = extensions[this.language] || 'txt';
            
            const blob = new Blob([code], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `code.${ext}`;
            a.click();
            URL.revokeObjectURL(url);
            if (typeof showSuccess === 'function') showSuccess('Code downloaded!');
        },
        
        copyOutput() {
            const text = this.output || this.error;
            navigator.clipboard.writeText(text).then(() => {
                this.copied = true;
                setTimeout(() => this.copied = false, 2000);
            });
        },
        
        toggleTheme() {
            this.darkTheme = !this.darkTheme;
            localStorage.setItem('playground_theme', this.darkTheme ? 'dark' : 'light');
        },
        
        increaseFontSize() {
            if (this.fontSize < 24) {
                this.fontSize += 2;
                localStorage.setItem('playground_fontsize', this.fontSize);
            }
        },
        
        decreaseFontSize() {
            if (this.fontSize > 10) {
                this.fontSize -= 2;
                localStorage.setItem('playground_fontsize', this.fontSize);
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
        }
    };
}
</script>

<style>
kbd {
    font-family: ui-monospace, monospace;
}
</style>
