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

                    <!-- Theme Colors Section -->
                    <section class="mb-16">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 border-b border-gray-200 dark:border-gray-700 pb-2">
                            Theme Colors
                        </h2>
                        <p class="text-gray-600 dark:text-gray-400 mb-6">
                            Our semantic color system uses meaningful names that make components reusable across different projects.
                        </p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Primary Colors -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Primary Colors</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Used for buttons, links, and interactive elements</p>
                                <div class="space-y-2">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-primary-400 rounded-lg shadow-sm"></div>
                                        <div class="text-sm">
                                            <div class="font-medium text-gray-900 dark:text-white">primary-400</div>
                                            <div class="text-gray-500 dark:text-gray-400">Light teal</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-primary-600 rounded-lg shadow-sm"></div>
                                        <div class="text-sm">
                                            <div class="font-medium text-gray-900 dark:text-white">primary-600</div>
                                            <div class="text-gray-500 dark:text-gray-400">Main teal</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-primary-700 rounded-lg shadow-sm"></div>
                                        <div class="text-sm">
                                            <div class="font-medium text-gray-900 dark:text-white">primary-700</div>
                                            <div class="text-gray-500 dark:text-gray-400">Dark teal</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Accent Colors -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Accent Colors</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Used for highlights and subtle emphasis</p>
                                <div class="space-y-2">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-accent-50 border border-gray-200 rounded-lg shadow-sm"></div>
                                        <div class="text-sm">
                                            <div class="font-medium text-gray-900 dark:text-white">accent-50</div>
                                            <div class="text-gray-500 dark:text-gray-400">Light backgrounds</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-accent-100 rounded-lg shadow-sm"></div>
                                        <div class="text-sm">
                                            <div class="font-medium text-gray-900 dark:text-white">accent-100</div>
                                            <div class="text-gray-500 dark:text-gray-400">Subtle highlights</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-accent-800 rounded-lg shadow-sm"></div>
                                        <div class="text-sm">
                                            <div class="font-medium text-gray-900 dark:text-white">accent-800</div>
                                            <div class="text-gray-500 dark:text-gray-400">Dark mode highlights</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Featured Colors -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Featured Colors</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Used for special content and badges</p>
                                <div class="space-y-2">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-featured-200 rounded-lg shadow-sm"></div>
                                        <div class="text-sm">
                                            <div class="font-medium text-gray-900 dark:text-white">featured-200</div>
                                            <div class="text-gray-500 dark:text-gray-400">Light yellow</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-featured-500 rounded-lg shadow-sm"></div>
                                        <div class="text-sm">
                                            <div class="font-medium text-gray-900 dark:text-white">featured-500</div>
                                            <div class="text-gray-500 dark:text-gray-400">Main yellow</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-featured-600 rounded-lg shadow-sm"></div>
                                        <div class="text-sm">
                                            <div class="font-medium text-gray-900 dark:text-white">featured-600</div>
                                            <div class="text-gray-500 dark:text-gray-400">Dark yellow</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Color Usage Examples -->
                        <div class="mt-8 p-6 bg-gray-50 dark:bg-gray-900 rounded-lg">
                            <h4 class="text-md font-semibold text-gray-900 dark:text-white mb-4">Usage Examples</h4>
                            <div class="flex flex-wrap gap-3">
                                <button class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors">
                                    Primary Button
                                </button>
                                <button class="px-4 py-2 bg-accent-100 hover:bg-accent-200 text-accent-800 font-medium rounded-lg transition-colors">
                                    Accent Button
                                </button>
                                <span class="inline-flex items-center px-3 py-1 bg-featured-200 text-featured-800 text-sm font-medium rounded-full">
                                    Featured Badge
                                </span>
                                <div class="px-3 py-2 bg-primary-50 border border-primary-200 text-primary-700 text-sm rounded-lg">
                                    Info Panel
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Form Components Section -->
                    <div class="space-y-16">

                        <!-- Text Input -->
                        <section>
                            <h2
                                class="text-2xl font-bold text-gray-900 dark:text-white mb-6 border-b border-gray-200 dark:border-gray-700 pb-2">
                                Text Input
                            </h2>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                <div>
                                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Examples
                                    </h3>

                                    <x-forms.inputs.text-input name="example_text" label="Basic Text Input"
                                        placeholder="Enter some text" helpText="This is a basic text input field" />

                                    <x-forms.inputs.text-input name="required_text" label="Required Field"
                                        placeholder="This field is required" required />

                                    <x-forms.inputs.text-input name="error_text" label="Field with Error"
                                        placeholder="This field has an error"
                                        error="This field is required and cannot be empty" />

                                    <x-forms.inputs.text-input name="disabled_text" label="Disabled Field"
                                        placeholder="This field is disabled" disabled value="Cannot edit this" />
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Usage</h3>
                                    <pre class="bg-gray-100 dark:bg-gray-900 p-4 rounded-lg text-sm overflow-x-auto"><code class="text-gray-900 dark:text-white">&lt;x-forms.inputs.text-input 
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
                            <h2
                                class="text-2xl font-bold text-gray-900 dark:text-white mb-6 border-b border-gray-200 dark:border-gray-700 pb-2">
                                Textarea
                            </h2>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                <div>
                                    <x-forms.inputs.textarea name="example_textarea" label="Content Area"
                                        placeholder="Write your content here..." rows="4"
                                        helpText="Use this for longer text content" />

                                    <x-forms.inputs.textarea name="large_textarea" label="Large Textarea"
                                        placeholder="Large text area..." rows="8" />
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Usage</h3>
                                    <pre class="bg-gray-100 dark:bg-gray-900 p-4 rounded-lg text-sm overflow-x-auto"><code class="text-gray-900 dark:text-white">&lt;x-forms.inputs.textarea 
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
                            <h2
                                class="text-2xl font-bold text-gray-900 dark:text-white mb-6 border-b border-gray-200 dark:border-gray-700 pb-2">
                                Select Dropdown
                            </h2>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                <div>
                                    <x-forms.inputs.select name="example_select" label="Post Status" :options="[
                                        'draft' => 'Draft',
                                        'published' => 'Published',
                                        'archived' => 'Archived',
                                    ]"
                                        placeholder="Choose status" helpText="Select the current status of the post" />

                                    <x-forms.inputs.select name="category_select" label="Category" :options="['tech' => 'Technology', 'design' => 'Design', 'business' => 'Business']"
                                        required />
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Usage</h3>
                                    <pre class="bg-gray-100 dark:bg-gray-900 p-4 rounded-lg text-sm overflow-x-auto"><code class="text-gray-900 dark:text-white">&lt;x-forms.inputs.select 
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
                            <h2
                                class="text-2xl font-bold text-gray-900 dark:text-white mb-6 border-b border-gray-200 dark:border-gray-700 pb-2">
                                Checkbox
                            </h2>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                <div>
                                    <x-forms.inputs.checkbox name="example_checkbox" label="Featured Post"
                                        helpText="Mark this post as featured on the homepage" />

                                    <x-forms.inputs.checkbox name="checked_checkbox" label="Pre-checked Option" checked
                                        helpText="This checkbox is checked by default" />

                                    <x-forms.inputs.checkbox name="required_checkbox" label="Terms and Conditions"
                                        required helpText="You must agree to the terms" />
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Usage</h3>
                                    <pre class="bg-gray-100 dark:bg-gray-900 p-4 rounded-lg text-sm overflow-x-auto"><code class="text-gray-900 dark:text-white">&lt;x-forms.inputs.checkbox 
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
                            <h2
                                class="text-2xl font-bold text-gray-900 dark:text-white mb-6 border-b border-gray-200 dark:border-gray-700 pb-2">
                                Radio Group
                            </h2>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                <div>
                                    <x-forms.inputs.radio-group name="example_radio" label="Content Type"
                                        :options="['article' => 'Article', 'tutorial' => 'Tutorial', 'news' => 'News']" helpText="Select the type of content you're creating" />

                                    <x-forms.inputs.radio-group name="priority_radio" label="Priority Level"
                                        :options="['low' => 'Low', 'medium' => 'Medium', 'high' => 'High']" required />
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Usage</h3>
                                    <pre class="bg-gray-100 dark:bg-gray-900 p-4 rounded-lg text-sm overflow-x-auto"><code class="text-gray-900 dark:text-white">&lt;x-forms.inputs.radio-group 
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
                            <h2
                                class="text-2xl font-bold text-gray-900 dark:text-white mb-6 border-b border-gray-200 dark:border-gray-700 pb-2">
                                File Input
                            </h2>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                <div>
                                    <x-forms.inputs.file-input name="example_file" label="Featured Image"
                                        accept="image/*" helpText="Upload a featured image for your post" />

                                    <x-forms.inputs.file-input name="document_file" label="Document Upload"
                                        accept=".pdf,.doc,.docx" helpText="Upload PDF or Word documents" />
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Usage</h3>
                                    <pre class="bg-gray-100 dark:bg-gray-900 p-4 rounded-lg text-sm overflow-x-auto"><code class="text-gray-900 dark:text-white">&lt;x-forms.inputs.file-input 
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
                            <h2
                                class="text-2xl font-bold text-gray-900 dark:text-white mb-6 border-b border-gray-200 dark:border-gray-700 pb-2">
                                Number Input
                            </h2>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                <div>
                                    <x-forms.inputs.number-input name="example_number" label="Order Number"
                                        placeholder="Enter a number" min="1" max="100"
                                        helpText="Enter a number between 1 and 100" />

                                    <x-forms.inputs.number-input name="price_number" label="Price"
                                        placeholder="0.00" min="0" step="0.01"
                                        helpText="Enter price with decimal places" />
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Usage</h3>
                                    <pre class="bg-gray-100 dark:bg-gray-900 p-4 rounded-lg text-sm overflow-x-auto"><code class="text-gray-900 dark:text-white">&lt;x-forms.inputs.number-input 
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
                            <h2
                                class="text-2xl font-bold text-gray-900 dark:text-white mb-6 border-b border-gray-200 dark:border-gray-700 pb-2">
                                Date Input
                            </h2>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                <div>
                                    <x-forms.inputs.date-input name="example_date" label="Publication Date"
                                        helpText="When should this post be published?" />

                                    <x-forms.inputs.date-input name="required_date" label="Event Date" required
                                        helpText="Select the event date" />
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Usage</h3>
                                    <pre class="bg-gray-100 dark:bg-gray-900 p-4 rounded-lg text-sm overflow-x-auto"><code class="text-gray-900 dark:text-white">&lt;x-forms.inputs.date-input 
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
                            <h2
                                class="text-2xl font-bold text-gray-900 dark:text-white mb-6 border-b border-gray-200 dark:border-gray-700 pb-2">
                                Email Input
                            </h2>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                <div>
                                    <x-forms.inputs.email-input name="example_email" label="Email Address"
                                        placeholder="user@example.com" helpText="Enter a valid email address" />

                                    <x-forms.inputs.email-input name="required_email" label="Contact Email"
                                        placeholder="contact@company.com" required />
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Usage</h3>
                                    <pre class="bg-gray-100 dark:bg-gray-900 p-4 rounded-lg text-sm overflow-x-auto"><code class="text-gray-900 dark:text-white">&lt;x-forms.inputs.email-input 
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
                            <h2
                                class="text-2xl font-bold text-gray-900 dark:text-white mb-6 border-b border-gray-200 dark:border-gray-700 pb-2">
                                Password Input
                            </h2>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                <div>
                                    <x-forms.inputs.password-input name="example_password" label="Password"
                                        placeholder="Enter your password"
                                        helpText="Password must be at least 8 characters" />

                                    <x-forms.inputs.password-input name="no_toggle_password"
                                        label="Password (No Toggle)" placeholder="Enter password" :showToggle="false"
                                        helpText="This password field has no show/hide toggle" />
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Usage</h3>
                                    <pre class="bg-gray-100 dark:bg-gray-900 p-4 rounded-lg text-sm overflow-x-auto"><code class="text-gray-900 dark:text-white">&lt;x-forms.inputs.password-input 
    name="password" 
    label="Password"
    placeholder="Enter password"
    required
    :showToggle="true"
