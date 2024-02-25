<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
        @foreach($posts as $post)
            <x-dashboard.posts.card :$post />
        @endforeach
    </div>

</x-app-layout>

