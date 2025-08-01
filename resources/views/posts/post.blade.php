<x-layouts.app>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Main Post Content -->
        <x-posts.post-full 
            :post="$post" 
            :showMeta="true" 
            :showActions="auth()->check() && (auth()->id() === $post->user_id || auth()->user()->is_admin ?? false)"
        />

        <!-- Back to Posts -->
        <div class="mt-12 text-center">
            <a 
                href="{{ route('posts.index') }}" 
                class="inline-flex items-center px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-lg text-base font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200"
            >
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
                Back to All Posts
            </a>
        </div>
    </div>
</x-layouts.app>