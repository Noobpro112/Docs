<?php
global $conexao;
include_once('../../include/conexao.php');
$id = $_GET['id'];
$sql = "SELECT * FROM documentos where id =" . $id;
$resultado = mysqli_query($conexao, $sql);
while ($row = mysqli_fetch_assoc($resultado)) {
    $conteudo = $row['conteudo'];
    $titulo = $row['titulo'];
    $tamanho_fonte = $row['tamanho_fonte'];
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editor de Texto Rico</title>
    <style>
        .toolbar button {
            user-select: none;
        }
        img {
            transition: all 0.3s ease;
        }
        img:hover {
            box-shadow: 0 0 0 2px #007bff;
        }
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
<div class="container"> <!-- Botões -->
    <div class="toolbar" contenteditable="false">
        <button type="button" onclick="adjustFontSize(-1)">Diminuir Fonte</button>
        <span id="font-size-display">14px</span>
        <button type="button" onclick="adjustFontSize(1)">Aumentar Fonte</button>
        <button type="button" onclick="formatText('bold')">Negrito</button>
        <button type="button" onclick="formatText('italic')">Itálico</button>
        <button type="button" onclick="formatText('underline')">Sublinhado</button>
        <button type="button" onclick="formatText('strikeThrough')">Tachado</button>
        <div class="color-picker-wrapper">
            <input type="color" id="text-color-picker" onchange="setColor(this.value)">
            <label for="text-color-picker">Cor do Texto</label>
        </div>
        <div class="color-picker-wrapper">
            <input type="color" id="highlight-color-picker" value="#ffffff" onchange="setHighlightColor(this.value)">
            <label for="highlight-color-picker">Grifar</label>
        </div>
        <button type="button" onclick="alignText('left')">Alinhar Esquerda</button>
        <button type="button" onclick="alignText('center')">Centralizar</button>
        <button type="button" onclick="alignText('right')">Alinhar Direita</button>
        <!-- <button type="button" onclick="alignText('justify')">Justificar</button>  Achei esse botão meio inutil então vou tirar-->
        <button type="button" onclick="insertList('insertUnorderedList')">Lista com Marcadores</button>
        <button type="button" onclick="insertList('insertOrderedList')">Lista Numerada</button>
        <input type="text" id="Titulo" name="Titulo" value="<?php echo $titulo ?>" placeholder="Titulo">
        <a href="home.php"><button type="button">Voltar</button></a>
        <button type="button" onclick="triggerImageUpload()">Inserir Imagem</button>
        <input type="file" id="imageUpload" style="display: none;" accept="image/*">
        <input type="hidden" id="id" name="id" value="<?php echo $id; ?>"> <!-- não mexe nessa porra não, vou deixar aqui quietinho e deixa ele ae escondidinho. no maximo troca ele de lugar no html mas ele tem que estar no código-->
    </div> <!-- Fim Botões -->

    <div id="editor" contenteditable="true" style="font-size: <?php echo $tamanho_fonte; ?>px;">
        <?php echo $conteudo ?>
    </div> <!-- Aonde o usuario digita -->
</div>

<script src="../../js/editor.js"></script>
<script src="../../js/ajax.js"></script>
<script>
    document.getElementById("Titulo").addEventListener("input", Salva_Conteudo);
    document.getElementById("editor").addEventListener("input", Salva_Conteudo);
    setInterval(Salva_Conteudo, 2000);
</script>
</body>
</html>