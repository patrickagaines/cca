'use strict';

export function previewImage(fileInput, previewContainer, imageDataTransfer, maxUploadCount) {
    const files = fileInput.files;

    if (files.length > 0) {
        for (let fileIndex = 0; fileIndex < files.length; fileIndex++) {

            if (imageDataTransfer.items.length === maxUploadCount) {
                setTimeout(
                    () => window.alert(`You may only upload ${maxUploadCount} files at a time`),
                    350
                );

                break;
            }

            let file = files.item(fileIndex);

            if (file instanceof Blob) {
                imageDataTransfer.items.add(file);

                const fileReader = new FileReader();

                fileReader.onload = function (e) {
                    const previewElement = buildPreview(e, previewContainer, fileIndex);
                    previewContainer.appendChild(previewElement);
                }

                fileReader.readAsDataURL(file);
            }
        }

        fileInput.files = imageDataTransfer.files;
    }
}

function buildPreview(e, previewContainer, fileIndex) {
    const uniqueIndex = Date.now();
    const previewPosition = previewContainer.childElementCount + 1;

    const previewElement = document.createElement('div');
    previewElement.classList.add('card');
    previewElement.setAttribute('draggable', 'true');

    const removePreviewElement = document.createElement('button');
    removePreviewElement.setAttribute('type', 'button');
    removePreviewElement.classList.add('remove_preview');
    removePreviewElement.value = uniqueIndex.toString();
    removePreviewElement.innerText = 'x';

    const imageSectionElement = document.createElement('div');
    imageSectionElement.classList.add('section', 'image_section');

    const inputsSectionElement = document.createElement('div');
    inputsSectionElement.classList.add('section', 'inputs_section')

    const imageElement = document.createElement('img');
    imageElement.setAttribute('alt', `Image Upload Preview`);
    imageElement.setAttribute('src', e.target.result.toString());

    const fileIndexInputElement = document.createElement('input');
    fileIndexInputElement.setAttribute('type', 'hidden');
    fileIndexInputElement.setAttribute('name', `images[${uniqueIndex}][file_index]`);
    fileIndexInputElement.value = fileIndex;

    const captionLabelElement = document.createElement('label');
    captionLabelElement.setAttribute('for', `caption_${uniqueIndex}`)
    captionLabelElement.innerText = 'Caption';

    const captionTextAreaElement = document.createElement('textarea');
    captionTextAreaElement.setAttribute('id', `caption_${uniqueIndex}`);
    captionTextAreaElement.setAttribute('name', `images[${uniqueIndex}][caption]`);
    captionTextAreaElement.setAttribute('maxlength', '60');

    const displayOrderLabelElement = document.createElement('label');
    displayOrderLabelElement.setAttribute('for', `position_${uniqueIndex}`);
    displayOrderLabelElement.innerText = 'Position';

    const displayOrderInputElement = document.createElement('input');
    displayOrderInputElement.setAttribute('type', 'number');
    displayOrderInputElement.setAttribute('id', `position_${uniqueIndex}`);
    displayOrderInputElement.setAttribute('name', `images[${uniqueIndex}][position]`);
    displayOrderInputElement.value = previewPosition.toString();
    displayOrderInputElement.readOnly = true;

    const moveUpButtonElement = document.createElement('button');
    moveUpButtonElement.setAttribute('type', 'button');
    moveUpButtonElement.classList.add('arrow', 'up');
    moveUpButtonElement.innerHTML = '&#8593;';

    const moveDownButtonElement = document.createElement('button');
    moveDownButtonElement.setAttribute('type', 'button');
    moveDownButtonElement.classList.add('arrow', 'down');
    moveDownButtonElement.innerHTML = '&#8595;';

    imageSectionElement.appendChild(imageElement);

    inputsSectionElement.appendChild(fileIndexInputElement);
    inputsSectionElement.appendChild(captionLabelElement);
    inputsSectionElement.appendChild(captionTextAreaElement);
    inputsSectionElement.appendChild(displayOrderLabelElement);
    inputsSectionElement.appendChild(displayOrderInputElement);
    inputsSectionElement.appendChild(moveUpButtonElement);
    inputsSectionElement.appendChild(moveDownButtonElement);

    previewElement.appendChild(removePreviewElement);
    previewElement.appendChild(imageSectionElement);
    previewElement.appendChild(inputsSectionElement);

    return previewElement;
}
