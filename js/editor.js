const editor = document.getElementById('editor');
const fontSizeDisplay = document.getElementById('font-size-display');
let currentFontSize = 14;

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

editor.addEventListener('keyup', updateToolbar);
editor.addEventListener('mouseup', updateToolbar);

function updateToolbar() {
    const selection = window.getSelection();
    if (selection.rangeCount > 0) {
        const range = selection.getRangeAt(0);
        const fontSize = window.getComputedStyle(range.startContainer.parentElement).fontSize;
        currentFontSize = parseInt(fontSize);
        fontSizeDisplay.textContent = `${currentFontSize}px`;
    }
}

function alignText(alignment) {
    ensureFocusOnEditor();
    document.execCommand('justifyLeft', false, null);
    if (alignment !== 'left') {
        document.execCommand(`justify${alignment.charAt(0).toUpperCase() + alignment.slice(1)}`, false, null);
    }
    updateAlignmentButtons();
}

function triggerImageUpload() {
    document.getElementById('imageUpload').click();
}

function handleImageUpload(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            ensureFocusOnEditor();
            var img = document.createElement('img');
            img.src = e.target.result;
            img.style.maxWidth = '100%';
            img.style.cursor = 'nwse-resize';
            img.addEventListener('mousedown', initResize);

            var selection = window.getSelection();
            var range = selection.getRangeAt(0);
            range.insertNode(img);
            range.setStartAfter(img);
            range.setEndAfter(img);
            selection.removeAllRanges();
            selection.addRange(range);

            Salva_Conteudo();
        }
        reader.readAsDataURL(input.files[0]);
    }
}

let isResizing = false;
let currentImage;

function initResize(e) {
    isResizing = true;
    currentImage = e.target;
    e.preventDefault();
    document.addEventListener('mousemove', resize);
    document.addEventListener('mouseup', stopResize);
}

function resize(e) {
    if (isResizing) {
        currentImage.style.width = (e.pageX - currentImage.offsetLeft) + 'px';
    }
}

function stopResize() {
    isResizing = false;
    document.removeEventListener('mousemove', resize);
    Salva_Conteudo();  // Salva o conteúdo após redimensionar a imagem
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
    if (!editor.contains(selection.anchorNode)) {
        editor.focus();
        const range = document.createRange();
        range.setStart(editor, editor.childNodes.length);
        range.collapse(true);
        selection.removeAllRanges();
        selection.addRange(range);
    }
}

editor.addEventListener('mouseup', updateAlignmentButtons);
editor.addEventListener('keyup', updateAlignmentButtons);
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('imageUpload').addEventListener('change', function () {
        handleImageUpload(this);
    });
});
document.addEventListener('DOMContentLoaded', function () {
    const toolbar = document.querySelector('.toolbar');
    toolbar.addEventListener('mousedown', function (e) {
        if (e.target.tagName === 'BUTTON') {
            e.preventDefault();
        }
    });
});

updateAlignmentButtons();

updateToolbar();

// isso aqui é o puro suco do chatgpt, não me culpem mó bagulho do caralho isso aqui