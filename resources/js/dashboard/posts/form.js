'use strict';

import { previewImage } from "./preview.js";

const fileInput = document.getElementById('image_upload');
const previewContainer = document.getElementById('image_previews');
const previewObserver = new MutationObserver(() => {
   initializeDragHandlers();
   initializeRemoveButtons();
   initalizeArrowButtons();
});
const imageDataTransfer = new DataTransfer();

let previews;
let currentDragElement;

fileInput.addEventListener('change', () => {
    previewImage(fileInput, previewContainer, imageDataTransfer);
});

previewObserver.observe(previewContainer, { childList: true });

initializeDragHandlers();
initializeRemoveButtons();
initalizeArrowButtons();

function initializeDragHandlers() {
    previews = document.querySelectorAll('.card');

    previews.forEach((item) => {
        item.addEventListener('dragstart', handleDragStart);
        item.addEventListener('dragend', handleDragEnd);
        item.addEventListener('dragover', handleDragOver);
        item.addEventListener('dragenter', handleDragEnter);
        item.addEventListener('dragleave', handleDragLeave);
        item.addEventListener('drop', handleDrop);
    });
}

function initializeRemoveButtons() {
    let removePreviewButtons = document.querySelectorAll('.remove_preview');

    removePreviewButtons.forEach((button) => {
        button.addEventListener('click', handleRemovePreview);
    });
}

function initalizeArrowButtons() {
    let arrowUpButtons = document.querySelectorAll('.arrow.up');
    arrowUpButtons.forEach((button, index) => {
       button.disabled = index === 0;
       button.addEventListener('click', handleArrowUp);
    });

    let arrowDownButtons = document.querySelectorAll('.arrow.down');
    arrowDownButtons.forEach((button, index) => {
       button.disabled = index === arrowDownButtons.length - 1;
        button.addEventListener('click', handleArrowDown);
    });
}

function handleDragStart(e) {
    previews.forEach((item) => {
        item.classList.add('disable-child-pointers');
    })

    this.style.opacity = '0.4';

    currentDragElement = this;
}

function handleDragEnd(e) {
    previews.forEach((item) => {
        item.classList.remove('disable-child-pointers', 'over');
    })

    this.style.opacity = '1';
}

function handleDragOver(e) {
    e.preventDefault();
    return false;
}

function handleDragEnter(e) {
    this.classList.add('over');
}

function handleDragLeave(e) {
    this.classList.remove('over');
}

function handleDrop(e) {
    e.stopPropagation();

    if (currentDragElement !== this) {
        const temp = new Text("");
        this.before(temp);
        currentDragElement.replaceWith(this);
        temp.replaceWith(currentDragElement);
    }

    updatePreviewPositions();

    return false;
}

function handleRemovePreview(e) {
    const previewElement = e.target.parentElement;
    const fileToRemove = previewElement.querySelector('input[name="image_names[]"]').value;

    Array.from(imageDataTransfer.files).forEach((file, index) => {
        if (file.name === fileToRemove) {
            imageDataTransfer.items.remove(index);

            fileInput.files = imageDataTransfer.files;
        }
    });

    previewElement.remove();
    updatePreviewPositions();
}

function handleArrowUp(e) {
    const currentPreview = e.target.closest('.card');
    const targetPreview = currentPreview.previousElementSibling;
    const temp = new Text("");
    targetPreview.before(temp);
    currentPreview.replaceWith(targetPreview);
    temp.replaceWith(currentPreview);

    updatePreviewPositions();
}

function handleArrowDown(e) {
    const currentPreview = e.target.closest('.card');
    const targetPreview = currentPreview.nextElementSibling;
    const temp = new Text("");
    targetPreview.before(temp)
    currentPreview.replaceWith(targetPreview);
    temp.replaceWith(currentPreview);

    updatePreviewPositions();
}

function updatePreviewPositions() {
    let positionInputs = document.querySelectorAll('input[name="positions[]"]');

    positionInputs.forEach((input, index) => {
        input.value = index + 1;
    });
}
