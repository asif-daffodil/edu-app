<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('frontend.verify_email_notice') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('frontend.verification_link_sent') }}
        </div>
    @elseif (session('status') == 'verification-invalid')
        <div class="mb-4 font-medium text-sm text-red-600">
            {{ __('frontend.verification_invalid') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            @guest
                <div class="mb-3">
                    <x-input-label for="verification_email" :value="__('frontend.email')" />
                    <x-text-input id="verification_email" class="block mt-1 w-full" type="email" name="email"
                        :value="old('email', $verificationEmail ?? '')" required autocomplete="email" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
            @endguest

            <div class="flex items-center gap-3">
                <x-primary-button>
                    {{ __('frontend.resend_verification') }}
                </x-primary-button>

                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="/login">
                    {{ __('frontend.back_to_login') }}
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>
