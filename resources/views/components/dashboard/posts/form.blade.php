<form
    action=""
    method="POST"
>
    @csrf
    <div class="mb-4 flex justify-end">
        <x-primary-button>
            Save
        </x-primary-button>
    </div>
    <div class="mb-6">
        <x-input-label for="title">Title</x-input-label>
        <x-text-input id="title" name="title" class="w-full" />
        @error('title')
        @enderror
    </div>
    <div class="flex justify-center mb-6">
        <label for="image_upload" class="text-gray-700 cursor-pointer rounded-md border border-gray-300 shadow-sm bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest transition duration-150 ease-in-out hover:bg-gray-50">Upload Images</label>
        <input type="file" accept=".jpg, .jpeg, .png" multiple id="image_upload" class="hidden">
        @error('images')
        @enderror
    </div>
    <div id="image_previews" class="grid grid-cols-1 gap-4"></div>
</form>
