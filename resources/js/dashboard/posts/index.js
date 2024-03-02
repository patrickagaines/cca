'use strict';

import { previewImage } from './preview.js'

const fileInput = document.getElementById('images');
fileInput.addEventListener('change', () => previewImage(fileInput));