/&gt;</code></pre>
                                </div>
                            </div>
                        </section>

                        <!-- WYSIWYG Editor -->
                        <section>
                            <h2
                                class="text-2xl font-bold text-gray-900 dark:text-white mb-6 border-b border-gray-200 dark:border-gray-700 pb-2">
                                WYSIWYG Editor
                            </h2>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                <div>
                                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Examples
                                    </h3>

                                    <x-forms.inputs.wysiwyg-editor name="example_wysiwyg" label="Post Content"
                                        placeholder="Write your content here..."
                                        helpText="Use the toolbar to format your content" toolbar="full"
                                        height="300px">
                                        <p>You can start with some <strong>initial content</strong> here!</p>
                                    </x-forms.inputs.wysiwyg-editor>

                                    <x-forms.inputs.wysiwyg-editor name="basic_wysiwyg" label="Basic Editor"
                                        placeholder="Simple editing..." toolbar="basic" height="200px"
                                        helpText="This editor has basic formatting options only" />

                                    <x-forms.inputs.wysiwyg-editor name="required_wysiwyg" label="Required Content"
                                        placeholder="This field is required" required height="250px" />
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Usage</h3>
                                    <pre class="bg-gray-100 dark:bg-gray-900 p-4 rounded-lg text-sm overflow-x-auto"><code class="text-gray-900 dark:text-white">&lt;x-forms.inputs.wysiwyg-editor 
    name="content" 
    label="Post Content" 
    placeholder="Write your content..."
    toolbar="full"
    height="300px"
    required
    :error="$errors->first('content')"
