@props(['post'])

<form action="{{ route('dashboard.posts.destroy', $post) }}"
      method="POST"
>
    @csrf
    @method('DELETE')
    <h3 class="text-lg">Are you sure you wish to delete
        <span class="font-semibold"> {{ $post->title }}</span>?
    </h3>
    <div class="mt-8 flex justify-end gap-2">
        <x-secondary-button type="button" class="cancel_delete">
            Cancel
        </x-secondary-button>
        <x-danger-button>
            Delete
        </x-danger-button>
    </div>
</form>
