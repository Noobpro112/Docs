<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editor de Texto Rico</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
        }

        .container {
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        .toolbar {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            padding: 10px;
            background-color: #f0f0f0;
        }

        .toolbar button, .toolbar select {
            padding: 5px 10px;
        }

        .color-picker-wrapper {
            display: flex;
            align-items: center;
        }

        .color-picker-wrapper input[type="color"] {
            margin-right: 5px;
        }

        #editor {
            flex-grow: 1;
            overflow-y: auto;
            padding: 10px;
            font-size: 14px;
        }

        #font-size-display {
            margin: 0 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="toolbar">
        <button onclick="adjustFontSize(-1)">Diminuir Fonte</button>
        <span id="font-size-display">14px</span>
        <button onclick="adjustFontSize(1)">Aumentar Fonte</button>
        <button onclick="formatText('bold')">Negrito</button>
        <button onclick="formatText('italic')">Itálico</button>
        <button onclick="formatText('underline')">Sublinhado</button>
        <button onclick="formatText('strikeThrough')">Tachado</button>
        <div class="color-picker-wrapper">
            <input type="color" id="text-color-picker" onchange="setColor(this.value)">
            <label for="text-color-picker">Cor do Texto</label>
        </div>
        <div class="color-picker-wrapper">
            <input type="color" id="highlight-color-picker" value="#ffffff" onchange="setHighlightColor(this.value)">
            <label for="highlight-color-picker">Grifar</label>
        </div>
        <button onclick="alignText('left')">Alinhar Esquerda</button>
        <button onclick="alignText('center')">Centralizar</button>
        <button onclick="alignText('right')">Alinhar Direita</button>
        <button onclick="alignText('justify')">Justificar</button>
        <button onclick="insertList('insertUnorderedList')">Lista com Marcadores</button>
        <button onclick="insertList('insertOrderedList')">Lista Numerada</button>
    </div>

    <div id="editor" contenteditable="true">
        Comece a digitar aqui...
    </div>
</div>

<script src="../js/editor.js"></script>
</body>
</html>