&gt;
    {{ old('content') }}
&lt;/x-forms.inputs.wysiwyg-editor&gt;</code></pre>

                                    <div class="mt-4">
                                        <h4 class="text-md font-medium mb-2 text-gray-700 dark:text-gray-300">Toolbar
                                            Options</h4>
                                        <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                                            <li><code>toolbar="full"</code> - All formatting options</li>
                                            <li><code>toolbar="basic"</code> - Essential formatting only</li>
                                            <li><code>toolbar="[...]"</code> - Custom toolbar array</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- Form Container -->
                        <section>
                            <h2
                                class="text-2xl font-bold text-gray-900 dark:text-white mb-6 border-b border-gray-200 dark:border-gray-700 pb-2">
                                Form Container
                            </h2>
                            <div class="space-y-8">

                                <!-- Simple Form Example -->
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                    <div>
                                        <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Simple
                                            Form (Title Only)</h3>
                                        <x-forms.form action="#" method="POST" title="Login" :showButtons="false">
                                            <x-forms.inputs.email-input name="demo_email" label="Email"
                                                placeholder="Enter your email" />

                                            <x-forms.inputs.password-input name="demo_password" label="Password"
                                                placeholder="Enter your password" :showToggle="true" />

                                            <div class="flex justify-end">
                                                <button type="submit"
                                                    class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                                    Login
                                                </button>
                                            </div>
                                        </x-forms.form>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Usage
                                        </h3>
                                        <pre class="bg-gray-100 dark:bg-gray-900 p-4 rounded-lg text-sm overflow-x-auto"><code class="text-gray-900 dark:text-white">&lt;x-forms.form 
    action="{{ route('login') }}" 
    method="POST"
    title="Login"
    :showButtons="false"
