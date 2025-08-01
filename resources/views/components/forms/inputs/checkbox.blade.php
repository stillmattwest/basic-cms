@props([
    'disabled' => false,
    'error' => null,
    'label' => null,
    'required' => false,
    'helpText' => null,
    'checked' => false,
])

<div class="mb-4">
    <!-- Hidden input to ensure a value is always sent, even when unchecked -->
    <input type="hidden" name="{{ $attributes->get('name') }}" value="0" />
    
    <div class="flex items-start">
        <div class="flex items-center h-5">
            <input 
                type="checkbox"
                value="1"
                {{ $disabled ? 'disabled' : '' }} 
                {{ $checked ? 'checked' : '' }}
                {!! $attributes->merge(['class' => 'w-4 h-4 text-primary-600 bg-white border-gray-300 rounded focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 disabled:bg-gray-100 disabled:border-gray-300 disabled:cursor-not-allowed' . ($error ? ' border-red-500' : '')]) !!}
            />
        </div>
        
        @if($label)
            <div class="ml-3 text-sm">
                <label for="{{ $attributes->get('id') }}" class="font-medium text-gray-700 dark:text-gray-300">
                    {{ $label }}
                    @if($required)
                        <span class="text-red-500">*</span>
                    @endif
                </label>
                
                @if($helpText)
                    <p class="text-gray-500 dark:text-gray-400">{{ $helpText }}</p>
                @endif
            </div>
        @endif
    </div>
    
    @if($error)
        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $error }}</p>
    @endif
</div>
