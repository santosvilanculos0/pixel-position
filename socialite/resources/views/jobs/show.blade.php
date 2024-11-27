<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Job') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="border-collapse">
                        <tbody>
                            <tr>
                                <th class="text-left">ID</th>
                                <td class="p-4">{{ $data['data']['id'] }}</td>
                            </tr>
                            <tr>
                                <th class="text-left">Employer</th>
                                <td class="p-4">{{ $data['data']['employer'] }}</td>
                            </tr>
                            <tr>
                                <th class="text-left">Title</th>
                                <td class="p-4">{{ $data['data']['title'] }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
