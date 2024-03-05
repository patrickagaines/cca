import { previewImage, removePreview } from "./preview.js";

const fileInput = document.getElementById('image_upload');
const previewContainer = document.getElementById('image_previews');
const previewObserver = new MutationObserver(() => {
   initializeDragHandlers();
   initializeRemoveButtons();
});

let previews;
let removePreviewButtons;
let currentDragElement;

fileInput.addEventListener('change', () => previewImage(fileInput, previewContainer));
previewObserver.observe(previewContainer, { childList: true });

initializeDragHandlers();
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
    removePreviewButtons = document.querySelectorAll('.remove_preview');

    removePreviewButtons.forEach((button) => {
        button.addEventListener('click', (e) => {
            removePreview(e);
            updatePreviewPositions();
        });
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

function updatePreviewPositions() {
    let positionInputs = document.querySelectorAll('input[name="position[]"]');

    positionInputs.forEach((input, index) => {
        input.value = index + 1;
    });
}
