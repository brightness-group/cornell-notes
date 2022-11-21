<x-guest-layout>

    <x-auth-card>
        <x-slot name="logo">
            <a href="/" class="flex justify-center">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500"/>
            </a>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">{{ __('Sign Up for new account') }}</h2>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors"/>

        <form class="space-y-6" method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Name')"/>
                <div class="mt-1">
                    <x-input id="name"
                             class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                             type="name" name="name" :value="old('name')" required autofocus/>
                </div>
            </div>

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')"/>
                <div class="mt-1">
                    <x-input id="email"
                             class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                             autocomplete="email" type="email" name="email" :value="old('email')" required autofocus/>
                </div>
            </div>

            <!-- Password -->
            <div>
                <x-label for="password" :value="__('Password')"/>
                <div class="mt-1">
                    <x-input id="password"
                             class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                             type="password" name="password" required/>
                </div>
            </div>

            <!-- Confirm Password -->
            <div>
                <x-label for="password_confirmation" :value="__('Confirm Password')"/>
                <div class="mt-1">
                    <x-input id="password_confirmation"
                             class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                             type="password" name="password_confirmation" required/>
                </div>
            </div>
            <!-- Remember Me -->
            @if (Route::has('login'))
                <div class="flex items-center justify-between">
                    <div class="text-sm">
                        <a href="{{ route('login') }}"
                           class="font-medium text-indigo-600 hover:text-indigo-500">{{ __('Already registered?') }}</a>
                    </div>
                </div>
            @endif

            <div>
                <x-button
                    class="w-full flex justify-center shadow-sm text-sm font-medium focus:ring-2 focus:ring-offset-2">{{ __('Sign Up') }}</x-button>
            </div>
        </form>

        <div class="mt-6">
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500"> Or continue with </span>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <a href="{{ url('auth/facebook') }}"
                       class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <span class="sr-only">Sign in with Facebook</span>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path fill-rule="evenodd"
                                  d="M20 10c0-5.523-4.477-10-10-10S0 4.477 0 10c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V10h2.54V7.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V10h2.773l-.443 2.89h-2.33v6.988C16.343 19.128 20 14.991 20 10z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </a>
                </div>

                <div>
                    <a href="{{ url('auth/google') }}"
                       class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <span class="sr-only">Sign in with Google</span>
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-google" viewBox="0 0 16 16">
                            <path d="M15.545 6.558a9.42 9.42 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.689 7.689 0 0 1 5.352 2.082l-2.284 2.284A4.347 4.347 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.792 4.792 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.702 3.702 0 0 0 1.599-2.431H8v-3.08h7.545z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </x-auth-card>

</x-guest-layout>
