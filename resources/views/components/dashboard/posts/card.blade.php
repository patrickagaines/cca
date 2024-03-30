@props(['post'])

<div class="rounded-sm bg-white p-4 shadow">
    <div class="mb-4">
        <img
            alt=""
            src="{{ asset($post->images[0]->thumbnail_path ?? $post->images[0]->file_path)  }}"
            class="object-cover aspect-square"
        >
    </div>
    <div class="mb-4 h-16">
        <h3>{{ $post->title }}</h3>
    </div>
    <x-dashboard.link-button :href="route('dashboard.posts.show', $post)">
        View Details
    </x-dashboard.link-button>
</div>
