'use strict';

export function previewImage(fileInput, previewContainer) {
    const files = fileInput.files;

    if (files.length > 0) {
        Array.from(files).forEach((file) => {
            if (file instanceof Blob) {
                const fileReader = new FileReader();

                fileReader.onload = function (event) {
                    const previewElement = buildPreview(event, previewContainer);
                    previewContainer.appendChild(previewElement);
                }

                fileReader.readAsDataURL(file);
            }
        });
    }
}

function buildPreview(event, previewContainer) {
    const previewPosition = previewContainer.childElementCount + 1;

    const previewElement = document.createElement('div');
    previewElement.classList.add('card');
    previewElement.setAttribute('draggable', 'true');

    const removePreviewElement = document.createElement('button');
    removePreviewElement.setAttribute('type', 'button');
    removePreviewElement.classList.add('remove_preview');
    removePreviewElement.value = previewPosition.toString();
    removePreviewElement.innerText = 'x';

    const imageSectionElement = document.createElement('div');
    imageSectionElement.classList.add('section', 'image_section');

    const inputsSectionElement = document.createElement('div');
    inputsSectionElement.classList.add('section', 'inputs_section')

    const imageElement = document.createElement('img');
    imageElement.setAttribute('alt', `Image upload preview #${previewPosition}`);
    imageElement.setAttribute('src', event.target.result.toString());

    const captionLabelElement = document.createElement('label');
    captionLabelElement.setAttribute('for', `caption_${previewPosition}`)
    captionLabelElement.innerText = 'Caption';

    const captionTextAreaElement = document.createElement('textarea');
    captionTextAreaElement.setAttribute('id', `caption_${previewPosition}`);
    captionTextAreaElement.setAttribute('name', `caption`);
    captionTextAreaElement.style.resize = 'none';

    const displayOrderLabelElement = document.createElement('label');
    displayOrderLabelElement.setAttribute('for', `position_${previewPosition}`);
    displayOrderLabelElement.innerText = 'Position';

    const displayOrderInputElement = document.createElement('input');
    displayOrderInputElement.setAttribute('type', 'number');
    displayOrderInputElement.setAttribute('id', `position_${previewPosition}`);
    displayOrderInputElement.setAttribute('name', 'position')
    displayOrderInputElement.value = previewPosition.toString();
    displayOrderInputElement.readOnly = true;

    imageSectionElement.appendChild(imageElement);

    inputsSectionElement.appendChild(captionLabelElement);
    inputsSectionElement.appendChild(captionTextAreaElement);
    inputsSectionElement.appendChild(displayOrderLabelElement);
    inputsSectionElement.appendChild(displayOrderInputElement);

    previewElement.appendChild(removePreviewElement);
    previewElement.appendChild(imageSectionElement);
    previewElement.appendChild(inputsSectionElement);

    return previewElement;
}
