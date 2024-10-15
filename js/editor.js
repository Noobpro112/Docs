// Variáveis globais
const editor = document.getElementById('editor');
const fontSizeDisplay = document.getElementById('font-size-display');
let currentFontSize = 14;
let isResizing = false;
let isDragging = false;
let currentImage = null;
let startX, startY, startLeft, startTop, startWidth, startHeight;
let resizeHandle = '';

// Funções de formatação de texto
function formatText(command, value = null) {
    ensureFocusOnEditor();
    document.execCommand(command, false, value);
}

function adjustFontSize(change) {
    currentFontSize = Math.max(8, Math.min(36, currentFontSize + change));
    editor.style.fontSize = `${currentFontSize}px`;
    fontSizeDisplay.textContent = `${currentFontSize}px`;
    editor.focus();
}

function setColor(color) {
    formatText('foreColor', color);
}

function setHighlightColor(color) {
    formatText('hiliteColor', color);
}

function insertList(command) {
    formatText(command);
}

function alignText(alignment) {
    ensureFocusOnEditor();
    document.execCommand('justifyLeft', false, null);
    if (alignment !== 'left') {
        document.execCommand(`justify${alignment.charAt(0).toUpperCase() + alignment.slice(1)}`, false, null);
    }
    updateAlignmentButtons();
}

// Funções de manipulação de imagens
function createResizeHandles(img) {
    const handles = ['nw', 'ne', 'sw', 'se'];
    handles.forEach(handle => {
        const div = document.createElement('div');
        div.className = `resize-handle ${handle}-resize`;
        div.style.position = 'absolute';
        div.style.width = '10px';
        div.style.height = '10px';
        div.style.background = 'blue';
        div.style.cursor = `${handle}-resize`;
        img.parentNode.appendChild(div);
    });
    positionResizeHandles(img);
}

function positionResizeHandles(img) {
    const handles = img.parentNode.querySelectorAll('.resize-handle');
    const rect = img.getBoundingClientRect();
    const container = img.parentNode.getBoundingClientRect();

    handles.forEach(handle => {
        if (handle.className.includes('nw')) {
            handle.style.left = `${rect.left - container.left - 5}px`;
            handle.style.top = `${rect.top - container.top - 5}px`;
        } else if (handle.className.includes('ne')) {
            handle.style.left = `${rect.right - container.left - 5}px`;
            handle.style.top = `${rect.top - container.top - 5}px`;
        } else if (handle.className.includes('sw')) {
            handle.style.left = `${rect.left - container.left - 5}px`;
            handle.style.top = `${rect.bottom - container.top - 5}px`;
        } else if (handle.className.includes('se')) {
            handle.style.left = `${rect.right - container.left - 5}px`;
            handle.style.top = `${rect.bottom - container.top - 5}px`;
        }
    });
}

function wrapImageInContainer(img) {
    const container = document.createElement('div');
    container.style.position = 'relative';
    container.style.display = 'inline-block';
    container.style.cursor = 'move';
    img.parentNode.insertBefore(container, img);
    container.appendChild(img);
    createResizeHandles(img);
    return container;
}

function initImageInteraction(e) {
    if (e.target.tagName.toLowerCase() === 'img' || e.target.className.includes('resize-handle')) {
        if (e.target.tagName.toLowerCase() === 'img') {
            currentImage = e.target.parentNode;
        } else {
            currentImage = e.target.parentNode;
            resizeHandle = e.target.className.split(' ')[1].split('-')[0];
        }

        startX = e.clientX;
        startY = e.clientY;
        startLeft = currentImage.offsetLeft;
        startTop = currentImage.offsetTop;
        startWidth = currentImage.firstChild.clientWidth;
        startHeight = currentImage.firstChild.clientHeight;

        if (e.target.className.includes('resize-handle')) {
            isResizing = true;
        } else {
            isDragging = true;
        }

        document.addEventListener('mousemove', handleImageInteraction);
        document.addEventListener('mouseup', stopImageInteraction);
        e.preventDefault();
    }
}

function handleImageInteraction(e) {
    if (isResizing) {
        resizeImage(e);
    } else if (isDragging) {
        dragImage(e);
    }
}