&gt;
    &lt;!-- Form inputs here --&gt;
&lt;/x-forms.form&gt;</code></pre>
                                    </div>
                                </div>

                                <!-- Complex Form Example -->
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                    <div>
                                        <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Complex
                                            Form (Title + Description)</h3>
                                        <x-forms.form action="#" method="POST" title="Create Post"
                                            description="Fill out the form below to create a new blog post for your website."
                                            submitText="Create Post" cancelText="Cancel" cancelUrl="#">
                                            <x-forms.inputs.text-input name="demo_title" label="Title"
                                                placeholder="Enter post title" />

                                            <x-forms.inputs.select name="demo_status" label="Status"
                                                :options="['draft' => 'Draft', 'published' => 'Published']" />

                                            <x-forms.inputs.checkbox name="demo_featured" label="Featured Post" />
                                        </x-forms.form>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Usage
                                        </h3>
                                        <pre class="bg-gray-100 dark:bg-gray-900 p-4 rounded-lg text-sm overflow-x-auto"><code class="text-gray-900 dark:text-white">&lt;x-forms.form 
    action="{{ route('posts.store') }}" 
    method="POST"
    title="Create Post"
    description="Fill out the form below to create a new blog post."
    submitText="Create Post"
    cancelUrl="{{ route('posts.index') }}"
&gt;
    &lt;!-- Form inputs here --&gt;
