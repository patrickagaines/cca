<x-app-layout>
    <x-slot name="scripts">@vite(['resources/js/dashboard/posts/show.js'])</x-slot>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __($post->title) }}
        </h2>
    </x-slot>

    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
        <div class="mb-4 flex justify-end gap-2">
            <x-dashboard.link-button :href="route('dashboard.posts.edit', $post)">
                Edit
            </x-dashboard.link-button>
            <x-danger-button type="button" class="delete">
                Delete
            </x-danger-button>
        </div>
    </div>

    <x-dashboard.window-dialogue>
        <form action="{{ route('dashboard.posts.destroy', $post) }}"
              method="POST"
        >
            @csrf
            @method('DELETE')
            <h3 class="text-lg">Are you sure you wish to delete
                <span class="font-semibold"> {{ $post->title }}</span>?
            </h3>
            <div class="mt-8 flex justify-end gap-2">
                <x-secondary-button type="button" class="cancel_delete">
                    Cancel
                </x-secondary-button>
                <x-danger-button>
                    Delete
                </x-danger-button>
            </div>
        </form>
    </x-dashboard.window-dialogue>
</x-app-layout>

