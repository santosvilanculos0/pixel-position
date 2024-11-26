<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="GET" action="/auth/redirect">
        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="w-full ms-3">
                {{ __('Log in (Laravel Passport)') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
