<x-app-layout>
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
            <form
                action="{{ route('dashboard.posts.destroy', ['post' => $post]) }}"
                method="POST"
            >
                @csrf
                @method('DELETE')
                <x-danger-button>
                    Delete
                </x-danger-button>
            </form>
        </div>
    </div>

</x-app-layout>

