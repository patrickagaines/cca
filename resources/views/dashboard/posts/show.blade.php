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
            <x-danger-button type="button" class="delete">
                Delete
            </x-danger-button>
        </div>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($post->images as $image)
                <x-dashboard.posts.image-card :image="$image"/>
            @endforeach
        </div>
    </div>

    <x-dashboard.window-dialogue class="confirm_delete">
        <x-dashboard.posts.delete :post="$post"/>
    </x-dashboard.window-dialogue>
</x-app-layout>

