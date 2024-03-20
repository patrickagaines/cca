'use strict';

import { previewImage } from "./preview.js";

const maxUploadCount = 20;
const form = document.getElementById('posts_form');
const fileInput = document.getElementById('image_upload');
const fileInputLabel = document.querySelector('label[for="image_upload"]');
const previewContainer = document.getElementById('image_previews');
const previewObserver = new MutationObserver(() => {
    initializeDragHandlers();
    initializeRemoveButtons();
    initalizeArrowButtons();
    handleMaxUploadCount();
});
const imageDataTransfer = new DataTransfer();

let previews;
let currentDragElement;

fileInput.addEventListener('change', () => {
    previewImage(fileInput, previewContainer, imageDataTransfer, maxUploadCount);
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

function handleMaxUploadCount() {
    if (imageDataTransfer.files.length === maxUploadCount) {
        fileInputLabel.classList.add('disabled');
    } else if (fileInputLabel.classList.contains('disabled')) {
        fileInputLabel.classList.remove('disabled');
    }
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
    const idInput = previewElement.querySelector('input[name^="images"][name$="[id]"]');
    const fileIndexInput = previewElement.querySelector('input[name^="images"][name$="[file_index]"]');

    if (idInput) {
        markImageForDeletion(idInput.value);
    } else if (fileIndexInput) {
        imageDataTransfer.items.remove(fileIndexInput.value);
        fileInput.files = imageDataTransfer.files;
    }

    previewElement.remove();
    updatePreviewPositions();
}

function markImageForDeletion(imageId) {
    const deletedImageInput = document.createElement('input');
    deletedImageInput.setAttribute('type', 'hidden');
    deletedImageInput.setAttribute('name', 'deleted_images[]');
    deletedImageInput.value = imageId;
    form.appendChild(deletedImageInput);
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
    let positionInputs = document.querySelectorAll('input[name^="images"][name$="[position]"]');

    positionInputs.forEach((input, index) => {
        input.value = index + 1;
    });
}