function resizeImage(e) {
    const dx = e.clientX - startX;
    const dy = e.clientY - startY;
    let newWidth, newHeight;

    if (resizeHandle.includes('e')) {
        newWidth = startWidth + dx;
    } else if (resizeHandle.includes('w')) {
        newWidth = startWidth - dx;
    }

    if (resizeHandle.includes('s')) {
        newHeight = startHeight + dy;
    } else if (resizeHandle.includes('n')) {
        newHeight = startHeight - dy;
    }

    // Manter proporção
    const ratio = startWidth / startHeight;
    if (newWidth && !newHeight) {
        newHeight = newWidth / ratio;
    } else if (newHeight && !newWidth) {
        newWidth = newHeight * ratio;
    }

    currentImage.firstChild.style.width = `${newWidth}px`;
    currentImage.firstChild.style.height = `${newHeight}px`;
    positionResizeHandles(currentImage.firstChild);
}

function dragImage(e) {
    const dx = e.clientX - startX;
    const dy = e.clientY - startY;
    currentImage.style.left = `${startLeft + dx}px`;
    currentImage.style.top = `${startTop + dy}px`;
    positionResizeHandles(currentImage.firstChild);
}

function stopImageInteraction() {
    isResizing = false;
    isDragging = false;
    document.removeEventListener('mousemove', handleImageInteraction);
    document.removeEventListener('mouseup', stopImageInteraction);
    Salva_Conteudo();
}

function handleImageUpload(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            ensureFocusOnEditor();
            var img = document.createElement('img');
            img.src = e.target.result;
            img.style.maxWidth = '100%';

            var selection = window.getSelection();
            var range = selection.getRangeAt(0);
            range.insertNode(img);
            range.setStartAfter(img);
            range.setEndAfter(img);
            selection.removeAllRanges();
            selection.addRange(range);

            wrapImageInContainer(img);
            Salva_Conteudo();
        }
        reader.readAsDataURL(input.files[0]);
    }
}

// Funções de atualização da interface
function updateToolbar() {
    const selection = window.getSelection();
    if (selection.rangeCount > 0) {
        const range = selection.getRangeAt(0);
        const fontSize = window.getComputedStyle(range.startContainer.parentElement).fontSize;
        currentFontSize = parseInt(fontSize);
        fontSizeDisplay.textContent = `${currentFontSize}px`;
    }
}

function updateAlignmentButtons() {
    const alignments = ['left', 'center', 'right', 'justify'];
    const selection = window.getSelection();
    if (selection.rangeCount > 0) {
        const parentElement = selection.getRangeAt(0).commonAncestorContainer;
        const computedStyle = window.getComputedStyle(parentElement);
        const textAlign = computedStyle.textAlign;

        alignments.forEach(align => {
            const button = document.querySelector(`button[onclick="alignText('${align}')"]`);
            if (button) {
                button.classList.remove('active');
                if ((align === 'left' && textAlign === 'start') || (align !== 'left' && textAlign === align)) {
                    button.classList.add('active');
                }
            }
        });
    }
}

function ensureFocusOnEditor() {
    const selection = window.getSelection();
    if (!editor.contains(selection.anchorNode) || selection.anchorNode.nodeType === Node.ELEMENT_NODE) {
        editor.focus();
        const range = document.createRange();
        range.setStart(editor, editor.childNodes.length);
        range.collapse(true);
        selection.removeAllRanges();
        selection.addRange(range);
    }
}

// Event listeners
editor.addEventListener('keyup', updateToolbar);
editor.addEventListener('mouseup', updateToolbar);
editor.addEventListener('mouseup', updateAlignmentButtons);
editor.addEventListener('keyup', updateAlignmentButtons);
document.addEventListener('mousedown', initImageInteraction);

editor.addEventListener('mousedown', function(e) {
    if (e.target.tagName.toLowerCase() === 'img' || e.target.className.includes('resize-handle')) {
        e.preventDefault();
    }
});

document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('imageUpload').addEventListener('change', function () {
        handleImageUpload(this);
    });

    const toolbar = document.querySelector('.toolbar');
    toolbar.addEventListener('mousedown', function (e) {
        if (e.target.tagName === 'BUTTON') {
            e.preventDefault();
        }
    });
});

// Inicialização
updateAlignmentButtons();
updateToolbar();

function triggerImageUpload() {
    document.getElementById('imageUpload').click();
}