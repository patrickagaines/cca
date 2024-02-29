@props(['post'])

<div class="rounded-sm bg-white p-4 shadow">
    <div class="mb-4">
        <img src="{{ asset($post->images()->first()->file_path) }}" alt="">
    </div>
    <div class="mb-4 h-16">
        <h3>{{ $post->title }}</h3>
    </div>
    <x-dashboard.link-button :href="route('posts.show', $post)">
        View Details
    </x-dashboard.link-button>
</div>
