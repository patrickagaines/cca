'use strict';

export function makeDraggable(itemClass) {
    const items = document.querySelectorAll(itemClass.toString());

    if (items.length > 0) {
        items.forEach((item) => {
            item.addEventListener('dragstart', handleDragStart);
            item.addEventListener('dragover', handleDragOver);
            item.addEventListener('dragenter', handleDragEnter);
            item.addEventListener('dragleave', handleDragLeave);
            item.addEventListener('dragend', (e) => handleDragEnd(e, items));
            item.addEventListener('drop', handleDrop);
        });
    }
}

let currentDragElement;

function handleDragStart(e) {
    e.currentTarget.style.opacity = '0.4';

    currentDragElement = e.currentTarget;

    e.dataTransfer.effectAllowed = 'move';
    e.dataTransfer.setData('text/html', this.innerHTML);
}

function handleDragEnd(e, items) {
    e.currentTarget.style.opacity = '1';

    items.forEach(function (item) {
        item.classList.remove('over');
    });
}

function handleDragOver(e) {
    e.preventDefault();
    return false;
}

function handleDragEnter(e) {
    e.currentTarget.classList.add('over');
}

function handleDragLeave(e) {
    e.currentTarget.classList.remove('over');
}

function handleDrop(e) {
    e.stopPropagation();

    if (currentDragElement !== e.currentTarget) {

        let transferredInputs = [`textarea[name="caption"]`];
        let transfereredValues = [];

        let retainedInputs = [`input[name="position"]`];
        let retainedValues = [];

        transferredInputs.forEach((input) => {
            let currentValue = currentDragElement.querySelector(input).value;
            let targetValue = e.currentTarget.querySelector(input).value;

            transfereredValues.push({
                input,
                currentValue,
                targetValue
            });
        });

        retainedInputs.forEach((input) => {
            let currentValue = currentDragElement.querySelector(input).value;
            let targetValue = e.currentTarget.querySelector(input).value;

            retainedValues.push({
                input,
                currentValue,
                targetValue
            });
        });

        currentDragElement.innerHTML = e.currentTarget.innerHTML;
        transfereredValues.forEach((transferred) => {
            currentDragElement.querySelector(transferred.input).value = transferred.targetValue;
        });
        retainedValues.forEach((retained) => {
            currentDragElement.querySelector(retained.input).value = retained.currentValue;
        })

        e.currentTarget.innerHTML = e.dataTransfer.getData('text/html');
        transfereredValues.forEach((transferred) => {
            e.currentTarget.querySelector(transferred.input).value = transferred.currentValue;
        });
        retainedValues.forEach((retained) => {
            e.currentTarget.querySelector(retained.input).value = retained.targetValue;
        })
    }

    return false;
}
