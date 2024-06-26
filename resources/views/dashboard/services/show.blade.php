<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __($service->name) }}
        </h2>
    </x-slot>

    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
        <div class="mb-4 flex justify-end gap-2">
            <x-dashboard.link-button :href="route('dashboard.services.edit', $service)">
                Edit
            </x-dashboard.link-button>
            <x-danger-button type="button" class="delete">
                Delete
            </x-danger-button>
        </div>
        <p>{{ $service->description }}</p>
    </div>

    <x-dashboard.window-dialogue class="confirm_delete">
        <x-dashboard.services.delete :service="$service"/>
    </x-dashboard.window-dialogue>
</x-app-layout>
