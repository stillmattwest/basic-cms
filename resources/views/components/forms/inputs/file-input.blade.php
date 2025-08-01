@props([
    'disabled' => false,
    'error' => null,
    'label' => null,
    'required' => false,
    'helpText' => null,
    'accept' => null,
])

<div class="mb-4">
    @if($label)
        <label for="{{ $attributes->get('id') }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif
    
    <div class="relative">
        <input 
            type="file"
            {{ $disabled ? 'disabled' : '' }}
            @if($accept) accept="{{ $accept }}" @endif
            {!! $attributes->merge(['class' => 'block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-gray-300 dark:file:bg-primary-800 dark:file:text-primary-200 disabled:bg-gray-100 disabled:text-gray-500 disabled:cursor-not-allowed' . ($error ? ' border-red-500' : '')]) !!}
        />
    </div>
    
    @if($helpText)
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $helpText }}</p>
    @endif
    
    @if($error)
        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $error }}</p>
    @endif
</div>
