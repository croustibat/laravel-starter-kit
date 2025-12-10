<x-authentication-layout>
    <h1 class="text-3xl text-gray-800 dark:text-gray-100 font-bold mb-6">{{ __('Reset your Password') }}</h1>
    
    <div class="text-sm text-gray-500 dark:text-gray-400 mb-6">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link.') }}
    </div>
    
    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('status') }}
        </div>
    @endif
    
    <!-- Form -->
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="space-y-4">
            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" type="email" name="email" :value="old('email')" required autofocus />
            </div>
        </div>
        <div class="mt-6">
            <x-button class="w-full">
                {{ __('Send Reset Link') }}
            </x-button>
        </div>
    </form>
    <x-validation-errors class="mt-4" />
    
    <!-- Footer -->
    <div class="pt-5 mt-6 border-t border-gray-100 dark:border-gray-700/60">
        <div class="text-sm">
            <a class="font-medium text-violet-500 hover:text-violet-600 dark:hover:text-violet-400" href="{{ route('login') }}">{{ __('Back to Sign In') }}</a>
        </div>
    </div>
</x-authentication-layout>
