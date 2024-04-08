"use strict";

import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

const flashMessage = document.getElementById('flash_message');

if (flashMessage) {
    const removeFlashMessageButton = document.getElementById('remove_flash_message');

    removeFlashMessageButton.addEventListener('click', () => flashMessage.remove());

    setTimeout(function () {
        flashMessage.classList.remove('flash_in');
        flashMessage.classList.add('flash_out');
    }, 3000);
}

const deleteDialogue = document.querySelector('.window_dialogue.confirm_delete');
const deleteButton = document.querySelector('button.delete');
const cancelDeleteButton = document.querySelector('button.cancel_delete');

if (deleteDialogue && deleteButton && cancelDeleteButton) {
    deleteButton.addEventListener('click', function() {
        deleteDialogue.classList.add('window_dialogue--active');
    });

    cancelDeleteButton.addEventListener('click', function() {
        deleteDialogue.classList.remove('window_dialogue--active');
    });
}
