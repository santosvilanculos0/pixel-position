<div>
    <div class="overflow-x-auto">
        <table class="border-collapse border-e-gray-50">
            <thead class=" divide-gray-300">
                <tr>
                    <th class="border px-2 py-1 text-sm text-left">EMPLOYER</th>
                    <th class="border px-2 py-1 text-sm text-left">TITLE</th>
                    <th class="border px-2 py-1 text-sm text-left">SALARY</th>
                    <th class="border px-2 py-1 text-sm text-left">LOCATION</th>
                    <th class="border px-2 py-1 text-sm text-left">SCHEDULE</th>
                    <th class="border px-2 py-1 text-sm text-left">URL</th>
                    <th class="border px-2 py-1 text-sm text-left">FEATURED</th>
                    <th class="border px-2 py-1 text-sm text-left"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jobs as $job)
                    <tr wire:key="{{ $job->id }}">
                        <td class="border px-2 py-1 text-sm text-left">{{ $job->employer->name }}</td>
                        <td class="border px-2 py-1 text-sm text-left">{{ $job->title }}</td>
                        <td class="border px-2 py-1 text-sm text-left">{{ $job->salary }}</td>
                        <td class="border px-2 py-1 text-sm text-left">{{ $job->location }}</td>
                        <td class="border px-2 py-1 text-sm text-left">{{ $job->schedule }}</td>
                        <td class="border px-2 py-1 text-sm text-left">{{ $job->url }}</td>
                        <td class="border px-2 py-1 text-sm text-left">{{ $job->featured ? 'Yes' : 'No' }}</td>

                        <td class="border px-2 py-1 text-sm text-left">
                            <div class="flex gap-1">
                                <a href="{{ route('jobs.edit', ['job' => $job]) }}" type="button"
                                    class="bg-blue-800 rounded py-2 px-6 font-bold">Edit</a>

                                <button wire:click="delete({{ $job->id }})" type="button"
                                    class="bg-red-800 rounded py-2 px-6 font-bold text-nowrap">
                                    <span wire:loading.remove wire:target="delete({{ $job->id }})">Delete</span>
                                    <span wire:loading wire:target="delete({{ $job->id }})">...</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if ($jobs->hasPages())
        <div class="mt-4">
            {{ $jobs->links() }}
        </div>
    @endif

</div>
