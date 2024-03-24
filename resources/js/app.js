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
