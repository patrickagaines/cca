@props(['type', 'message'])

<div id="flash_message" class="{{ $type }} flash_in">
    <button type="button" id="remove_flash_message" class="float-right uppercase leading-4">X</button>
    <p class="p-4">{{ $message }}</p>
</div>
