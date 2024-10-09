const editor = document.getElementById('editor');
const fontSizeDisplay = document.getElementById('font-size-display');
let currentFontSize = 14;

function formatText(command, value = null) {
    document.execCommand(command, false, value);
    editor.focus();
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

function alignText(alignment) {
    document.execCommand(alignment, false, null);
}

function insertList(command) {
    formatText(command);
}

editor.addEventListener('keyup', updateToolbar);
editor.addEventListener('mouseup', updateToolbar);

function updateToolbar() {
    // Atualizar a exibição do tamanho da fonte se necessário
    const selection = window.getSelection();
    if (selection.rangeCount > 0) {
        const range = selection.getRangeAt(0);
        const fontSize = window.getComputedStyle(range.startContainer.parentElement).fontSize;
        currentFontSize = parseInt(fontSize);
        fontSizeDisplay.textContent = `${currentFontSize}px`;
    }
}

// Inicializar a barra de ferramentas
updateToolbar();