@props([
    'post',
    'showExcerpt' => true,
    'showMeta' => true,
    'showFeaturedImage' => true,
    'compact' => false,
])

@php
    use Illuminate\Support\Str;
@endphp

<article class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-md transition-shadow duration-200 {{ $compact ? 'p-4' : 'p-6' }}">
    @if($showFeaturedImage && $post->featured_image)
        <div class="mb-4 {{ $compact ? '-mx-4 -mt-4' : '-mx-6 -mt-6' }} relative overflow-hidden rounded-t-lg">
            <div class="relative {{ $compact ? 'h-40' : 'h-56' }} bg-gray-100 dark:bg-gray-700">
                <img 
                    src="{{ $post->featured_image }}" 
                    alt="{{ $post->featured_image_alt ?? $post->title }}"
                    class="w-full h-full object-cover transition-transform duration-300 hover:scale-105"
                    loading="lazy"
                >
                <!-- Subtle gradient overlay for better text readability if needed -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent opacity-0 hover:opacity-100 transition-opacity duration-300"></div>
                
                <!-- Featured badge overlay if post is featured -->
                @if($post->is_featured)
                    <div class="absolute top-3 left-3">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-featured-100/90 text-featured-800 backdrop-blur-sm">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            Featured
                        </span>
                    </div>
                @endif
            </div>
        </div>
    @endif

    @if($post->is_featured && !($showFeaturedImage && $post->featured_image))
        <div class="mb-3">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-featured-100 text-featured-800 dark:bg-featured-900 dark:text-featured-200">
                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                Featured
            </span>
        </div>
    @endif

    <div class="flex items-start justify-between {{ $compact ? 'mb-2' : 'mb-4' }}">
        <h2 class="{{ $compact ? 'text-lg' : 'text-xl' }} font-bold text-gray-900 dark:text-white leading-tight">
            @if(isset($post->slug) && $post->slug)
                <a href="{{ route('posts.public.show', $post->slug) }}" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200">
                    {{ $post->title }}
                </a>
            @else
                <span class="text-gray-900 dark:text-white">{{ $post->title }}</span>
            @endif
        </h2>
        
        @if($post->status !== 'published')
            <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ 
                $post->status === 'draft' 
                    ? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' 
                    : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' 
            }}">
                {{ ucfirst($post->status) }}
            </span>
        @endif
    </div>

    @if($showExcerpt && $post->excerpt)
        <p class="text-gray-600 dark:text-gray-300 {{ $compact ? 'text-sm mb-3' : 'mb-4' }} leading-relaxed">
            {{ Str::limit($post->excerpt, $compact ? 80 : 150) }}
        </p>
    @endif

    @if($showMeta)
        <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
            <div class="flex items-center space-x-4">
                @if($post->user)
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                        {{ $post->user->name }}
                    </span>
                @endif
                
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                    </svg>
                    {{ $post->published_at ? $post->published_at->format('M j, Y') : $post->created_at->format('M j, Y') }}
                </span>
            </div>

            @if(isset($post->slug) && $post->slug)
                <a 
                    href="{{ route('posts.public.show', $post->slug) }}" 
                    class="inline-flex items-center text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300 font-medium transition-colors duration-200"
                >
                    Read more
                    <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                    </svg>
                </a>
            @else
                <span class="inline-flex items-center text-gray-400 dark:text-gray-500 font-medium">
                    Preview mode
                    <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </span>
            @endif
        </div>
    @endif
</article>
