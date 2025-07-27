<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Component Library
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    
                    <!-- Introduction -->
                    <div class="mb-12">
                        <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                            CMS Component Library
                        </h1>
                        <p class="text-lg text-gray-600 dark:text-gray-400">
                            A showcase of all available form components and UI elements for the CMS.
                        </p>
                    </div>

                    <!-- Form Components Section -->
                    <div class="space-y-16">
                        
                        <!-- Text Input -->
                        <section>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 border-b border-gray-200 dark:border-gray-700 pb-2">
                                Text Input
                            </h2>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                <div>
                                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Examples</h3>
                                    
                                    <x-forms.text-input 
                                        name="example_text" 
                                        label="Basic Text Input" 
                                        placeholder="Enter some text"
                                        helpText="This is a basic text input field"
                                    />
                                    
                                    <x-forms.text-input 
                                        name="required_text" 
                                        label="Required Field" 
                                        placeholder="This field is required"
                                        required
                                    />
                                    
                                    <x-forms.text-input 
                                        name="error_text" 
                                        label="Field with Error" 
                                        placeholder="This field has an error"
                                        error="This field is required and cannot be empty"
                                    />
                                    
                                    <x-forms.text-input 
                                        name="disabled_text" 
                                        label="Disabled Field" 
                                        placeholder="This field is disabled"
                                        disabled
                                        value="Cannot edit this"
                                    />
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Usage</h3>
                                    <pre class="bg-gray-100 dark:bg-gray-900 p-4 rounded-lg text-sm overflow-x-auto"><code class="text-gray-900 dark:text-white">&lt;x-forms.text-input 
    name="title" 
    label="Post Title" 
    placeholder="Enter post title"
    required
    :error="$errors->first('title')"
    helpText="This will be the main heading"
/&gt;</code></pre>
                                </div>
                            </div>
                        </section>

                        <!-- Textarea -->
                        <section>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 border-b border-gray-200 dark:border-gray-700 pb-2">
                                Textarea
                            </h2>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                <div>
                                    <x-forms.textarea 
                                        name="example_textarea" 
                                        label="Content Area" 
                                        placeholder="Write your content here..."
                                        rows="4"
                                        helpText="Use this for longer text content"
                                    />
                                    
                                    <x-forms.textarea 
                                        name="large_textarea" 
                                        label="Large Textarea" 
                                        placeholder="Large text area..."
                                        rows="8"
                                    />
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Usage</h3>
                                    <pre class="bg-gray-100 dark:bg-gray-900 p-4 rounded-lg text-sm overflow-x-auto"><code class="text-gray-900 dark:text-white">&lt;x-forms.textarea 
    name="content" 
    label="Post Content" 
    rows="8"
    required
    :error="$errors->first('content')"
/&gt;</code></pre>
                                </div>
                            </div>
                        </section>

                        <!-- Select -->
                        <section>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 border-b border-gray-200 dark:border-gray-700 pb-2">
                                Select Dropdown
                            </h2>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                <div>
                                    <x-forms.select 
                                        name="example_select" 
                                        label="Post Status"
                                        :options="['draft' => 'Draft', 'published' => 'Published', 'archived' => 'Archived']"
                                        placeholder="Choose status"
                                        helpText="Select the current status of the post"
                                    />
                                    
                                    <x-forms.select 
                                        name="category_select" 
                                        label="Category"
                                        :options="['tech' => 'Technology', 'design' => 'Design', 'business' => 'Business']"
                                        required
                                    />
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Usage</h3>
                                    <pre class="bg-gray-100 dark:bg-gray-900 p-4 rounded-lg text-sm overflow-x-auto"><code class="text-gray-900 dark:text-white">&lt;x-forms.select 
    name="status" 
    label="Status"
    :options="['draft' => 'Draft', 'published' => 'Published']"
    placeholder="Choose status"
    required
