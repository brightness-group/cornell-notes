<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/" class="flex justify-center">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">{{ __('Forgot your password?') }}</h2>
        </x-slot>
        <p class="my-2 text-sm text-gray-600">{{ __('No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </p>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form class="space-y-6" method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email address')" />
                <div class="mt-1">
                    <x-input id="email" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" autocomplete="email" type="email" name="email" :value="old('email')" required autofocus />
                </div>
            </div>
            <div>
                <x-button class="w-full flex justify-center shadow-sm text-sm font-medium focus:ring-2 focus:ring-offset-2">{{ __('Email Password Reset Link') }}</x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
