<div>
    <x-page-heading>Update Job</x-page-heading>

    @session('status')
        <div class="mb-4">
            <div class="max-w-2xl mx-auto space-y-6 rounded-xl bg-white/10 border border-white/10 px-5 py-4 w-full">
                <p class="text-sm font-medium text-green-400">{{ $value }}</p>
            </div>
        </div>
    @endsession

    <x-forms.form class="mt-10" wire:submit.prevent="update" enctype="multipart/form-data">
        <x-forms.input label="Name" name="name" wire:model="name" />
        <x-forms.input label="Email" name="email" type="email" wire:model="email" />
        <x-forms.input label="Password" name="password" wire:model="password" type="password" />
        <x-forms.input label="Password Confirmation" name="password_confirmation" type="password"
            wire:model="password_confirmation" />

        <x-forms.divider />

        <x-forms.input label="Employer Name" name="employer" wire:model="employer" />
        <x-forms.input label="Employer Logo" name="logo" type="file" accept="image/png,image/jpeg"
            wire:model="logo" />

        <x-forms.button type="submit">
            <span wire:loading.remove>Update Account</span>
            <span wire:loading>...</span>
        </x-forms.button>
    </x-forms.form>
</div>
