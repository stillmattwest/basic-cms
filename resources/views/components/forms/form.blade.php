@props([
    'action' => '#',
    'method' => 'POST',
    'enctype' => null,
    'title' => null,
    'description' => null,
    'submitText' => 'Submit',
    'cancelText' => 'Cancel',
    'cancelUrl' => null,
    'showButtons' => true,
    'submitClass' => '',
    'cancelClass' => '',
])

<div class="max-w-4xl mx-auto">
    @if($title && $description)
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                {{ $title }}
            </h1>
            
            <p class="text-lg text-gray-600 dark:text-gray-400">
                {{ $description }}
            </p>
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
        @if($title && !$description)
            <div class="px-6 pt-6 pb-2">
                <h2 class="text-2xl font-bold text-center text-gray-900 dark:text-white">{{ $title }}</h2>
            </div>
        @endif
        
        <form
            action="{{ $action }}" 
            method="{{ $method === 'GET' ? 'GET' : 'POST' }}"
            @if($enctype) enctype="{{ $enctype }}" @endif
            {{ $attributes->except(['action', 'method', 'enctype', 'title', 'description', 'submitText', 'cancelText', 'cancelUrl', 'showButtons', 'submitClass', 'cancelClass']) }}
        >   
            @if($method !== 'GET' && $method !== 'POST')
                @method($method)
            @endif
            
            @csrf

            <div class="p-6 space-y-6">
                {{ $slot }}
            </div>

            @if($showButtons)
                <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 border-t border-gray-200 dark:border-gray-600 rounded-b-lg">
                    <div class="flex items-center justify-end space-x-3">
                        @if($cancelUrl)
                            <a 
                                href="{{ $cancelUrl }}" 
                                class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors {{ $cancelClass }}"
                            >
                                {{ $cancelText }}
                            </a>
                        @endif
                        
                        <button 
                            type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-primary-600 dark:bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white dark:text-white uppercase tracking-widest hover:bg-primary-700 dark:hover:bg-primary-700 focus:bg-primary-700 dark:focus:bg-primary-700 active:bg-primary-800 dark:active:bg-primary-800 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 {{ $submitClass }}"
                        >
                            {{ $submitText }}
                        </button>
                    </div>
                </div>
            @endif
        </form>
    </div>
</div>
