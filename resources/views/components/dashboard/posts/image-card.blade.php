@props(['image'])

<div class="rounded-sm bg-white p-4 shadow">
    <span class="mb-2 block">#{{ $image->position }}</span>
    <div class="mb-4">
        <img
            alt=""
            src="{{ asset($image->file_path) }}"
            class="w-full border border-dashed object-contain aspect-[4/3]"
        >
    </div>
    <div class="h-20 xl:h-16">
        <p>
            <span class="font-semibold">Caption: </span>
            {{ $image->caption }}
        </p>
    </div>
</div>
