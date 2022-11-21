<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo" class="flex justify-center">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500"/>
            </a>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">{{ __('Sign in to your account') }}</h2>
        </x-slot>

        <p class="mb-4 text-sm text-gray-600">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </p>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors"/>

        <form class="space-y-6" method="POST" action="{{ route('password.confirm') }}">
            @csrf
            <!-- Password -->
            <div>
                <x-label for="password" :value="__('Password')"/>
                <div class="mt-1">
                    <x-input id="password"
                             class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                             type="password" name="password" required/>
                </div>
            </div>
            <div>
                <x-button
                    class="w-full flex justify-center shadow-sm text-sm font-medium focus:ring-2 focus:ring-offset-2">
                    {{ __('Confirm') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
