<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/" class="flex justify-center">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500"/>
            </a>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">{{ __('Verify Your Email Address') }}</h2>
        </x-slot>
        <p class="my-2 text-sm text-gray-600">{{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}</a>
        </p>
        @if (session('status') == 'verification-link-sent')
            <x-auth-session-status class="mt-2 mb-4"
                                   :status="'A new verification link has been sent to the email address you provided during registration.'"/>
        @endif
        <form class="space-y-6" method="POST" action="{{ route('verification.send') }}">
            @csrf
            <div>
                <x-button
                    class="w-full flex justify-center shadow-sm text-sm font-medium focus:ring-2 focus:ring-offset-2">{{ __('Resend Verification Email') }}</x-button>
            </div>
        </form>

        <form class="mt-3" method="POST" action="{{ route('logout') }}">
            @csrf
            <x-button
                class="w-full flex justify-center shadow-sm text-sm font-medium focus:ring-2 focus:ring-offset-2">{{ __('Log Out') }}</x-button>
        </form>
    </x-auth-card>
</x-guest-layout>
