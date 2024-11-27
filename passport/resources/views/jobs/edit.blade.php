<x-layouts.app>
    <x-page-heading>Update Job</x-page-heading>

    @session('status')
        <div class="mb-4">
            <div class="max-w-2xl mx-auto space-y-6 rounded-xl bg-white/10 border border-white/10 px-5 py-4 w-full">
                <p class="text-sm font-medium text-green-400">{{ $value }}</p>
            </div>
        </div>
    @endsession

    <x-forms.form method="POST" action="{{ route('jobs.update', ['job' => $job]) }}">
        @csrf
        @method('PUT')

        <x-forms.input label="Title" name="title" placeholder="CEO" value="{{ old('title', $job->title) }}" />
        <x-forms.input label="Salary" name="salary" placeholder="$90,000 USD"
            value="{{ old('title', $job->salary) }}" />
        <x-forms.input label="Location" name="location" placeholder="Winter Park, Florida"
            value="{{ old('location', $job->location) }}" />

        <x-forms.select label="Schedule" name="schedule">
            <option @selected(str($job->schedule)->is('Part Time'))>Part Time</option>
            <option @selected(str($job->schedule)->is('Full Time'))>Full Time</option>
        </x-forms.select>

        <x-forms.input type="url" label="URL" name="url" placeholder="https://acme.com/jobs/ceo-wanted"
            value="{{ old('url', $job->url) }}" />
        <x-forms.checkbox label="Feature (Costs Extra)" name="featured" @checked($job->featured) />

        <x-forms.divider />

        <x-forms.input label="Tags (comma separated)" name="tags" placeholder="laracasts, video, education"
            value="{{ old('tags', implode(',', array_map(fn($tag) => (string) $tag['name'], $job->tags->toArray()))) }}" />

        <div class="mb-2"></div>
        <x-forms.button>Publish</x-forms.button>
    </x-forms.form>
</x-layouts.app>
