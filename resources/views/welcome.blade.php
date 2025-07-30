@php
    use App\Models\Post;
    
    // Get the featured post using the new scopes
    $featuredPost = Post::published()
        ->featured()
        ->with('user')
        ->latest()
        ->first();
    
    // Get recent posts (excluding the featured post if it exists) using scopes
    $recentPosts = Post::published()
        ->when($featuredPost, function($query) use ($featuredPost) {
            return $query->where('id', '!=', $featuredPost->id);
        })
        ->with('user')
        ->latest()
        ->limit(6)
        ->get();
@endphp

<x-layouts.app>
    <!-- Hero Section with Search -->
    <div class="bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 dark:text-white mb-6">
                    Welcome to <span class="text-primary-600 dark:text-primary-400">Basic CMS</span>
                </h1>
                <p class="text-xl text-gray-600 dark:text-gray-300 mb-8 max-w-3xl mx-auto">
                    Discover amazing content, stay updated with the latest posts, and explore our community-driven platform.
                </p>
                
                <!-- Search Bar -->
                <div class="max-w-2xl mx-auto">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input 
                            type="text" 
                            class="block w-full pl-10 pr-3 py-4 border border-gray-300 dark:border-gray-600 rounded-lg leading-5 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-lg"
                            placeholder="Search for posts, topics, or authors..."
                        >
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <button class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-md font-medium transition-colors duration-200">
                                Search
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if($featuredPost)
            <!-- Featured Post Section -->
            <section class="mb-16">
                <div class="flex items-center mb-8">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-featured-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Featured Post</h2>
                    </div>
                    <div class="flex-1 ml-6 border-t border-gray-200 dark:border-gray-700"></div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                    @if($featuredPost->featured_image)
                        <div class="relative h-64 md:h-80 lg:h-96">
                            <img 
                                src="{{ $featuredPost->featured_image }}" 
                                alt="{{ $featuredPost->featured_image_alt ?? $featuredPost->title }}"
                                class="w-full h-full object-cover"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                            <div class="absolute bottom-4 left-4 right-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-featured-100 text-featured-800 mb-3">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    Featured
                                </span>
                                <h3 class="text-2xl md:text-3xl font-bold text-white mb-2 leading-tight">
                                    {{ $featuredPost->title }}
                                </h3>
                            </div>
                        </div>
                    @endif
                    
                    <div class="p-6 md:p-8">
                        @if(!$featuredPost->featured_image)
                            <div class="mb-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-featured-100 text-featured-800 dark:bg-featured-900 dark:text-featured-200">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    Featured
                                </span>
                            </div>
                            <h3 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-4 leading-tight">
                                {{ $featuredPost->title }}
                            </h3>
                        @endif
                        
                        @if($featuredPost->excerpt)
                            <p class="text-lg text-gray-600 dark:text-gray-300 mb-6 leading-relaxed">
                                {{ $featuredPost->excerpt }}
                            </p>
                        @endif
                        
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4 text-sm text-gray-500 dark:text-gray-400">
                                @if($featuredPost->user)
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $featuredPost->user->name }}
                                    </span>
                                @endif
                                
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $featuredPost->formatted_date }}
                                </span>
                            </div>
                            
                            <a 
                                href="{{ $featuredPost->url }}" 
                                class="inline-flex items-center px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors duration-200"
                            >
                                Read Full Article
                                <svg class="w-5 h-5 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <!-- Recent Posts Section -->
        <section>
            <div class="flex items-center mb-8">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-primary-600 dark:text-primary-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Recent Posts</h2>
                </div>
                <div class="flex-1 ml-6 border-t border-gray-200 dark:border-gray-700"></div>
            </div>
            
            @if($recentPosts->count() > 0)
                <x-posts.post-grid 
                    :posts="$recentPosts" 
                    columns="3"
                    :showExcerpt="true"
                    :showMeta="true"
                    :showFeaturedImage="true"
                    :compact="false"
                />
                
                <div class="text-center mt-12">
                    <a 
                        href="#" 
                        class="inline-flex items-center px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-lg text-base font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200"
                    >
                        View All Posts
                        <svg class="w-5 h-5 ml-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </a>
                </div>
            @else
                <div class="text-center py-16">
                    <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">No posts available</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-8">Check back soon for new content!</p>
                </div>
            @endif
        </section>
    </div>
</x-layouts.app>
