// Variáveis globais
const editor = document.getElementById('editor');
const fontSizeDisplay = document.getElementById('font-size-display');
let currentFontSize = 14;
let draggedImage = null;

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

// Função para inserção de imagem
function handleImageUpload(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            var img = document.createElement('img');
            img.src = e.target.result;
            img.style.maxWidth = '100%';
            img.style.verticalAlign = 'middle';
            img.draggable = true;

            // Adicionar event listeners para arrastar
            img.addEventListener('dragstart', handleDragStart);
            img.addEventListener('dragend', handleDragEnd);

            // Inserir a imagem na posição do cursor
            insertImageAtCursor(img);

            Salva_Conteudo();
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function insertImageAtCursor(img) {
    const selection = window.getSelection();
    if (selection.rangeCount) {
        const range = selection.getRangeAt(0);
        if (!isInsideToolbar(range.startContainer)) {
            range.insertNode(img);
            range.collapse(false);
            selection.removeAllRanges();
            selection.addRange(range);
        } else {
            console.warn("Não é permitido inserir imagens na toolbar.");
        }
    } else {
        editor.appendChild(img);
    }
}

function isInsideToolbar(node) {
    while (node != null) {
        if (node.classList && node.classList.contains('toolbar')) {
            return true;
        }
        node = node.parentNode;
    }
    return false;
}

// Funções para arrastar imagens
function handleDragStart(e) {
    draggedImage = e.target;
    e.dataTransfer.setData('text/plain', '');
    e.target.style.opacity = '0.5';
    e.target.style.border = '2px dashed #007bff';
}

function handleDragEnd(e) {
    e.target.style.opacity = '';
    e.target.style.border = '';
    draggedImage = null;
}

function handleDragOver(e) {
    e.preventDefault();
    e.dataTransfer.dropEffect = 'move';
    highlightDropZone(e);
}

function handleDragLeave(e) {
    removeDropZoneHighlight();
}

function handleDrop(e) {
    e.preventDefault();
    removeDropZoneHighlight();
    if (draggedImage && e.target !== draggedImage) {
        const range = document.caretRangeFromPoint(e.clientX, e.clientY);
        if (range && !isInsideToolbar(range.startContainer)) {
            range.insertNode(draggedImage);
            Salva_Conteudo();
        }
    }
}

function highlightDropZone(e) {
    const dropZone = getDropZone(e.clientX, e.clientY);
    if (dropZone) {
        dropZone.style.backgroundColor = 'rgba(0, 123, 255, 0.1)';
        dropZone.style.border = '2px dashed #007bff';
    }
}

function removeDropZoneHighlight() {
    const previousDropZone = editor.querySelector('.drop-zone-highlight');
    if (previousDropZone) {
        previousDropZone.style.backgroundColor = '';
        previousDropZone.style.border = '';
        previousDropZone.classList.remove('drop-zone-highlight');
    }
}

function getDropZone(x, y) {
    const range = document.caretRangeFromPoint(x, y);
    if (range && editor.contains(range.commonAncestorContainer)) {
        let node = range.commonAncestorContainer;
        while (node !== editor) {
            if (node.nodeType === Node.ELEMENT_NODE) {
                node.classList.add('drop-zone-highlight');
                return node;
            }
            node = node.parentNode;
        }
        return editor;
    }
    return null;
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

function makeImagesDraggable() {
    const images = editor.querySelectorAll('img');
    images.forEach(img => {
        img.draggable = true;
        img.addEventListener('dragstart', handleDragStart);
        img.addEventListener('dragend', handleDragEnd);
    });
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
editor.addEventListener('dragover', handleDragOver);
editor.addEventListener('drop', handleDrop);
editor.addEventListener('dragover', handleDragOver);
editor.addEventListener('dragleave', handleDragLeave);
editor.addEventListener('drop', handleDrop);

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
makeImagesDraggable();

function handleImageUpload(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            var img = document.createElement('img');
            img.src = e.target.result;
            img.style.maxWidth = '100%';
            img.style.verticalAlign = 'middle';

            insertImageAtCursor(img);
            makeImagesDraggable(); // Torna a nova imagem arrastável
            Salva_Conteudo();
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function triggerImageUpload() {
    document.getElementById('imageUpload').click();
}