'use strict';

import { makeDraggable } from './dragabble.js';
import { previewImage } from './preview.js'

const fileInput = document.getElementById('image_upload');
const previewContainer = document.getElementById('image_previews');
const observer = new MutationObserver(function () {
    makeDraggable('.card');
});

makeDraggable('.card');
fileInput.addEventListener(
    'change',
    () => previewImage(fileInput, previewContainer)
);

observer.observe(previewContainer, { childList: true });
