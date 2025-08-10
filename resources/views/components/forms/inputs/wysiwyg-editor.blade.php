@props([
    'disabled' => false,
    'error' => null,
    'label' => null,
    'required' => false,
    'placeholder' => '',
    'helpText' => null,
    'toolbar' => 'full',
    'height' => '200px',
])

@php
    $editorId = $attributes->get('id') ?: 'editor_' . uniqid();
    $inputName = $attributes->get('name') ?: 'content';
    $value = $attributes->get('value') ?: old($inputName) ?: $slot;
    
    // Decode HTML entities properly for Quill
    $decodedValue = html_entity_decode($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');

    $toolbarConfigs = [
        'basic' => [
            ['bold', 'italic', 'underline'],
            ['link', 'blockquote'],
            [['list' => 'ordered'], ['list' => 'bullet']],
            ['clean'],
        ],
        'full' => [
            [['header' => [1, 2, 3, 4, 5, 6, false]]],
            ['bold', 'italic', 'underline', 'strike'],
            [['color' => []], ['background' => []]],
            [['list' => 'ordered'], ['list' => 'bullet']],
            ['blockquote', 'code-block'],
            ['link', 'image'],
            [['align' => []]],
            ['clean'],
        ],
    ];

    $toolbarConfig = is_array($toolbar) ? $toolbar : $toolbarConfigs[$toolbar] ?? $toolbarConfigs['full'];
@endphp

<div class="mb-4">
    @if ($label)
        <label for="{{ $editorId }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            {{ $label }}
            @if ($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <div x-data="wysiwygEditor" x-init="init('{{ $editorId }}', @js($toolbarConfig), '{{ $height }}', {{ $disabled ? 'true' : 'false' }}, '{{ $inputName }}')"
        class="relative border border-gray-300 dark:border-gray-600 rounded-md overflow-hidden focus-within:ring-2 focus-within:ring-primary-500 focus-within:border-primary-500 dark:focus-within:ring-primary-400 dark:focus-within:border-primary-400 transition-colors duration-200 {{ $error ? 'border-red-500 focus-within:ring-red-500 focus-within:border-red-500' : '' }}">
        <!-- Quill Editor Container -->
        <div x-ref="editor" style="height: {{ $height }};"
            class="bg-white dark:bg-gray-700 text-gray-900 dark:text-white" data-placeholder="{{ $placeholder }}"></div>

        <!-- Hidden input to store the HTML content -->
        <input type="hidden" name="{{ $inputName }}" x-ref="hiddenInput" value="{{ $decodedValue }}"
            {{ $required ? 'required' : '' }} />

        <!-- Hidden file input for image uploads -->
        <input type="file" x-ref="imageInput" accept="image/*" style="display: none;"
            @change="handleImageUpload($event)" />

        <!-- Loading overlay -->
        <div x-show="uploadingImage" x-transition
            class="absolute inset-0 bg-gray-500 dark:bg-gray-900 bg-opacity-75 flex items-center justify-center z-10">
            <div
                class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 flex items-center space-x-3 shadow-lg">
                <svg class="animate-spin h-5 w-5 text-primary-600 dark:text-primary-400"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                <span class="text-sm text-gray-900 dark:text-white">Uploading image...</span>
            </div>
        </div>
    </div>

    @if ($helpText)
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $helpText }}</p>
    @endif

    @if ($error)
        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $error }}</p>
    @endif
</div>

