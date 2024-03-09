<x-app-layout>
    <x-slot name="scripts">@vite(['resources/js/dashboard/posts/form.js'])</x-slot>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Edit Post') }}
        </h2>
    </x-slot>

    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
        <x-dashboard.posts.form :$post />
    </div>

</x-app-layout>
