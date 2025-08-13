import './bootstrap';

import Alpine from 'alpinejs';
import Quill from 'quill';
import QuillResizeImage from 'quill-resize-image';
import hljs from 'highlight.js';
import 'quill/dist/quill.snow.css';
import 'highlight.js/styles/github.css';

// Configure highlight.js for Quill
hljs.configure({
    languages: ['javascript', 'php', 'html', 'css', 'python', 'sql', 'json', 'bash']
});

// Register the resize module
Quill.register('modules/resize', QuillResizeImage);

// Make Quill and hljs available globally for the Alpine component
window.Quill = Quill;
window.hljs = hljs;

// Register WYSIWYG editor Alpine component
Alpine.data('wysiwygEditor', (editorId, toolbarConfig, height, disabled) => ({
    quill: null,
    
    initEditor() {
        this.quill = new Quill(this.$refs.editor, {
            theme: 'snow',
            modules: {
                toolbar: toolbarConfig
            },
            placeholder: this.$refs.editor.getAttribute('data-placeholder') || '',
            readOnly: disabled
        });
        
        // Set initial content
        const initialContent = this.$refs.hiddenInput.value;
        if (initialContent) {
            this.quill.root.innerHTML = initialContent;
        }
        
        // Update hidden input when content changes
        this.quill.on('text-change', () => {
            this.$refs.hiddenInput.value = this.quill.root.innerHTML;
            
            // Dispatch input event for form validation
            this.$refs.hiddenInput.dispatchEvent(new Event('input', { bubbles: true }));
        });
        
        // Apply initial theme
        this.applyThemeStyles();
        
        // Listen for theme changes
        window.addEventListener('theme-changed', (e) => {
            this.applyThemeStyles();
        });
        
        // Also listen for system theme changes
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
            setTimeout(() => this.applyThemeStyles(), 100); // Small delay to allow theme toggle to complete
        });
    },
    
    applyThemeStyles() {
        const isDark = document.documentElement.classList.contains('dark');
        const editorContainer = this.$refs.editor;
        const toolbar = editorContainer.previousElementSibling || editorContainer.parentElement.querySelector('.ql-toolbar');
        
        if (isDark) {
            // Dark mode styles
            this.quill.root.style.color = '#f9fafb';
            this.quill.root.style.backgroundColor = '#374151';
            
            // Style the toolbar if it exists
            if (toolbar && toolbar.classList.contains('ql-toolbar')) {
                toolbar.style.backgroundColor = '#4b5563';
                toolbar.style.borderColor = '#6b7280';
                toolbar.style.borderBottomColor = '#6b7280';
                
                // Style toolbar buttons and controls
                const buttons = toolbar.querySelectorAll('.ql-stroke');
                buttons.forEach(button => {
                    button.style.stroke = '#f9fafb';
                });
                
                const fills = toolbar.querySelectorAll('.ql-fill');
                fills.forEach(fill => {
                    fill.style.fill = '#f9fafb';
                });
                
                // Style dropdown text
                const pickers = toolbar.querySelectorAll('.ql-picker-label');
                pickers.forEach(picker => {
                    picker.style.color = '#f9fafb';
                    picker.style.borderColor = '#6b7280';
                });
                
                // Style dropdown options
                const options = toolbar.querySelectorAll('.ql-picker-options');
                options.forEach(option => {
                    option.style.backgroundColor = '#4b5563';
                    option.style.borderColor = '#6b7280';
                });
                
                const items = toolbar.querySelectorAll('.ql-picker-item');
                items.forEach(item => {
                    item.style.color = '#f9fafb';
                });
                
                // Style active states with primary color (teal)
                const activeButtons = toolbar.querySelectorAll('.ql-active');
                activeButtons.forEach(button => {
                    button.style.color = '#2dd4bf'; // primary-400
                });
                
                // Style hover states
                const allButtons = toolbar.querySelectorAll('button');
                allButtons.forEach(button => {
                    button.addEventListener('mouseenter', () => {
                        if (!button.classList.contains('ql-active')) {
                            button.style.backgroundColor = '#6b7280';
                        }
                    });
                    button.addEventListener('mouseleave', () => {
                        if (!button.classList.contains('ql-active')) {
                            button.style.backgroundColor = '';
                        }
                    });
                });
            }
        } else {
            // Light mode styles
            this.quill.root.style.color = '#111827';
            this.quill.root.style.backgroundColor = '#ffffff';
            
            // Reset toolbar to default light styles
            if (toolbar && toolbar.classList.contains('ql-toolbar')) {
                toolbar.style.backgroundColor = '#ffffff';
                toolbar.style.borderColor = '#d1d5db';
                toolbar.style.borderBottomColor = '#d1d5db';
                
                // Reset toolbar buttons and controls
                const buttons = toolbar.querySelectorAll('.ql-stroke');
                buttons.forEach(button => {
                    button.style.stroke = '#444';
                });
                
                const fills = toolbar.querySelectorAll('.ql-fill');
                fills.forEach(fill => {
                    fill.style.fill = '#444';
                });
                
                // Reset dropdown text
                const pickers = toolbar.querySelectorAll('.ql-picker-label');
                pickers.forEach(picker => {
                    picker.style.color = '#444';
                    picker.style.borderColor = '#d1d5db';
                });
                
                // Reset dropdown options
                const options = toolbar.querySelectorAll('.ql-picker-options');
                options.forEach(option => {
                    option.style.backgroundColor = '#ffffff';
                    option.style.borderColor = '#d1d5db';
                });
                
                const items = toolbar.querySelectorAll('.ql-picker-item');
                items.forEach(item => {
                    item.style.color = '#444';
                });
                
                // Style active states with primary color (teal)
                const activeButtons = toolbar.querySelectorAll('.ql-active');
                activeButtons.forEach(button => {
                    button.style.color = '#0d9488'; // primary-600
                });
                
                // Style hover states
                const allButtons = toolbar.querySelectorAll('button');
                allButtons.forEach(button => {
                    button.addEventListener('mouseenter', () => {
                        if (!button.classList.contains('ql-active')) {
                            button.style.backgroundColor = '#f3f4f6';
                        }
                    });
                    button.addEventListener('mouseleave', () => {
                        if (!button.classList.contains('ql-active')) {
                            button.style.backgroundColor = '';
                        }
                    });
                });
            }
        }
        
        // Style focus states for the editor
        this.quill.root.addEventListener('focus', () => {
            editorContainer.parentElement.style.borderColor = isDark ? '#2dd4bf' : '#0d9488'; // primary colors
            editorContainer.parentElement.style.boxShadow = isDark 
                ? '0 0 0 3px rgba(45, 212, 191, 0.1)' 
                : '0 0 0 3px rgba(13, 148, 136, 0.1)';
        });
        
        this.quill.root.addEventListener('blur', () => {
            editorContainer.parentElement.style.borderColor = isDark ? '#6b7280' : '#d1d5db';
            editorContainer.parentElement.style.boxShadow = 'none';
        });
    }
}));

window.Alpine = Alpine;

Alpine.start();
