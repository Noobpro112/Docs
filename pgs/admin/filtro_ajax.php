<?php
include_once('../../include/conexao.php');

// Captura os filtros enviados via AJAX
$pastas_selecionadas = isset($_POST['pastas']) ? $_POST['pastas'] : [];

// Construção da consulta com base nos filtros
if (!empty($pastas_selecionadas)) {
    $ids_pastas = implode(',', array_map('intval', $pastas_selecionadas));
    $sql = "SELECT * FROM documentos WHERE id_pasta IN ($ids_pastas)";
} else {
    $sql = "SELECT * FROM documentos"; // Se nenhuma pasta for selecionada, retorna todos os documentos
}

// Executa a consulta
$resultado = mysqli_query($conexao, $sql);

// Exibe os resultados filtrados
if ($resultado && mysqli_num_rows($resultado) > 0) {
    while ($registro = mysqli_fetch_assoc($resultado)) {
        $titulo = $registro['titulo'];
        $id = $registro['id'];
        echo '<a href="editor.php?id=' . $id . '">' . htmlspecialchars($titulo) . '</a><br>';
    }
} else {
    echo "Nenhum documento encontrado.";
}
?>
