<x-app-layout>
    @auth
        <x-forms.form
            action="{{ route('posts.store') }}"
            method="POST"
            title="Create a New Post"
            description="Fill out the form below to create a new blog post."
            submitText="Create Post"
            cancelText="Cancel"
            cancelUrl="{{ route('posts.index') }}"
        >
        <x-forms.inputs.text-input 
            name="title"
            label="Post Title" 
            placeholder="Enter post title..."
            required 
            :error="$errors->first('title')"
            :value="old('title')"
        />

        <x-forms.inputs.textarea 
            name="excerpt"
            label="Excerpt"
            placeholder="Brief description of the post (optional)..."
            rows="3"
            :error="$errors->first('excerpt')"
            helpText="This will be used as a preview of your post"
        >{{ old('excerpt') }}</x-forms.inputs.textarea>

        <x-forms.inputs.wysiwyg-editor 
            name="content"
            label="Post Content" 
            placeholder="Write your content..." 
            toolbar="full"
            height="400px" 
            required 
            :error="$errors->first('content')"
        >{{ old('content') }}</x-forms.inputs.wysiwyg-editor>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <x-forms.inputs.select 
                name="status"
                label="Status"
                :options="['draft' => 'Draft', 'published' => 'Published', 'archived' => 'Archived']"
                required
                :error="$errors->first('status')"
            />

            <x-forms.inputs.date-input 
                name="published_at"
                label="Publication Date"
                :error="$errors->first('published_at')"
                :value="old('published_at')"
                helpText="Leave empty to publish immediately"
            />
        </div>

        <x-forms.inputs.checkbox 
            name="is_featured"
            label="Featured Post"
            :checked="old('is_featured')"
            helpText="Mark this post as featured on the homepage"
        />

        <!-- SEO Section -->
        <div class="border-t border-gray-200 dark:border-gray-600 pt-6 mt-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">SEO Settings</h3>
            
            <x-forms.inputs.text-input 
                name="meta_title"
                label="Meta Title (Optional)"
                placeholder="SEO title for search engines..."
                :error="$errors->first('meta_title')"
                :value="old('meta_title')"
                helpText="If left blank, the post title will be used"
            />

            <x-forms.inputs.textarea 
                name="meta_description"
                label="Meta Description (Optional)"
                placeholder="SEO description for search engines..."
                rows="2"
                :error="$errors->first('meta_description')"
                helpText="Brief description for search engine results"
            >{{ old('meta_description') }}</x-forms.inputs.textarea>
        </div>

        <!-- Featured Image Section -->
        <div class="border-t border-gray-200 dark:border-gray-600 pt-6 mt-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Featured Image</h3>
            
            <x-forms.inputs.text-input 
                name="featured_image"
                label="Featured Image URL (Optional)"
                placeholder="https://example.com/image.jpg"
                :error="$errors->first('featured_image')"
                :value="old('featured_image')"
                helpText="URL of the featured image for this post"
            />

            <x-forms.inputs.text-input 
                name="featured_image_alt"
                label="Featured Image Alt Text (Optional)"
                placeholder="Description of the image..."
                :error="$errors->first('featured_image_alt')"
                :value="old('featured_image_alt')"
                helpText="Alternative text for accessibility"
            />
        </div>
    </x-forms.form>
    @else
        <div class="max-w-4xl mx-auto">
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <div class="text-center">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Login Required</h2>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">You must be logged in to create a post.</p>
                    <div class="space-x-4">
                        <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                            Register
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endauth
</x-app-layout>
