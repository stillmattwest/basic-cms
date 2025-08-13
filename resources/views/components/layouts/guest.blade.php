<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Highlight.js Theme (Dynamic) -->
        <link rel="stylesheet" href="{{ asset('css/highlight/light.css') }}" id="hljs-theme">
        
        <script>
        // Set correct initial theme before page loads
        (function() {
            const isDark = localStorage.getItem('theme') === 'dark' || 
                          (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches);
            
            if (isDark) {
                document.documentElement.classList.add('dark');
                const link = document.getElementById('hljs-theme');
                if (link) {
                    link.href = '{{ asset('css/highlight/dark.css') }}';
                }
            }
        })();
        </script>
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
        
        <!-- Highlight.js Theme Switching -->
        <script>
            function updateHighlightTheme() {
                const themeLink = document.getElementById('hljs-theme');
                const isDark = document.documentElement.classList.contains('dark');
                
                if (themeLink) {
                    const newHref = isDark 
                        ? '{{ asset('css/highlight/dark.css') }}'
                        : '{{ asset('css/highlight/light.css') }}';
                    
                    // Only update if the theme actually changed
                    if (themeLink.href !== newHref) {
                        themeLink.href = newHref;
                    }
                }
            }
            
            // Initial theme setup
            document.addEventListener('DOMContentLoaded', function() {
                updateHighlightTheme();
            });
            
            // Listen for theme changes from your theme toggle
            window.addEventListener('theme-changed', function() {
                updateHighlightTheme();
            });
            
            // Handle page load with existing dark mode
            if (document.documentElement.classList.contains('dark')) {
                updateHighlightTheme();
            }
        </script>
    </body>
</html>
