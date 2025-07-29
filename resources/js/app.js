import './bootstrap';

import Alpine from 'alpinejs';
import Quill from 'quill';
import 'quill/dist/quill.snow.css';

// Make Quill available globally for the Alpine component
window.Quill = Quill;

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
        
        // Handle dark mode styling
        this.applyDarkModeStyles();
    },
    
    applyDarkModeStyles() {
        if (document.documentElement.classList.contains('dark')) {
            const editorContainer = this.$refs.editor;
            const toolbar = editorContainer.previousElementSibling || editorContainer.parentElement.querySelector('.ql-toolbar');
            
            // Style the editor content area
            this.quill.root.style.color = '#f9fafb';
            this.quill.root.style.backgroundColor = '#374151';
            
            // Style the toolbar if it exists
            if (toolbar && toolbar.classList.contains('ql-toolbar')) {
                toolbar.style.backgroundColor = '#4b5563';
                toolbar.style.borderColor = '#6b7280';
                
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
                });
                
                // Style active states
                const activeButtons = toolbar.querySelectorAll('.ql-active');
                activeButtons.forEach(button => {
                    button.style.color = '#60a5fa';
                });
            }
        }
    }
}));

window.Alpine = Alpine;

Alpine.start();
