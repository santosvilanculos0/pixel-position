<x-layouts.app>
    <x-page-heading>New Job</x-page-heading>

    @session('status')
        <div class="mb-4">
            <div class="max-w-2xl mx-auto space-y-6 rounded-xl bg-white/10 border border-white/10 px-5 py-4 w-full">
                <p class="text-sm font-medium text-green-400">{{ $value }}</p>
            </div>
        </div>
    @endsession

    <x-forms.form method="POST" action="{{ route('jobs.store') }}">
        <x-forms.input label="Title" name="title" placeholder="CEO" />
        <x-forms.input label="Salary" name="salary" placeholder="$90,000 USD" />
        <x-forms.input label="Location" name="location" placeholder="Winter Park, Florida" />

        <x-forms.select label="Schedule" name="schedule">
            <option>Part Time</option>
            <option>Full Time</option>
        </x-forms.select>

        <x-forms.input type="url" label="URL" name="url" placeholder="https://acme.com/jobs/ceo-wanted" />
        <x-forms.checkbox label="Feature (Costs Extra)" name="featured" />

        <x-forms.divider />

        <x-forms.input label="Tags (comma separated)" name="tags" placeholder="laracasts, video, education" />

        <x-forms.button>Publish</x-forms.button>
    </x-forms.form>
</x-layouts.app>