@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('wysiwygEditor', () => ({
                quill: null,
                uploadingImage: false,
                isDark: false,
                focusListenerAdded: false,
                blurListenerAdded: false,

                init(editorId, toolbar, height, disabled, inputName) {
                    this.initDarkModeTracking();
                    this.initEditor(editorId, toolbar, height, disabled, inputName);
                },

                initDarkModeTracking() {
                    // Initialize dark mode state
                    this.isDark = document.documentElement.classList.contains('dark');

                    // Listen for theme changes (from your theme toggle component)
                    window.addEventListener('theme-changed', (e) => {
                        this.isDark = e.detail.isDark;
                        this.applyThemeStyles();
                    });

                    // Watch for dark mode class changes on document
                    const observer = new MutationObserver(() => {
                        const newIsDark = document.documentElement.classList.contains('dark');
                        if (newIsDark !== this.isDark) {
                            this.isDark = newIsDark;
                            this.applyThemeStyles();
                        }
                    });

                    observer.observe(document.documentElement, {
                        attributes: true,
                        attributeFilter: ['class']
                    });
                },

                initEditor(editorId, toolbar, height, disabled, inputName) {
                    if (toolbar) {
                        // Build modules configuration
                        const modules = {
                            toolbar: toolbar,
                            syntax: {
                                hljs: window.hljs
                            },
                            history: {
                                delay: 2000,
                                maxStack: 500,
                                userOnly: true
                            }
                        };


                        this.quill = new Quill(this.$refs.editor, {
                            theme: 'snow',
                            modules: modules,
                            placeholder: this.$refs.editor.dataset.placeholder,
                            readOnly: disabled
                        });

                        // Register image handler
                        const toolbarModule = this.quill.getModule('toolbar');
                        if (toolbarModule) {
                            toolbarModule.addHandler('image', () => {
                                this.imageHandler();
                            });
                        }

                        // Set initial content
                        const hiddenInput = this.$refs.hiddenInput;
                        if (hiddenInput.value.trim()) {
                            this.quill.root.innerHTML = hiddenInput.value;
                        }

                        // Update hidden input on content change - with cleanup
                        this.quill.on('text-change', () => {
                            hiddenInput.value = this.getCleanedContent();
                        });

                        // Apply initial theme
                        this.applyThemeStyles();
                        
                        // Initialize syntax highlighting for code blocks
                        this.initCodeBlockHighlighting();
                    }
                },

                initCodeBlockHighlighting() {
                    // Listen for text changes to highlight code blocks
                    this.quill.on('text-change', (delta, oldDelta, source) => {
                        if (source === 'user') {
                            // Small delay to ensure DOM updates
                            setTimeout(() => {
                                this.highlightCodeBlocks();
                            }, 10);
                        }
                    });
                    
                    // Initial highlighting
                    this.highlightCodeBlocks();
                },
                
                highlightCodeBlocks() {
                    if (!window.hljs) return;
                    
                    const codeBlocks = this.quill.root.querySelectorAll('.ql-code-block');
                    codeBlocks.forEach(block => {
                        // Remove any existing highlighting classes
                        block.className = 'ql-code-block';
                        
                        // Apply syntax highlighting
                        window.hljs.highlightElement(block);
                    });
                },

                // Clean content for storage - preserve Quill structure for QuillHelper
                getCleanedContent() {
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = this.quill.root.innerHTML;
                    
                    // Remove all select elements (language dropdowns)
                    const selects = tempDiv.querySelectorAll('select.ql-ui');
                    selects.forEach(select => select.remove());
                    
                    // Remove any elements with contenteditable="false" (UI elements)
                    const nonEditables = tempDiv.querySelectorAll('[contenteditable="false"]');
                    nonEditables.forEach(element => element.remove());
                    
                    // Clean up highlight.js markup but preserve the basic structure QuillHelper expects
                    const codeBlocks = tempDiv.querySelectorAll('.ql-code-block');
                    codeBlocks.forEach(block => {
                        // Get the plain text content
                        const plainText = block.textContent || block.innerText || '';
                        
                        // Keep data-language if it exists for QuillHelper
                        const language = block.getAttribute('data-language');
                        
                        // Replace with clean content
                        block.innerHTML = plainText || '<br>';
                        block.className = 'ql-code-block';
                        
                        // Preserve language for QuillHelper
                        if (language) {
                            block.setAttribute('data-language', language);
                        }
                        
                        // Remove highlight.js attributes
                        block.removeAttribute('data-highlighted');
                    });
                    
                    return tempDiv.innerHTML;
                },

                applyThemeStyles() {
                    if (!this.quill) return;

                    const toolbar = this.quill.getModule('toolbar').container;
                    const editor = this.quill.root;

                    // Add hover styles for toolbar buttons
                    this.addHoverStyles();

                    if (this.isDark) {
                        // Dark mode styles
                        editor.style.color = '#f9fafb';
                        editor.style.backgroundColor = '#374151';

                        if (toolbar && toolbar.classList.contains('ql-toolbar')) {
                            toolbar.style.backgroundColor = '#4b5563';
                            toolbar.style.borderColor = '#6b7280';

                            // Style toolbar buttons
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

                            // Style active states with primary color
                            const activeButtons = toolbar.querySelectorAll('.ql-active');
                            activeButtons.forEach(button => {
                                button.style.color = '#2dd4bf'; // primary-400
                            });
                        }
                    } else {
                        // Light mode styles
                        editor.style.color = '#111827';
                        editor.style.backgroundColor = '#ffffff';

                        if (toolbar && toolbar.classList.contains('ql-toolbar')) {
                            toolbar.style.backgroundColor = '#ffffff';
                            toolbar.style.borderColor = '#d1d5db';

                            // Reset toolbar buttons
                            const buttons = toolbar.querySelectorAll('.ql-stroke');
                            buttons.forEach(button => {
                                button.style.stroke = '#374151';
                            });

                            const fills = toolbar.querySelectorAll('.ql-fill');
                            fills.forEach(fill => {
                                fill.style.fill = '#374151';
                            });

                            // Reset dropdown text
                            const pickers = toolbar.querySelectorAll('.ql-picker-label');
                            pickers.forEach(picker => {
                                picker.style.color = '#374151';
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
                                item.style.color = '#374151';
                            });

                            // Style active states with primary color
                            const activeButtons = toolbar.querySelectorAll('.ql-active');
                            activeButtons.forEach(button => {
                                button.style.color = '#0d9488'; // primary-600
                            });
                        }
                    }

                    // Add focus/blur listeners only once
                    const editorContainer = this.$refs.editor;
                    if (!this.focusListenerAdded) {
                        editor.addEventListener('focus', () => {
                            editorContainer.parentElement.style.borderColor = this.isDark ?
                                '#2dd4bf' : '#0d9488';
                            editorContainer.parentElement.style.boxShadow = this.isDark ?
                                '0 0 0 3px rgba(45, 212, 191, 0.1)' :
                                '0 0 0 3px rgba(13, 148, 136, 0.1)';
                        });
                        this.focusListenerAdded = true;
                    }

                    if (!this.blurListenerAdded) {
                        editor.addEventListener('blur', () => {
                            editorContainer.parentElement.style.borderColor = this.isDark ?
                                '#6b7280' : '#d1d5db';
                            editorContainer.parentElement.style.boxShadow = 'none';
                        });
                        this.blurListenerAdded = true;
                    }
                },

                addHoverStyles() {
                    // Create or update the style element for hover effects
                    let styleId = 'wysiwyg-hover-styles';
                    let existingStyle = document.getElementById(styleId);
                    
                    if (existingStyle) {
                        existingStyle.remove();
                    }

                    const style = document.createElement('style');
                    style.id = styleId;
                    
                    const hoverCSS = `
                        .ql-toolbar .ql-formats button:hover {
                            background-color: ${this.isDark ? '#14b8a6' : '#f0fdfa'} !important;
                            border-radius: 3px !important;
                            transition: background-color 0.2s ease-in-out !important;
                        }
                        
                        .ql-toolbar .ql-formats button:hover .ql-stroke {
                            stroke: ${this.isDark ? '#ffffff' : '#0d9488'} !important;
                            transition: stroke 0.2s ease-in-out !important;
                        }
                        
                        .ql-toolbar .ql-formats button:hover .ql-fill {
                            fill: ${this.isDark ? '#ffffff' : '#0d9488'} !important;
                            transition: fill 0.2s ease-in-out !important;
                        }
                        
                        .ql-toolbar .ql-formats .ql-picker-label:hover {
                            background-color: ${this.isDark ? '#14b8a6' : '#f0fdfa'} !important;
                            color: ${this.isDark ? '#ffffff' : '#0d9488'} !important;
                            border-radius: 3px !important;
                            transition: all 0.2s ease-in-out !important;
                        }
                        
                        .ql-toolbar .ql-formats button.ql-active {
                            background-color: ${this.isDark ? '#0d9488' : '#14b8a6'} !important;
                            border-radius: 3px !important;
                        }
                        
                        .ql-toolbar .ql-formats button.ql-active .ql-stroke {
                            stroke: #ffffff !important;
                        }
                        
                        .ql-toolbar .ql-formats button.ql-active .ql-fill {
                            fill: #ffffff !important;
                        }
                    `;
                    
                    style.textContent = hoverCSS;
                    document.head.appendChild(style);
                },


                decodeHtmlEntities(str) {
                    const textarea = document.createElement('textarea');
                    textarea.innerHTML = str;
                    return textarea.value;
                },

                imageHandler() {
                    this.$refs.imageInput.click();
                },

                async handleImageUpload(event) {
                    const file = event.target.files[0];
                    if (!file) return;

                    // Validate file
                    if (!file.type.startsWith('image/')) {
                        alert('Please select an image file.');
                        return;
                    }

                    if (file.size > 2048 * 1024) {
                        alert('Image size must be less than 2MB.');
                        return;
                    }

                    this.uploadingImage = true;

                    try {
                        const formData = new FormData();
                        formData.append('image', file);

                        const response = await fetch('/images/upload', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute('content')
                            }
                        });

                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }

                        const result = await response.json();

                        if (result.success) {
                            // Auto-populate featured image field if empty
                            const featuredImageInput = document.querySelector('input[name="featured_image"]');
                            if (featuredImageInput && !featuredImageInput.value) {
                                featuredImageInput.value = result.url;
                            }

                            // Get current content as HTML and append image
                            const currentHTML = this.quill.root.innerHTML;
                            const currentLength = this.quill.getLength();

                            // Create image HTML
                            let imageHTML = `<img src="${result.url}" alt="Uploaded image">`;

                            // If there's existing content (more than just the empty paragraph), add line breaks
                            if (currentLength > 1 && currentHTML.trim() !== '<p><br></p>') {
                                imageHTML = `<p><br></p>${imageHTML}<p><br></p>`;
                            } else {
                                imageHTML = `${imageHTML}<p><br></p>`;
                            }

                            // Append to current content
                            const newHTML = currentHTML.replace(/<p><br><\/p>$/, '') + imageHTML;

                            // Set the new content
                            this.quill.root.innerHTML = newHTML;

                            // Manually update the hidden input with cleaned content
                            this.$refs.hiddenInput.value = this.getCleanedContent();

                            // Trigger text-change event to ensure consistency
                            this.quill.emitter.emit('text-change');
                        } else {
                            throw new Error(result.message || 'Upload failed');
                        }

                    } catch (error) {
                        console.error('Upload error:', error);
                        alert('Failed to upload image: ' + error.message);
                    } finally {
                        this.uploadingImage = false;
                        event.target.value = '';
                    }
                },

            }))
        });
    </script>
@endpush