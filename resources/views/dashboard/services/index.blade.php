<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Services') }}
        </h2>
    </x-slot>

    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
        <div class="mb-4 flex justify-end">
            <x-dashboard.link-button :href="route('dashboard.services.create')" class="w-36">
                Create New +
            </x-dashboard.link-button>
        </div>

        <table class="mb-4 w-full table-auto border-collapse shadow-sm lg:whitespace-nowrap">
            <thead>
            <tr>
                <th scope="col" class="border border-gray-400 px-8 py-4 text-left">Name</th>
                <th scope="col" class="hidden border border-gray-400 px-8 py-4 text-left md:table-cell">Created At</th>
                <th scope="col" class="hidden border border-gray-400 px-8 py-4 text-left md:table-cell">Updated At</th>
            </tr>
            </thead>
            <tbody>
            @foreach($services as $service)
                <tr class="odd:bg-white">
                    <th scope="row" class="border border-gray-400 px-8 py-4 text-left">
                        <a href="{{ route('dashboard.services.show', ['service' => $service]) }}" class="text-indigo-700">
                            {{ $service->name }}
                        </a>
                    </th>
                    <td class="hidden border border-gray-400 px-8 py-4 md:table-cell">{{ $service->created_at->setTimezone('America/Chicago')->format('D, M jS, Y') }}</td>
                    <td class="hidden border border-gray-400 px-8 py-4 md:table-cell">{{ $service->updated_at->setTimezone('America/Chicago')->format('D, M jS, Y') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        @if ($services->count())
            {{ $services->links() }}
        @endif
    </div>
</x-app-layout>
