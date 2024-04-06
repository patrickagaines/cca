@props(['post' => null])

<form
    id="posts_form"
    action="{{ isset($post) ?
        route('dashboard.posts.update', ['post' => $post]) :
        route('dashboard.posts.store') }}"
    method="POST"
    enctype="multipart/form-data"
>
    @csrf
    @isset($post)
        @method('PUT')
    @endisset
    <div class="mb-4 flex justify-end">
        <x-primary-button>
            Save
        </x-primary-button>
    </div>
    <div class="mb-6">
        <x-input-label for="title">
            Title
            <span class="text-red-600">*</span>
        </x-input-label>
        <x-text-input
            id="title"
            name="title"
            class="w-full"
            required
            maxlength="30"
            value="{{ $post->title ?? old('title') }}"
        />
        <x-input-error :messages="$errors->get('title')"/>
    </div>
    <div class="mb-6 flex flex-wrap justify-center">
        <label for="image_upload">
            Upload Images
        </label>
        <input type="file" accept=".jpg, .jpeg, .png" multiple id="image_upload" name="image_files[]" class="hidden">
        @error('images')
        <div class="mt-2 flex basis-full justify-center">
            <x-input-error :messages="$errors->get('images')"/>
        </div>
        @enderror
    </div>
    <div id="image_previews" class="grid grid-cols-1 gap-4">
        @isset($post)
            @foreach($post->images as $image)
                <div class="card" draggable="true">
                    <button type="button" class="remove_preview" value="{{ $image->file_name }}">x</button>
                    <div class="section image_section">
                        <img alt="Image Preview" src="{{ asset($image->thumbnail_path ?? $image->file_path) }}">
                    </div>
                    <div class="section inputs_section">
                        <input type="hidden" name="images[{{ $image->file_name }}][id]" value="{{ $image->id }}">
                        <label for="caption_{{ $image->file_name }}">Caption</label>
                        <textarea
                            id="caption_{{ $image->file_name }}"
                            name="images[{{ $image->file_name }}][caption]"
                            maxlength="60"
                        >{{ $image->caption }}</textarea>
                        <label for="position_{{ $image->file_name }}">Position</label>
                        <input
                            type="number"
                            id="position_{{ $image->file_name }}"
                            name="images[{{ $image->file_name }}][position]"
                            value="{{ $image->position }}"
                            readonly
                        >
                        <button type="button" class="arrow up" {{ $loop->first ? 'disabled' : '' }}>&#8593;</button>
                        <button type="button" class="arrow down" {{ $loop->last ? 'disabled' : '' }}>&#8595;</button>
                    </div>
                </div>
            @endforeach
        @endisset
    </div>
</form>
