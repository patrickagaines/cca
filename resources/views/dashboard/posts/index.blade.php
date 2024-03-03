<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Posts') }}
        </h2>
    </x-slot>

    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
        <div class="mb-4 flex justify-end">
            <x-dashboard.link-button :href="route('dashboard.posts.create')" class="w-36">
                Create New +
            </x-dashboard.link-button>
        </div>
        <div class="mb-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($posts as $post)
                <x-dashboard.posts.card :$post/>
            @endforeach
        </div>
        @if ($posts->count())
            {{ $posts->links() }}
        @endif
    </div>

</x-app-layout>

