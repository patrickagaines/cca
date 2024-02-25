@props(['post'])

<div>
    <h3>{{ $post->title }}</h3>
    <div>
        <img src="{{ asset($post->images()->first()->file_path) }}" alt="">
    </div>
</div>