/&gt;</code></pre>
                                </div>
                            </div>
                        </section>

                        <!-- Checkbox -->
                        <section>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 border-b border-gray-200 dark:border-gray-700 pb-2">
                                Checkbox
                            </h2>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                <div>
                                    <x-forms.checkbox 
                                        name="example_checkbox" 
                                        label="Featured Post"
                                        helpText="Mark this post as featured on the homepage"
                                    />
                                    
                                    <x-forms.checkbox 
                                        name="checked_checkbox" 
                                        label="Pre-checked Option"
                                        checked
                                        helpText="This checkbox is checked by default"
                                    />
                                    
                                    <x-forms.checkbox 
                                        name="required_checkbox" 
                                        label="Terms and Conditions"
                                        required
                                        helpText="You must agree to the terms"
                                    />
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Usage</h3>
                                    <pre class="bg-gray-100 dark:bg-gray-900 p-4 rounded-lg text-sm overflow-x-auto"><code class="text-gray-900 dark:text-white">&lt;x-forms.checkbox 
    name="is_featured" 
    label="Featured Post"
    helpText="Mark as featured"
    :checked="old('is_featured')"
/&gt;</code></pre>
                                </div>
                            </div>
                        </section>

                        <!-- Radio Group -->
                        <section>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 border-b border-gray-200 dark:border-gray-700 pb-2">
                                Radio Group
                            </h2>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                <div>
                                    <x-forms.radio-group 
                                        name="example_radio" 
                                        label="Content Type"
                                        :options="['article' => 'Article', 'tutorial' => 'Tutorial', 'news' => 'News']"
                                        helpText="Select the type of content you're creating"
                                    />
                                    
                                    <x-forms.radio-group 
                                        name="priority_radio" 
                                        label="Priority Level"
                                        :options="['low' => 'Low', 'medium' => 'Medium', 'high' => 'High']"
                                        required
                                    />
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Usage</h3>
                                    <pre class="bg-gray-100 dark:bg-gray-900 p-4 rounded-lg text-sm overflow-x-auto"><code class="text-gray-900 dark:text-white">&lt;x-forms.radio-group 
    name="type" 
    label="Content Type"
    :options="['article' => 'Article', 'tutorial' => 'Tutorial']"
    required
/&gt;</code></pre>
                                </div>
                            </div>
                        </section>

                        <!-- File Input -->
                        <section>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 border-b border-gray-200 dark:border-gray-700 pb-2">
                                File Input
                            </h2>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                <div>
                                    <x-forms.file-input 
                                        name="example_file" 
                                        label="Featured Image"
                                        accept="image/*"
                                        helpText="Upload a featured image for your post"
                                    />
                                    
                                    <x-forms.file-input 
                                        name="document_file" 
                                        label="Document Upload"
                                        accept=".pdf,.doc,.docx"
                                        helpText="Upload PDF or Word documents"
                                    />
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Usage</h3>
                                    <pre class="bg-gray-100 dark:bg-gray-900 p-4 rounded-lg text-sm overflow-x-auto"><code class="text-gray-900 dark:text-white">&lt;x-forms.file-input 
    name="featured_image" 
    label="Featured Image"
    accept="image/*"
    helpText="Upload an image file"
/&gt;</code></pre>
                                </div>
                            </div>
                        </section>

                        <!-- Number Input -->
                        <section>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 border-b border-gray-200 dark:border-gray-700 pb-2">
                                Number Input
                            </h2>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                <div>
                                    <x-forms.number-input 
                                        name="example_number" 
                                        label="Order Number"
                                        placeholder="Enter a number"
                                        min="1"
                                        max="100"
                                        helpText="Enter a number between 1 and 100"
                                    />
                                    
                                    <x-forms.number-input 
                                        name="price_number" 
                                        label="Price"
                                        placeholder="0.00"
                                        min="0"
                                        step="0.01"
                                        helpText="Enter price with decimal places"
                                    />
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Usage</h3>
                                    <pre class="bg-gray-100 dark:bg-gray-900 p-4 rounded-lg text-sm overflow-x-auto"><code class="text-gray-900 dark:text-white">&lt;x-forms.number-input 
    name="price" 
    label="Price"
    min="0"
    step="0.01"
    required
