@props(['post' => null])

<form
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
        <x-input-label for="title">Title*</x-input-label>
        <x-text-input
            id="title"
            name="title"
            class="w-full"
            required
            maxlength="100"
            value="{{ $post->title ?? old('title') }}"
        />
        <x-input-error :messages="$errors->get('title')"/>
    </div>
    <div class="mb-6 flex flex-wrap justify-center">
        <label
            for="image_upload"
            class="cursor-pointer rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition duration-150 ease-in-out hover:bg-gray-50">
            Upload Images
        </label>
        <input type="file" accept=".jpg, .jpeg, .png" multiple id="image_upload" name="images[]" class="hidden">
        @error('image_names')
        <div class="mt-2 flex basis-full justify-center">
            <x-input-error :messages="$errors->get('image_names')"/>
        </div>
        @enderror
    </div>
    <div id="image_previews" class="grid grid-cols-1 gap-4">
        @isset($post)
            @foreach($post->images as $image)
                <div class="card" draggable="true">
                    <button type="button" class="remove_preview" value="{{ $image->position }}">x</button>
                    <div class="section image_section">
                        <img alt="Image preview #{{ $image->position }}" src="{{ asset($image->file_path) }}">
                    </div>
                    <div class="section inputs_section">
                        <input type="hidden" name="image_names[]" value="{{ $image->file_name }}">
                        <label for="caption_{{ $image->position }}">Caption</label>
                        <textarea
                            id="caption_{{ $image->position }}"
                            name="captions[]"
                        >{{ $image->caption }}</textarea>
                        <label for="position_{{ $image->position }}">Position</label>
                        <input type="number" id="position_{{ $image->position }}" name="positions[]" value="{{ $image->position }}" readonly>
                        <button type="button" class="arrow up">&#8593;</button>
                        <button type="button" class="arrow down">&#8595;</button>
                    </div>
                </div>
            @endforeach
        @endisset
    </div>
</form>