&lt;/x-forms.form&gt;</code></pre>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- Post Components -->
                        <section>
                            <h2
                                class="text-2xl font-bold text-gray-900 dark:text-white mb-6 border-b border-gray-200 dark:border-gray-700 pb-2">
                                Post Components
                            </h2>

                            <!-- Post Card -->
                            <div class="mb-12">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Post Card</h3>
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                    <div>
                                        <h4 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">
                                            Examples</h4>

                                        @php
                                            $samplePost = (object) [
                                                'id' => 1,
                                                'title' => 'Getting Started with Laravel Components',
                                                'slug' => 'getting-started-with-laravel-components',
                                                'excerpt' =>
                                                    'Learn how to create reusable components in Laravel that will speed up your development process and keep your code clean.',
                                                'content' => '<p>This is the full content of the post...</p>',
                                                'status' => 'published',
                                                'is_featured' => true,
                                                'featured_image' =>
                                                    'https://images.unsplash.com/photo-1461749280684-dccba630e2f6?w=800&h=400&fit=crop',
                                                'featured_image_alt' => 'Code on computer screen',
                                                'published_at' => \Carbon\Carbon::now()->subDays(2),
                                                'created_at' => \Carbon\Carbon::now()->subDays(5),
                                                'updated_at' => \Carbon\Carbon::now()->subDays(1),
                                                'user' => (object) ['name' => 'John Doe'],
                                            ];
                                            $samplePost2 = (object) [
                                                'id' => 2,
                                                'title' => 'Building Modern Interfaces',
                                                'slug' => 'building-modern-interfaces',
                                                'excerpt' =>
                                                    'Tips and techniques for creating beautiful, responsive user interfaces.',
                                                'content' => '<p>This is the full content...</p>',
                                                'status' => 'draft',
                                                'is_featured' => false,
                                                'featured_image' => null,
                                                'featured_image_alt' => null,
                                                'published_at' => null,
                                                'created_at' => \Carbon\Carbon::now()->subDays(1),
                                                'updated_at' => \Carbon\Carbon::now()->subDays(1),
                                                'user' => (object) ['name' => 'Jane Smith'],
                                            ];
                                        @endphp

                                        <div class="space-y-6">
                                            <div>
                                                <h5 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                    Regular Post Card</h5>
                                                <x-posts.post-card :post="$samplePost" />
                                            </div>

                                            <div>
                                                <h5 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                    Compact Post Card</h5>
                                                <x-posts.post-card :post="$samplePost2" :compact="true" />
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Usage
                                        </h4>
                                        <pre class="bg-gray-100 dark:bg-gray-900 p-4 rounded-lg text-sm overflow-x-auto"><code class="text-gray-900 dark:text-white">&lt;x-posts.post-card 
    :post="$post"
    :showExcerpt="true"
    :showMeta="true" 
    :showFeaturedImage="true"
    :compact="false"
/&gt;</code></pre>

                                        <div class="mt-4">
                                            <h5 class="text-md font-medium mb-2 text-gray-700 dark:text-gray-300">
                                                Properties</h5>
                                            <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                                                <li><code>post</code> - The post object (required)</li>
                                                <li><code>showExcerpt</code> - Show post excerpt (default: true)</li>
                                                <li><code>showMeta</code> - Show meta information (default: true)</li>
                                                <li><code>showFeaturedImage</code> - Show featured image (default: true)
                                                </li>
                                                <li><code>compact</code> - Use compact layout (default: false)</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Post Grid -->
                            <div class="mb-12">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Post Grid</h3>
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                    <div>
                                        <h4 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Example
                                        </h4>

                                        @php
                                            $samplePosts = collect([$samplePost, $samplePost2]);
                                        @endphp

                                        <x-posts.post-grid :posts="$samplePosts" columns="2" :compact="true" />
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Usage
                                        </h4>
                                        <pre class="bg-gray-100 dark:bg-gray-900 p-4 rounded-lg text-sm overflow-x-auto"><code class="text-gray-900 dark:text-white">&lt;x-posts.post-grid 
    :posts="$posts"
    columns="3"
    :showExcerpt="true"
    :showMeta="true"
    :compact="false"
