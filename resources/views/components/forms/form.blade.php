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
    @if($title || $description)
        <div class="mb-8">
            @if($title)
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                    {{ $title }}
                </h1>
            @endif
            
            @if($description)
                <p class="text-lg text-gray-600 dark:text-gray-400">
                    {{ $description }}
                </p>
            @endif
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
        <form 
            action="{{ $action }}" 
            method="{{ $method === 'GET' ? 'GET' : 'POST' }}"
            @if($enctype) enctype="{{ $enctype }}" @endif
            {{ $attributes->except(['action', 'method', 'enctype', 'title', 'description', 'submitText', 'cancelText', 'cancelUrl', 'showButtons', 'submitClass', 'cancelClass']) }}
        >
            @if($method !== 'GET' && $method !== 'POST')
                @method($method)
            @endif
            
            @if($method !== 'GET')
                @csrf
            @endif

            <div class="p-6 space-y-6">
                {{ $slot }}
            </div>

            @if($showButtons)
                <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 border-t border-gray-200 dark:border-gray-600 rounded-b-lg">
                    <div class="flex items-center justify-end space-x-3">
                        @if($cancelUrl)
                            <a 
                                href="{{ $cancelUrl }}" 
                                class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors {{ $cancelClass }}"
                            >
                                {{ $cancelText }}
                            </a>
                        @endif
                        
                        <button 
                            type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors {{ $submitClass }}"
                        >
                            {{ $submitText }}
                        </button>
                    </div>
                </div>
            @endif
        </form>
    </div>
</div>