/&gt;</code></pre>
                                </div>
                            </div>
                        </section>

                        <!-- Date Input -->
                        <section>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 border-b border-gray-200 dark:border-gray-700 pb-2">
                                Date Input
                            </h2>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                <div>
                                    <x-forms.date-input 
                                        name="example_date" 
                                        label="Publication Date"
                                        helpText="When should this post be published?"
                                    />
                                    
                                    <x-forms.date-input 
                                        name="required_date" 
                                        label="Event Date"
                                        required
                                        helpText="Select the event date"
                                    />
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Usage</h3>
                                    <pre class="bg-gray-100 dark:bg-gray-900 p-4 rounded-lg text-sm overflow-x-auto"><code class="text-gray-900 dark:text-white">&lt;x-forms.date-input 
    name="published_at" 
    label="Publication Date"
    :value="old('published_at')"
    required
/&gt;</code></pre>
                                </div>
                            </div>
                        </section>

                        <!-- Email Input -->
                        <section>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 border-b border-gray-200 dark:border-gray-700 pb-2">
                                Email Input
                            </h2>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                <div>
                                    <x-forms.email-input 
                                        name="example_email" 
                                        label="Email Address"
                                        placeholder="user@example.com"
                                        helpText="Enter a valid email address"
                                    />
                                    
                                    <x-forms.email-input 
                                        name="required_email" 
                                        label="Contact Email"
                                        placeholder="contact@company.com"
                                        required
                                    />
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Usage</h3>
                                    <pre class="bg-gray-100 dark:bg-gray-900 p-4 rounded-lg text-sm overflow-x-auto"><code class="text-gray-900 dark:text-white">&lt;x-forms.email-input 
    name="email" 
    label="Email Address"
    placeholder="user@example.com"
    required
/&gt;</code></pre>
                                </div>
                            </div>
                        </section>

                        <!-- Password Input -->
                        <section>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 border-b border-gray-200 dark:border-gray-700 pb-2">
                                Password Input
                            </h2>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                <div>
                                    <x-forms.password-input 
                                        name="example_password" 
                                        label="Password"
                                        placeholder="Enter your password"
                                        helpText="Password must be at least 8 characters"
                                    />
                                    
                                    <x-forms.password-input 
                                        name="no_toggle_password" 
                                        label="Password (No Toggle)"
                                        placeholder="Enter password"
                                        :showToggle="false"
                                        helpText="This password field has no show/hide toggle"
                                    />
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Usage</h3>
                                    <pre class="bg-gray-100 dark:bg-gray-900 p-4 rounded-lg text-sm overflow-x-auto"><code class="text-gray-900 dark:text-white">&lt;x-forms.password-input 
    name="password" 
    label="Password"
    placeholder="Enter password"
    required
    :showToggle="true"
/&gt;</code></pre>
                                </div>
                            </div>
                        </section>

                        <!-- Form Container -->
                        <section>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 border-b border-gray-200 dark:border-gray-700 pb-2">
                                Form Container
                            </h2>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                <div>
                                    <x-forms.form 
                                        action="#"
                                        method="POST"
                                        title="Example Form"
                                        description="This is an example of the form container component."
                                        submitText="Save Changes"
                                        cancelText="Cancel"
                                        cancelUrl="#"
                                    >
                                        <x-forms.text-input 
                                            name="demo_title" 
                                            label="Title" 
                                            placeholder="Enter title"
                                        />
                                        
                                        <x-forms.select 
                                            name="demo_status" 
                                            label="Status"
                                            :options="['draft' => 'Draft', 'published' => 'Published']"
                                        />
                                        
                                        <x-forms.checkbox 
                                            name="demo_featured" 
                                            label="Featured"
                                        />
                                    </x-forms.form>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Usage</h3>
                                    <pre class="bg-gray-100 dark:bg-gray-900 p-4 rounded-lg text-sm overflow-x-auto"><code class="text-gray-900 dark:text-white">&lt;x-forms.form 
    action="{{ route('posts.store') }}" 
    method="POST"
    title="Create Post"
    submitText="Create Post"
    cancelUrl="{{ route('posts.index') }}"
&gt;
    &lt;!-- Form inputs here --&gt;
&lt;/x-forms.form&gt;</code></pre>
                                </div>
                            </div>
                        </section>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
