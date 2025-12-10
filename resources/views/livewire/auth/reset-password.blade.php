<x-authentication-layout>
    <h1 class="text-3xl text-gray-800 dark:text-gray-100 font-bold mb-6">{{ __('Reset your Password') }}</h1>
    
    <!-- Form -->
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ request()->route('token') }}">
        
        <div class="space-y-4">
            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" type="email" name="email" :value="old('email', request()->email)" required autofocus />
            </div>

            <div>
                <x-label for="password" value="{{ __('New Password') }}" />
                <x-input id="password" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div>
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>
        </div>
        <div class="mt-6">
            <x-button class="w-full">
                {{ __('Reset Password') }}
            </x-button>
        </div>
    </form>
    <x-validation-errors class="mt-4" />
</x-authentication-layout>
