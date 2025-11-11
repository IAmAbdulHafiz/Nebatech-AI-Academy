/**
 * Simple CodeMirror 6 Editor Manager (CDN Version)
 * This version uses CDN imports for easier integration
 */

class SimpleCodeEditor {
    constructor() {
        this.editors = new Map();
        this.defaultSettings = {
            theme: 'github-light',
            fontSize: 14,
            lineNumbers: true,
            lineWrapping: false,
            tabSize: 4,
            readOnly: false
        };
        this.settings = { ...this.defaultSettings };
        this.loadSettings();
        this.cdnLoaded = false;
    }

    /**
     * Load user settings from localStorage
     */
    loadSettings() {
        try {
            const saved = localStorage.getItem('editorSettings');
            if (saved) {
                this.settings = { ...this.defaultSettings, ...JSON.parse(saved) };
            }
        } catch (e) {
            console.warn('Failed to load editor settings:', e);
        }
    }

    /**
     * Save settings to localStorage and server
     */
    async saveSettings(settings) {
        this.settings = { ...this.settings, ...settings };
        try {
            localStorage.setItem('editorSettings', JSON.stringify(this.settings));
            
            // Also save to server
            const response = await fetch('/settings/update-editor', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ editor_settings: this.settings })
            });
            
            if (!response.ok) {
                console.warn('Failed to save settings to server');
            }
        } catch (e) {
            console.warn('Failed to save editor settings:', e);
        }
    }

    /**
     * Load CodeMirror from CDN
     */
    async loadCDN() {
        if (this.cdnLoaded) return true;

        return new Promise((resolve, reject) => {
            // Load CodeMirror CSS
            const cssLink = document.createElement('link');
            cssLink.rel = 'stylesheet';
            cssLink.href = 'https://cdn.jsdelivr.net/npm/codemirror@5.65.2/lib/codemirror.css';
            document.head.appendChild(cssLink);

            // Load theme CSS
            const themeLink = document.createElement('link');
            themeLink.rel = 'stylesheet';
            themeLink.href = 'https://cdn.jsdelivr.net/npm/codemirror@5.65.2/theme/monokai.css';
            document.head.appendChild(themeLink);

            // Add custom CSS fixes for proper layout
            const customStyle = document.createElement('style');
            customStyle.textContent = `
                .CodeMirror {
                    height: auto;
                    min-height: 300px;
                    border: 1px solid #d1d5db;
                    border-radius: 0.5rem;
                    font-family: 'Consolas', 'Monaco', 'Courier New', monospace;
                    padding: 0 !important;
                    box-sizing: border-box;
                }
                .CodeMirror-scroll {
                    min-height: 300px;
                    padding: 0;
                }
                .CodeMirror-gutters {
                    border-right: 1px solid #ddd;
                    background-color: #f7f7f7;
                    white-space: nowrap;
                    padding: 0;
                    left: 0;
                    min-width: 35px;
                }
                .CodeMirror-linenumber {
                    padding: 0 8px 0 5px;
                    min-width: 20px;
                    text-align: right;
                    color: #999;
                    white-space: nowrap;
                    box-sizing: border-box;
                }
                .CodeMirror-lines {
                    padding: 4px 0;
                }
                .CodeMirror pre {
                    padding: 0 4px;
                    padding-left: 8px;
                    box-sizing: border-box;
                }
                .CodeMirror-line {
                    padding-left: 8px;
                    box-sizing: border-box;
                }
                .CodeMirror-code {
                    padding-left: 0;
                }
            `;
            document.head.appendChild(customStyle);

            // Load CodeMirror JS
            const script = document.createElement('script');
            script.src = 'https://cdn.jsdelivr.net/npm/codemirror@5.65.2/lib/codemirror.js';
            script.onload = () => {
                // Load language modes (order matters - dependencies first)
                const modes = [
                    'javascript',
                    'python',
                    'xml',        // Required by htmlmixed
                    'css',        // Required by htmlmixed
                    'htmlmixed',  // Required by php
                    'php',
                    'sql',
                    'clike'
                ];

                // Load modes sequentially to respect dependencies
                let currentIndex = 0;
                const loadNextMode = () => {
                    if (currentIndex >= modes.length) {
                        this.cdnLoaded = true;
                        resolve(true);
                        return;
                    }
                    
                    const mode = modes[currentIndex];
                    const modeScript = document.createElement('script');
                    modeScript.src = `https://cdn.jsdelivr.net/npm/codemirror@5.65.2/mode/${mode}/${mode}.js`;
                    modeScript.onload = () => {
                        currentIndex++;
                        loadNextMode();
                    };
                    modeScript.onerror = () => {
                        console.warn(`Failed to load mode: ${mode}`);
                        currentIndex++;
                        loadNextMode();
                    };
                    document.head.appendChild(modeScript);
                };
                
                loadNextMode();
            };
            script.onerror = reject;
            document.head.appendChild(script);
        });
    }

    /**
     * Get CodeMirror mode based on language
     */
    getMode(language) {
        const modes = {
            javascript: 'javascript',
            js: 'javascript',
            python: 'python',
            py: 'python',
            html: 'htmlmixed',
            css: 'css',
            php: 'application/x-httpd-php',
            sql: 'sql',
            java: 'text/x-java',
            c: 'text/x-csrc',
            cpp: 'text/x-c++src',
            csharp: 'text/x-csharp',
            ruby: 'text/x-ruby',
            go: 'text/x-go',
            rust: 'text/x-rustsrc',
            typescript: 'text/typescript',
            swift: 'text/x-swift',
            kotlin: 'text/x-kotlin',
            r: 'text/x-rsrc',
            bash: 'text/x-sh',
            json: { name: 'javascript', json: true }
        };
        return modes[language?.toLowerCase()] || 'javascript';
    }

    /**
     * Change editor language/mode dynamically
     */
    async changeEditorLanguage(editor, language) {
        if (!editor || typeof CodeMirror === 'undefined') return;
        
        const mode = this.getMode(language);
        
        // Set the mode
        editor.setOption('mode', mode);
        
        // Force refresh to apply changes
        setTimeout(() => {
            editor.refresh();
        }, 50);
    }

    /**
     * Initialize a code editor on a textarea element
     */
    async initialize(textarea, options = {}) {
        if (!textarea) {
            console.error('Textarea element not found');
            return null;
        }

        // Ensure CodeMirror is loaded
        await this.loadCDN();

        if (typeof CodeMirror === 'undefined') {
            console.error('CodeMirror failed to load');
            return null;
        }

        // Merge options with saved settings
        const editorSettings = { ...this.settings, ...options };

        // Auto-detect language from textarea attributes
        let language = editorSettings.language || 'javascript';
        const dataLang = textarea.getAttribute('data-language');
        if (dataLang) {
            language = dataLang;
        }

        // Create editor
        const editor = CodeMirror.fromTextArea(textarea, {
            mode: this.getMode(language),
            theme: this.getThemeName(editorSettings.theme),
            lineNumbers: editorSettings.lineNumbers,
            lineWrapping: editorSettings.lineWrapping,
            tabSize: editorSettings.tabSize,
            indentUnit: editorSettings.tabSize,
            indentWithTabs: editorSettings.indentWithTabs || false,
            autoCloseBrackets: editorSettings.autoCloseBrackets !== false,
            matchBrackets: true,
            readOnly: editorSettings.readOnly || false,
            extraKeys: {
                'Ctrl-Space': 'autocomplete',
                'Ctrl-F': 'findPersistent',
                'F11': function(cm) {
                    cm.setOption('fullScreen', !cm.getOption('fullScreen'));
                },
                'Esc': function(cm) {
                    if (cm.getOption('fullScreen')) cm.setOption('fullScreen', false);
                }
            }
        });

        // Apply font size
        editor.getWrapperElement().style.fontSize = `${editorSettings.fontSize}px`;

        // Store editor instance
        const editorId = textarea.id || `editor-${this.editors.size}`;
        this.editors.set(editorId, {
            editor,
            textarea,
            settings: editorSettings
        });

        // Sync changes back to textarea
        editor.on('change', () => {
            textarea.value = editor.getValue();
            textarea.dispatchEvent(new Event('change', { bubbles: true }));
        });

        // Force refresh after a short delay to fix layout issues
        setTimeout(() => {
            editor.refresh();
        }, 100);

        return {
            id: editorId,
            editor,
            getValue: () => editor.getValue(),
            setValue: (value) => editor.setValue(value),
            updateSettings: (newSettings) => this.updateEditor(editorId, newSettings),
            destroy: () => this.destroyEditor(editorId),
            refresh: () => editor.refresh()
        };
    }

    /**
     * Get CodeMirror theme name
     */
    getThemeName(theme) {
        const themeMap = {
            'github-light': 'default',
            'github-dark': 'monokai',
            'one-dark': 'monokai',
            'dracula': 'dracula',
            'monokai': 'monokai',
            'nord': 'nord',
            'solarized-light': 'solarized light',
            'solarized-dark': 'solarized dark'
        };
        return themeMap[theme] || 'default';
    }

    /**
     * Update editor settings
     */
    updateEditor(editorId, newSettings) {
        const editorData = this.editors.get(editorId);
        if (!editorData) return;

        const { editor } = editorData;
        const updatedSettings = { ...editorData.settings, ...newSettings };

        // Update CodeMirror options
        if (newSettings.theme) {
            editor.setOption('theme', this.getThemeName(newSettings.theme));
        }
        if (newSettings.lineNumbers !== undefined) {
            editor.setOption('lineNumbers', newSettings.lineNumbers);
        }
        if (newSettings.lineWrapping !== undefined) {
            editor.setOption('lineWrapping', newSettings.lineWrapping);
        }
        if (newSettings.tabSize !== undefined) {
            editor.setOption('tabSize', newSettings.tabSize);
            editor.setOption('indentUnit', newSettings.tabSize);
        }
        if (newSettings.fontSize) {
            editor.getWrapperElement().style.fontSize = `${newSettings.fontSize}px`;
        }
        if (newSettings.language) {
            editor.setOption('mode', this.getMode(newSettings.language));
        }

        editorData.settings = updatedSettings;
        editor.refresh();
    }

    /**
     * Destroy an editor instance
     */
    destroyEditor(editorId) {
        const editorData = this.editors.get(editorId);
        if (!editorData) return;

        editorData.editor.toTextArea();
        this.editors.delete(editorId);
    }

    /**
     * Initialize all textareas with data-code-editor attribute
     */
    async initializeAll() {
        const textareas = document.querySelectorAll('textarea[data-code-editor]');
        const editors = [];
        
        for (const textarea of textareas) {
            // Skip if already initialized (has CodeMirror sibling)
            if (textarea.nextElementSibling && textarea.nextElementSibling.classList.contains('CodeMirror')) {
                continue;
            }
            
            // Skip if textarea is hidden (display: none or visibility: hidden)
            const isVisible = textarea.offsetParent !== null;
            if (!isVisible) {
                // Set up observer to initialize when it becomes visible
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting && !textarea.nextElementSibling?.classList.contains('CodeMirror')) {
                            this.initialize(textarea, {
                                language: textarea.getAttribute('data-language') || 'javascript',
                                readOnly: textarea.hasAttribute('readonly')
                            });
                            observer.disconnect();
                        }
                    });
                }, { threshold: 0.1 });
                observer.observe(textarea);
                continue;
            }
            
            const options = {
                language: textarea.getAttribute('data-language') || 'javascript',
                readOnly: textarea.hasAttribute('readonly')
            };
            
            const editor = await this.initialize(textarea, options);
            if (editor) {
                editors.push(editor);
            }
        }

        return editors;
    }

    /**
     * Get all available themes
     */
    getAvailableThemes() {
        return [
            { value: 'github-light', label: 'GitHub Light', category: 'light' },
            { value: 'monokai', label: 'Monokai', category: 'dark' },
            { value: 'dracula', label: 'Dracula', category: 'dark' },
            { value: 'nord', label: 'Nord', category: 'dark' },
            { value: 'solarized-light', label: 'Solarized Light', category: 'light' },
            { value: 'solarized-dark', label: 'Solarized Dark', category: 'dark' }
        ];
    }

    /**
     * Get all available languages
     */
    getAvailableLanguages() {
        return [
            { value: 'javascript', label: 'JavaScript' },
            { value: 'python', label: 'Python' },
            { value: 'html', label: 'HTML' },
            { value: 'css', label: 'CSS' },
            { value: 'php', label: 'PHP' },
            { value: 'sql', label: 'SQL' },
            { value: 'java', label: 'Java' },
            { value: 'c', label: 'C' },
            { value: 'cpp', label: 'C++' },
            { value: 'json', label: 'JSON' }
        ];
    }

    /**
     * Update all editors with new settings
     */
    updateAllEditors(settings) {
        this.editors.forEach((editorData, editorId) => {
            this.updateEditor(editorId, settings);
        });
    }
}

// Create global instance
window.codeEditorManager = new SimpleCodeEditor();

// Auto-initialize on DOM ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        window.codeEditorManager.initializeAll();
    });
} else {
    // If DOM is already loaded, initialize immediately
    setTimeout(() => window.codeEditorManager.initializeAll(), 100);
}
