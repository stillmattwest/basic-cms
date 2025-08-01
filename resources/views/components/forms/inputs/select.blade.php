@props([
    'disabled' => false,
    'error' => null,
    'label' => null,
    'required' => false,
    'placeholder' => 'Choose an option',
    'helpText' => null,
    'options' => [],
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
    
    <select 
        {{ $disabled ? 'disabled' : '' }} 
        {!! $attributes->merge(['class' => 'block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white disabled:bg-gray-100 disabled:text-gray-500 disabled:cursor-not-allowed' . ($error ? ' border-red-500 focus:ring-red-500 focus:border-red-500' : '')]) !!}
    >
        @if($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif
        
        @if($slot->isNotEmpty())
            {{ $slot }}
        @else
            @foreach($options as $value => $text)
                <option value="{{ $value }}">{{ $text }}</option>
            @endforeach
        @endif
    </select>
    
    @if($helpText)
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $helpText }}</p>
    @endif
    
    @if($error)
        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $error }}</p>
    @endif
</div>
