@props([
    'posts',
    'columns' => 'auto', // 'auto', '1', '2', '3', '4'
    'showExcerpt' => true,
    'showMeta' => true,
    'showFeaturedImage' => true,
    'compact' => false,
])

@php
    $gridClasses = match($columns) {
        '1' => 'grid-cols-1',
        '2' => 'grid-cols-1 md:grid-cols-2',
        '3' => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3',
        '4' => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4',
        default => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3', // auto
    };
@endphp

<div class="grid {{ $gridClasses }} gap-6">
    @forelse($posts as $post)
        <x-posts.post-card 
            :post="$post"
            :showExcerpt="$showExcerpt"
            :showMeta="$showMeta"
            :showFeaturedImage="$showFeaturedImage"
            :compact="$compact"
        />
    @empty
        <div class="col-span-full">
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No posts found</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by creating a new post.</p>
                <div class="mt-6">
                    <a
                        href="{{ route('posts.create') }}"
                        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                    >
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                        </svg>
                        Create New Post
                    </a>
                </div>
            </div>
        </div>
    @endforelse
</div>
