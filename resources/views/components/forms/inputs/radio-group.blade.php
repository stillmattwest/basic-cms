@props([
    'disabled' => false,
    'error' => null,
    'label' => null,
    'required' => false,
    'helpText' => null,
    'options' => [],
    'name' => '',
])

<div class="mb-4">
    @if($label)
        <fieldset>
            <legend class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                {{ $label }}
                @if($required)
                    <span class="text-red-500">*</span>
                @endif
            </legend>
            
            @if($helpText)
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">{{ $helpText }}</p>
            @endif
            
            <div class="space-y-2">
                @if($slot->isNotEmpty())
                    {{ $slot }}
                @else
                    @foreach($options as $value => $text)
                        <div class="flex items-center">
                            <input 
                                type="radio"
                                name="{{ $name }}"
                                value="{{ $value }}"
                                {{ $disabled ? 'disabled' : '' }}
                                id="{{ $name }}_{{ $value }}"
                                class="w-4 h-4 text-blue-600 bg-white border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 disabled:bg-gray-100 disabled:border-gray-300 disabled:cursor-not-allowed {{ $error ? 'border-red-500' : '' }}"
                            />
                            <label for="{{ $name }}_{{ $value }}" class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ $text }}
                            </label>
                        </div>
                    @endforeach
                @endif
            </div>
        </fieldset>
    @endif
    
    @if($error)
        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $error }}</p>
    @endif
</div>