/&gt;</code></pre>

                                        <div class="mt-4">
                                            <h5 class="text-md font-medium mb-2 text-gray-700 dark:text-gray-300">
                                                Properties</h5>
                                            <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                                                <li><code>posts</code> - Collection of posts (required)</li>
                                                <li><code>columns</code> - Grid columns: 'auto', '1', '2', '3', '4'
                                                    (default: 'auto')</li>
                                                <li><code>showExcerpt</code> - Show excerpts (default: true)</li>
                                                <li><code>showMeta</code> - Show meta info (default: true)</li>
                                                <li><code>showFeaturedImage</code> - Show images (default: true)</li>
                                                <li><code>compact</code> - Use compact cards (default: false)</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Full Post Display -->
                            <div class="mb-12">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Full Post Display
                                </h3>
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                    <div>
                                        <h4 class="text-lg font-semibsemibold mb-4 text-gray-800 dark:text-gray-200">
                                            Preview</h4>
                                        <div
                                            class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 bg-gray-50 dark:bg-gray-900">
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Full post
                                                component preview:</p>
                                            <div class="text-xs text-gray-500 dark:text-gray-500">
                                                <code>&lt;x-posts.post-full :post="$post" /&gt;</code>
                                            </div>
                                            <p class="text-xs text-gray-500 dark:text-gray-500 mt-2">
                                                (Too large to display here - see usage example)
                                            </p>
                                        </div>
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Usage
                                        </h4>
                                        <pre class="bg-gray-100 dark:bg-gray-900 p-4 rounded-lg text-sm overflow-x-auto"><code class="text-gray-900 dark:text-white">&lt;x-posts.post-full 
    :post="$post"
    :showMeta="true"
    :showActions="false"
/&gt;</code></pre>

                                        <div class="mt-4">
                                            <h5 class="text-md font-medium mb-2 text-gray-700 dark:text-gray-300">
                                                Properties</h5>
                                            <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                                                <li><code>post</code> - The post object (required)</li>
                                                <li><code>showMeta</code> - Show meta information (default: true)</li>
                                                <li><code>showActions</code> - Show edit/delete actions (default: false)
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="mt-4">
                                            <h5 class="text-md font-medium mb-2 text-gray-700 dark:text-gray-300">
                                                Features</h5>
                                            <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                                                <li>• Full-width featured image</li>
                                                <li>• Status and featured badges</li>
                                                <li>• Rich content with Tailwind Typography</li>
                                                <li>• Optional edit/delete actions</li>
                                                <li>• SEO meta information display</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- Theme Toggle -->
                        <section>
                            <h2
                                class="text-2xl font-bold text-gray-900 dark:text-white mb-6 border-b border-gray-200 dark:border-gray-700 pb-2">
                                Theme Toggle
                            </h2>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                <div>
                                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Examples
                                    </h3>

                                    <div class="space-y-6">
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">
                                                Default Size</h4>
                                            <x-settings.theme-toggle />
                                        </div>

                                        <div>
                                            <h4 class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">Small
                                                Size</h4>
                                            <x-settings.theme-toggle size="small" />
                                        </div>

                                        <div>
                                            <h4 class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">Large
                                                Size</h4>
                                            <x-settings.theme-toggle size="large" />
                                        </div>

                                        <div>
                                            <h4 class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">With
                                                Label</h4>
                                            <x-settings.theme-toggle :showLabel="true" />
                                        </div>

                                        <div>
                                            <h4 class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">Large
                                                with Label</h4>
                                            <x-settings.theme-toggle size="large" :showLabel="true" />
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Usage</h3>
                                    <pre class="bg-gray-100 dark:bg-gray-900 p-4 rounded-lg text-sm overflow-x-auto"><code class="text-gray-900 dark:text-white">&lt;!-- Basic toggle --&gt;
&lt;x-settings.theme-toggle /&gt;

&lt;!-- Small size --&gt;
&lt;x-settings.theme-toggle size="small" /&gt;

&lt;!-- Large with label --&gt;
&lt;x-settings.theme-toggle 
    size="large" 
    :showLabel="true" 
/&gt;</code></pre>

                                    <div class="mt-4">
                                        <h5 class="text-md font-medium mb-2 text-gray-700 dark:text-gray-300">
                                            Properties</h5>
                                        <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                                            <li><code>size</code> - Toggle size: 'small', 'default', 'large' (default:
                                                'default')</li>
                                            <li><code>showLabel</code> - Show theme label text (default: false)</li>
                                        </ul>
                                    </div>

                                    <div class="mt-4">
                                        <h5 class="text-md font-medium mb-2 text-gray-700 dark:text-gray-300">Features
                                        </h5>
                                        <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                                            <li>• Persists theme preference in localStorage</li>
                                            <li>• Respects system theme preference</li>
                                            <li>• Smooth animations and transitions</li>
                                            <li>• Accessibility support (ARIA labels)</li>
                                            <li>• Custom event dispatching for other components</li>
                                            <li>• Focus ring for keyboard navigation</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </section>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
