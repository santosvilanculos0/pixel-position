<x-layouts.guest>
    <div class="flex flex-col justify-center min-h-full px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img class="object-contain w-auto h-12 mx-auto" src="{{ Vite::asset('resources/images/logo.svg') }}"
                alt="{{ config('app.name', 'Laravel') }}">
        </div>

        <x-forms.form class="mt-10" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf
            <x-forms.input label="Name" name="name" />
            <x-forms.input label="Email" name="email" type="email" />
            <x-forms.input label="Password" name="password" type="password" />
            <x-forms.input label="Password Confirmation" name="password_confirmation" type="password" />

            <x-forms.divider />

            <x-forms.input label="Employer Name" name="employer" />
            <x-forms.input label="Employer Logo" name="logo" type="file" accept="image/png,image/jpeg" />

            <x-forms.button>Create Account</x-forms.button>
        </x-forms.form>
    </div>
</x-layouts.guest>
