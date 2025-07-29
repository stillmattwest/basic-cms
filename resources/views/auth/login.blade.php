<x-layouts.guest>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <x-forms.form 
        action="{{ route('login') }}" 
        method="POST"
        title="Login"
        :showButtons="false"
    >
        <!-- Email Address -->
        <x-forms.inputs.email-input 
            name="email" 
            label="Email"
            :value="old('email')"
            placeholder="Enter your email"
            required
            autofocus
            autocomplete="username"
            :error="$errors->get('email')"
        />

        <!-- Password -->
        <x-forms.inputs.password-input 
            name="password" 
            label="Password"
            placeholder="Enter your password"
            required
            autocomplete="current-password"
            :showToggle="true"
            :error="$errors->get('password')"
        />

        <!-- Remember Me -->
        <x-forms.inputs.checkbox 
            name="remember"
            label="Remember me"
            value="1"
            :checked="old('remember')"
        />

        <!-- Submit Button and Links -->
        <div class="flex items-center justify-between">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    Forgot your password?
                </a>
            @endif

            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                Log in
            </button>
            </button>
        </div>

        <!-- Register Link -->
        <div class="text-center">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800" href="{{ route('register') }}">
                Don't have an account? Register
            </a>
        </div>
    </x-forms.form>
</x-layouts.guest>
