const editor = document.getElementById('editor');
const titleInput = document.getElementById('titleInput');
const boldBtn = document.getElementById('boldBtn');
const italicBtn = document.getElementById('italicBtn');
const underlineBtn = document.getElementById('underlineBtn');
const saveBtn = document.getElementById('saveBtn');

boldBtn.addEventListener('click', () => {
    document.execCommand('bold', false, null); 
});

italicBtn.addEventListener('click', () => {
    document.execCommand('italic', false, null); 
});

underlineBtn.addEventListener('click', () => {
    document.execCommand('underline', false, null);
});

function saveDocument() {
    const content = editor.innerHTML;
    const title = titleInput.value;
    const documentId = editor.dataset.documentId || '';

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "save.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (this.status == 200) {
            alert(this.responseText);
            if (!documentId) {
                // Se for um novo documento, redireciona para a página de edição com o novo ID
                window.location.href = 'editor.php?id=' + this.responseText;
            }
        }
    };
    xhr.send("content=" + encodeURIComponent(content) + "&title=" + encodeURIComponent(title) + "&id=" + encodeURIComponent(documentId));
}

saveBtn.addEventListener('click', saveDocument);
