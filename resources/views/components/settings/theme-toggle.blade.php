@props([
    'size' => 'default', // 'small', 'default', 'large'
    'showLabel' => false,
])

@php
    $sizeClasses = match($size) {
        'small' => 'w-10 h-6',
        'large' => 'w-16 h-8',
        default => 'w-12 h-6'
    };
    
    $toggleClasses = match($size) {
        'small' => 'w-4 h-4',
        'large' => 'w-6 h-6',
        default => 'w-5 h-5'
    };
    
    $iconClasses = match($size) {
        'small' => 'w-3 h-3',
        'large' => 'w-4 h-4',
        default => 'w-3.5 h-3.5'
    };
@endphp

<div 
    x-data="themeToggle()" 
    x-init="init()"
    class="flex items-center space-x-3"
>
    @if($showLabel)
        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
            Theme
        </span>
    @endif
    
    <!-- Toggle Switch -->
    <button
        @click="toggleTheme()"
        :class="isDark ? 'bg-primary-600' : 'bg-gray-200'"
        class="{{ $sizeClasses }} relative inline-flex items-center rounded-full transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
        :aria-label="isDark ? 'Switch to light mode' : 'Switch to dark mode'"
        type="button"
    >
        <!-- Toggle Circle -->
        <span
            :class="isDark ? 'translate-x-6' : 'translate-x-1'"
            class="{{ $toggleClasses }} flex items-center justify-center bg-white rounded-full shadow-lg transform transition-transform duration-200 ease-in-out"
        >
            <!-- Sun Icon (Light Mode) -->
            <svg 
                x-show="!isDark"
                class="{{ $iconClasses }} text-featured-500"
                fill="currentColor" 
                viewBox="0 0 20 20"
            >
                <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd" />
            </svg>
            
            <!-- Moon Icon (Dark Mode) -->
            <svg 
                x-show="isDark"
                class="{{ $iconClasses }} text-primary-600"
                fill="currentColor" 
                viewBox="0 0 20 20"
            >
                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
            </svg>
        </span>
    </button>
    
    @if($showLabel)
        <span class="text-sm text-gray-500 dark:text-gray-400" x-text="isDark ? 'Dark' : 'Light'"></span>
    @endif
</div>

<script>
    function themeToggle() {
        return {
            isDark: false,
            
            init() {
                // Check for saved theme preference or default to system preference
                const savedTheme = localStorage.getItem('theme');
                const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                
                if (savedTheme) {
                    this.isDark = savedTheme === 'dark';
                } else {
                    this.isDark = systemPrefersDark;
                }
                
                this.updateTheme();
                
                // Listen for system theme changes
                window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
                    if (!localStorage.getItem('theme')) {
                        this.isDark = e.matches;
                        this.updateTheme();
                    }
                });
            },
            
            toggleTheme() {
                this.isDark = !this.isDark;
                this.updateTheme();
                this.saveTheme();
            },
            
            updateTheme() {
                if (this.isDark) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
                
                // Dispatch custom event for other components that might need to know
                window.dispatchEvent(new CustomEvent('theme-changed', {
                    detail: { isDark: this.isDark }
                }));
            },
            
            saveTheme() {
                localStorage.setItem('theme', this.isDark ? 'dark' : 'light');
            }
        }
    }
</script>
