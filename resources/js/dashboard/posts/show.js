"use strict";

const windowDialogue = document.querySelector('.window_dialogue');
const deleteButton = document.querySelector('button.delete');
const cancelDeleteButton = document.querySelector('button.cancel_delete');

deleteButton.addEventListener('click', function() {
   windowDialogue.classList.add('window_dialogue--active');
});

cancelDeleteButton.addEventListener('click', function() {
   windowDialogue.classList.remove('window_dialogue--active');
});
