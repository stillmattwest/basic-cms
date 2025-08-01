@props([
    'disabled' => false,
    'error' => null,
    'label' => null,
    'required' => false,
    'placeholder' => '',
    'helpText' => null,
    'showToggle' => true,
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
            type="password"
            {{ $disabled ? 'disabled' : '' }} 
            placeholder="{{ $placeholder }}"
            {!! $attributes->merge(['class' => 'block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white disabled:bg-gray-100 disabled:text-gray-500 disabled:cursor-not-allowed' . ($showToggle ? ' pr-10' : '') . ($error ? ' border-red-500 focus:ring-red-500 focus:border-red-500' : '')]) !!}
        />
        
        @if($showToggle)
            <button 
                type="button" 
                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                onclick="togglePasswordVisibility(this)"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path class="eye-open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path class="eye-open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    <path class="eye-closed hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                </svg>
            </button>
        @endif
    </div>
    
    @if($helpText)
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $helpText }}</p>
    @endif
    
    @if($error)
        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $error }}</p>
    @endif
</div>

@if($showToggle)
    @push('scripts')
    <script>
        function togglePasswordVisibility(button) {
            const input = button.parentElement.querySelector('input');
            const eyeOpen = button.querySelectorAll('.eye-open');
            const eyeClosed = button.querySelector('.eye-closed');
            
            if (input.type === 'password') {
                input.type = 'text';
                eyeOpen.forEach(el => el.classList.add('hidden'));
                eyeClosed.classList.remove('hidden');
            } else {
                input.type = 'password';
                eyeOpen.forEach(el => el.classList.remove('hidden'));
                eyeClosed.classList.add('hidden');
            }
        }
    </script>
    @endpush
@endif
