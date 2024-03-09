<form
    action="{{ route('dashboard.posts.store') }}"
    method="POST"
    enctype="multipart/form-data"
>
    @csrf
    <div class="mb-4 flex justify-end">
        <x-primary-button>
            Save
        </x-primary-button>
    </div>
    <div class="mb-6">
        <x-input-label for="title">Title*</x-input-label>
        <x-text-input id="title" name="title" class="w-full" maxlength="100"/>
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
    <div id="image_previews" class="grid grid-cols-1 gap-4"></div>
</form>
