@props([
    'disabled' => false,
    'error' => null,
    'label' => null,
    'required' => false,
    'placeholder' => '',
    'helpText' => null,
    'toolbar' => 'full', // 'full', 'basic', or custom array
    'height' => '200px',
])

@php
    $editorId = $attributes->get('id') ?: 'editor_' . uniqid();
    $inputName = $attributes->get('name') ?: 'content';
    $value = $attributes->get('value') ?: old($inputName) ?: $slot;
    
    // Define toolbar configurations
    $toolbarConfigs = [
        'basic' => [
            ['bold', 'italic', 'underline'],
            ['link', 'blockquote'],
            [['list' => 'ordered'], ['list' => 'bullet']],
            ['clean']
        ],
        'full' => [
            [['header' => [1, 2, 3, 4, 5, 6, false]]],
            ['bold', 'italic', 'underline', 'strike'],
            [['color' => []], ['background' => []]],
            [['list' => 'ordered'], ['list' => 'bullet']],
            ['blockquote', 'code-block'],
            ['link', 'image'],
            [['align' => []]],
            ['clean']
        ]
    ];
    
    $toolbarConfig = is_array($toolbar) ? $toolbar : ($toolbarConfigs[$toolbar] ?? $toolbarConfigs['full']);
@endphp

<div class="mb-4">
    @if($label)
        <label for="{{ $editorId }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif
    
    <div 
        x-data="wysiwygEditor('{{ $editorId }}', @js($toolbarConfig), '{{ $height }}', {{ $disabled ? 'true' : 'false' }})" 
        x-init="initEditor()"
        class="border border-gray-300 dark:border-gray-600 rounded-md overflow-hidden focus-within:ring-2 focus-within:ring-primary-500 focus-within:border-primary-500 transition-colors duration-200 {{ $error ? 'border-red-500 focus-within:ring-red-500 focus-within:border-red-500' : '' }}"
    >
        <!-- Quill Editor Container -->
        <div x-ref="editor" style="height: {{ $height }};" class="bg-white dark:bg-gray-700" data-placeholder="{{ $placeholder }}"></div>
        
        <!-- Hidden input to store the HTML content -->
        <input 
            type="hidden" 
            name="{{ $inputName }}" 
            x-ref="hiddenInput"
            value="{{ htmlspecialchars($value) }}"
            {{ $required ? 'required' : '' }}
        />
    </div>
    
    @if($helpText)
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $helpText }}</p>
    @endif
    
    @if($error)
        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $error }}</p>
    @endif
</div>


