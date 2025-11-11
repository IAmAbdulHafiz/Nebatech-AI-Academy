/**
 * CodeMirror 6 Editor Manager
 * Handles initialization, theming, and settings for code editors
 */

import { EditorView, basicSetup } from '@codemirror/view';
import { EditorState, Compartment } from '@codemirror/state';
import { javascript } from '@codemirror/lang-javascript';
import { python } from '@codemirror/lang-python';
import { html } from '@codemirror/lang-html';
import { css } from '@codemirror/lang-css';
import { php } from '@codemirror/lang-php';
import { sql } from '@codemirror/lang-sql';
import { json } from '@codemirror/lang-json';
import { oneDark } from '@codemirror/theme-one-dark';
import { githubLight, githubDark } from '@uiw/codemirror-theme-github';
import { dracula } from '@uiw/codemirror-theme-dracula';
import { monokai } from '@uiw/codemirror-theme-monokai';
import { nord } from '@uiw/codemirror-theme-nord';
import { solarizedLight, solarizedDark } from '@uiw/codemirror-theme-solarized';
import { autocompletion } from '@codemirror/autocomplete';
import { search, highlightSelectionMatches } from '@codemirror/search';
import { lintGutter } from '@codemirror/lint';

class CodeEditorManager {
    constructor() {
        this.editors = new Map();
        this.defaultSettings = {
            theme: 'github-light',
            fontSize: 14,
            lineNumbers: true,
            lineWrapping: false,
            tabSize: 4,
            indentWithTabs: false,
            autoCloseBrackets: true,
            language: 'auto',
            keyMap: 'default'
        };
        this.settings = { ...this.defaultSettings };
        this.loadSettings();
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
     * Save settings to localStorage
     */
    saveSettings(settings) {
        this.settings = { ...this.settings, ...settings };
        try {
            localStorage.setItem('editorSettings', JSON.stringify(this.settings));
        } catch (e) {
            console.warn('Failed to save editor settings:', e);
        }
    }

    /**
     * Get language extension based on language name
     */
    getLanguageExtension(language) {
        const languages = {
            javascript: javascript(),
            js: javascript(),
            python: python(),
            py: python(),
            html: html(),
            css: css(),
            php: php(),
            sql: sql(),
            json: json()
        };
        return languages[language.toLowerCase()] || javascript();
    }

    /**
     * Get theme extension based on theme name
     */
    getThemeExtension(themeName) {
        const themes = {
            'github-light': githubLight,
            'github-dark': githubDark,
            'one-dark': oneDark,
            'dracula': dracula,
            'monokai': monokai,
            'nord': nord,
            'solarized-light': solarizedLight,
            'solarized-dark': solarizedDark
        };
        return themes[themeName] || githubLight;
    }

    /**
     * Create editor extensions based on settings
     */
    createExtensions(settings = {}) {
        const config = { ...this.settings, ...settings };
        const extensions = [
            basicSetup,
            this.getThemeExtension(config.theme),
            EditorView.lineWrapping.of(config.lineWrapping),
            EditorState.tabSize.of(config.tabSize),
            autocompletion(),
            search(),
            highlightSelectionMatches(),
            lintGutter(),
            EditorView.theme({
                '&': {
                    fontSize: `${config.fontSize}px`,
                    height: '100%'
                },
                '.cm-scroller': {
                    fontFamily: 'Consolas, Monaco, "Courier New", monospace'
                }
            })
        ];

        // Add language support if specified
        if (config.language && config.language !== 'auto') {
            extensions.push(this.getLanguageExtension(config.language));
        }

        return extensions;
    }

    /**
     * Initialize a code editor on a textarea element
     */
    initialize(textarea, options = {}) {
        if (!textarea) {
            console.error('Textarea element not found');
            return null;
        }

        // Get initial content
        const initialContent = textarea.value || '';
        
        // Merge options with saved settings
        const editorSettings = { ...this.settings, ...options };

        // Auto-detect language from textarea attributes
        if (editorSettings.language === 'auto') {
            const dataLang = textarea.getAttribute('data-language');
            if (dataLang) {
                editorSettings.language = dataLang;
            }
        }

        // Create editor state
        const state = EditorState.create({
            doc: initialContent,
            extensions: this.createExtensions(editorSettings)
        });

        // Create container for editor
        const container = document.createElement('div');
        container.className = 'code-editor-container';
        container.style.cssText = `
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            overflow: hidden;
            min-height: ${options.minHeight || '300px'};
        `;

        // Insert container after textarea
        textarea.parentNode.insertBefore(container, textarea.nextSibling);
        textarea.style.display = 'none';

        // Create editor view
        const view = new EditorView({
            state,
            parent: container,
            dispatch: (transaction) => {
                view.update([transaction]);
                // Sync with textarea for form submission
                textarea.value = view.state.doc.toString();
                // Trigger change event
                textarea.dispatchEvent(new Event('change', { bubbles: true }));
            }
        });

        // Store editor instance
        const editorId = textarea.id || `editor-${this.editors.size}`;
        this.editors.set(editorId, {
            view,
            textarea,
            container,
            settings: editorSettings
        });

        return {
            id: editorId,
            view,
            getValue: () => view.state.doc.toString(),
            setValue: (value) => {
                view.dispatch({
                    changes: {
                        from: 0,
                        to: view.state.doc.length,
                        insert: value
                    }
                });
                textarea.value = value;
            },
            updateSettings: (newSettings) => this.updateEditor(editorId, newSettings),
            destroy: () => this.destroyEditor(editorId)
        };
    }

    /**
     * Update editor settings
     */
    updateEditor(editorId, newSettings) {
        const editor = this.editors.get(editorId);
        if (!editor) return;

        const updatedSettings = { ...editor.settings, ...newSettings };
        const currentContent = editor.view.state.doc.toString();

        // Create new state with updated extensions
        const newState = EditorState.create({
            doc: currentContent,
            extensions: this.createExtensions(updatedSettings)
        });

        // Update view
        editor.view.setState(newState);
        editor.settings = updatedSettings;
    }

    /**
     * Destroy an editor instance
     */
    destroyEditor(editorId) {
        const editor = this.editors.get(editorId);
        if (!editor) return;

        editor.view.destroy();
        editor.container.remove();
        editor.textarea.style.display = '';
        this.editors.delete(editorId);
    }

    /**
     * Initialize all textareas with data-code-editor attribute
     */
    initializeAll() {
        const textareas = document.querySelectorAll('textarea[data-code-editor]');
        const editors = [];
        
        textareas.forEach(textarea => {
            const options = {
                language: textarea.getAttribute('data-language') || 'auto',
                minHeight: textarea.getAttribute('data-min-height') || '300px',
                readOnly: textarea.hasAttribute('readonly')
            };
            
            const editor = this.initialize(textarea, options);
            if (editor) {
                editors.push(editor);
            }
        });

        return editors;
    }

    /**
     * Get all available themes
     */
    getAvailableThemes() {
        return [
            { value: 'github-light', label: 'GitHub Light', category: 'light' },
            { value: 'github-dark', label: 'GitHub Dark', category: 'dark' },
            { value: 'one-dark', label: 'One Dark', category: 'dark' },
            { value: 'dracula', label: 'Dracula', category: 'dark' },
            { value: 'monokai', label: 'Monokai', category: 'dark' },
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
            { value: 'auto', label: 'Auto-detect' },
            { value: 'javascript', label: 'JavaScript' },
            { value: 'python', label: 'Python' },
            { value: 'html', label: 'HTML' },
            { value: 'css', label: 'CSS' },
            { value: 'php', label: 'PHP' },
            { value: 'sql', label: 'SQL' },
            { value: 'json', label: 'JSON' }
        ];
    }
}

// Create global instance
window.codeEditorManager = new CodeEditorManager();

// Auto-initialize on DOM ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        window.codeEditorManager.initializeAll();
    });
} else {
    window.codeEditorManager.initializeAll();
}

export default CodeEditorManager;
