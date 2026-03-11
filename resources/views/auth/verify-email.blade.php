<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('frontend.verify_email_notice') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('frontend.verification_link_sent') }}
        </div>
    @elseif (session('status') == 'verification-email-updated')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('frontend.verification_email_updated') }}
        </div>
    @elseif (session('status') == 'verification-invalid')
        <div class="mb-4 font-medium text-sm text-red-600">
            {{ __('frontend.verification_invalid') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send', absolute: false) }}">
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

    <div class="mt-8 border-t border-gray-200 pt-6">
        <h3 class="text-sm font-semibold text-gray-900">{{ __('frontend.change_verification_email') }}</h3>
        <p class="mt-1 text-sm text-gray-600">{{ __('frontend.verification_change_help') }}</p>

        <form method="POST" action="{{ route('verification.email.update', absolute: false) }}" class="mt-4 space-y-4">
            @csrf

            <div>
                <x-input-label for="current_email" :value="__('frontend.current_email')" />
                <x-text-input id="current_email" class="block mt-1 w-full" type="email" name="current_email"
                    :value="old('current_email', $verificationEmail ?? auth()->user()?->email ?? '')" required autocomplete="email" />
                <x-input-error :messages="$errors->get('current_email')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="new_email" :value="__('frontend.new_email')" />
                <x-text-input id="new_email" class="block mt-1 w-full" type="email" name="new_email"
                    :value="old('new_email')" required autocomplete="email" />
                <x-input-error :messages="$errors->get('new_email')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="verify_password" :value="__('frontend.account_password')" />
                <x-text-input id="verify_password" class="block mt-1 w-full" type="password" name="password"
                    required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <x-primary-button>
                {{ __('frontend.update_email_and_resend') }}
            </x-primary-button>
        </form>
    </div>
</x-guest-layout>
