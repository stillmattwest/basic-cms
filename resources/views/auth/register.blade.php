<x-layouts.guest>
    <x-forms.form 
        action="{{ route('register') }}" 
        method="POST"
        title="Register"
        :showButtons="false"
    >
        <!-- Name -->
        <x-forms.inputs.text-input 
            name="name" 
            label="Name"
            :value="old('name')"
            placeholder="Enter your full name"
            required
            autofocus
            autocomplete="name"
            :error="$errors->get('name')"
        />

        <!-- Email Address -->
        <x-forms.inputs.email-input 
            name="email" 
            label="Email"
            :value="old('email')"
            placeholder="Enter your email address"
            required
            autocomplete="username"
            :error="$errors->get('email')"
        />

        <!-- Password -->
        <x-forms.inputs.password-input 
            name="password" 
            label="Password"
            placeholder="Enter your password"
            required
            autocomplete="new-password"
            :showToggle="true"
            :error="$errors->get('password')"
        />

        <!-- Confirm Password -->
        <x-forms.inputs.password-input 
            name="password_confirmation" 
            label="Confirm Password"
            placeholder="Confirm your password"
            required
            autocomplete="new-password"
            :showToggle="true"
            :error="$errors->get('password_confirmation')"
        />

        <!-- Submit Button and Links -->
        <div class="flex items-center justify-between">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                Already registered?
            </a>

            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                Register
            </button>
        </div>
    </x-forms.form>
</x-layouts.guest>
