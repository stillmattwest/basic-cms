@props([
    'post',
    'showMeta' => true,
    'showActions' => false,
])

<article class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
    @if($post->featured_image)
        <div class="w-full h-64 md:h-80">
            <img 
                src="{{ $post->featured_image }}" 
                alt="{{ $post->featured_image_alt ?? $post->title }}"
                class="w-full h-full object-cover"
            >
        </div>
    @endif

    <div class="p-6 md:p-8">
        <!-- Status and Featured Badge -->
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center space-x-2">
                @if($post->is_featured)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-featured-100 text-featured-800 dark:bg-featured-900 dark:text-featured-200">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        Featured
                    </span>
                @endif

                @if($post->status !== 'published')
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ 
                        $post->status === 'draft' 
                            ? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' 
                            : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' 
                    }}">
                        {{ ucfirst($post->status) }}
                    </span>
                @endif
            </div>

            @if($showActions)
                <div class="flex items-center space-x-2">
                    <a 
                        href="{{ route('posts.edit', $post) }}" 
                        class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200"
                    >
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                        </svg>
                        Edit
                    </a>
                    
                    <form method="POST" action="{{ route('posts.destroy', $post) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button 
                            type="submit" 
                            onclick="return confirm('Are you sure you want to delete this post?')"
                            class="inline-flex items-center px-3 py-1.5 border border-red-300 dark:border-red-600 rounded-md text-sm font-medium text-red-700 dark:text-red-300 bg-white dark:bg-gray-700 hover:bg-red-50 dark:hover:bg-red-900 transition-colors duration-200"
                        >
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9zM4 5a2 2 0 012-2v1a1 1 0 001 1h6a1 1 0 001-1V3a2 2 0 012 2v6.5a1 1 0 01-.293.707l-6.414 6.414a1 1 0 01-1.414 0l-6.414-6.414A1 1 0 012 11.5V5z" clip-rule="evenodd"/>
                            </svg>
                            Delete
                        </button>
                    </form>
                </div>
            @endif
        </div>

        <!-- Title -->
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4 leading-tight">
            {{ $post->title }}
        </h1>

        <!-- Excerpt -->
        @if($post->excerpt)
            <p class="text-xl text-gray-600 dark:text-gray-300 mb-6 leading-relaxed italic">
                {{ $post->excerpt }}
            </p>
        @endif

        <!-- Meta Information -->
        @if($showMeta)
            <div class="flex items-center space-x-6 pb-6 mb-6 border-b border-gray-200 dark:border-gray-700 text-gray-500 dark:text-gray-400">
                @if($post->user)
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium">{{ $post->user->name }}</span>
                    </div>
                @endif
                
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                    </svg>
                    <span>Published {{ $post->published_at ? $post->published_at->format('F j, Y') : $post->created_at->format('F j, Y') }}</span>
                </div>

                @if($post->created_at !== $post->updated_at)
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"/>
                        </svg>
                        <span>Updated {{ $post->updated_at->format('F j, Y') }}</span>
                    </div>
                @endif
            </div>
        @endif

        <!-- Content -->
        <div class="prose prose-lg dark:prose-invert max-w-none text-gray-900 dark:text-white [&_img]:mb-4 [&_img]:mx-4">
            {!! $post->safe_content !!}
        </div>

        <!-- SEO Meta (if present) -->
        @if($post->meta_title || $post->meta_description)
            <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-3">SEO Information</h3>
                
                @if($post->meta_title)
                    <div class="mb-2">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Meta Title:</span>
                        <span class="text-sm text-gray-600 dark:text-gray-400 ml-2">{{ $post->meta_title }}</span>
                    </div>
                @endif
                
                @if($post->meta_description)
                    <div>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Meta Description:</span>
                        <span class="text-sm text-gray-600 dark:text-gray-400 ml-2">{{ $post->meta_description }}</span>
                    </div>
                @endif
            </div>
        @endif
    </div>
</article>
