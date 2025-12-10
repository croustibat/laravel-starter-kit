<x-authentication-layout>
    <h1 class="text-3xl text-gray-800 dark:text-gray-100 font-bold mb-6">{{ __('Confirm Password') }}</h1>
    
    <div class="text-sm text-gray-500 dark:text-gray-400 mb-6">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>
    
    <!-- Form -->
    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf
        <div class="space-y-4">
            <div>
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" type="password" name="password" required autocomplete="current-password" />
            </div>
        </div>
        <div class="mt-6">
            <x-button class="w-full">
                {{ __('Confirm') }}
            </x-button>
        </div>
    </form>
    <x-validation-errors class="mt-4" />
</x-authentication-layout>
