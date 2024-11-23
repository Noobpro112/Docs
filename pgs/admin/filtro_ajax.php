<?php
include_once('../../include/conexao.php');

$pastas_selecionadas = isset($_POST['pastas']) ? $_POST['pastas'] : []; // Criar uma varíavel para guardar as informações que vieram do AJAX, que no caso foram guardadas na chaves pastas lá na definição do AJAX, o ? é um operador ternário que caso a condição isset($_POST['pastas']) for igual a TRUE entrão ele guarda os valores, caso contrário define uma array vazia. O ':' seria o ELSE. lembrando que pastas é uma array que contém os ids das pastas que foram selecionadas para filtro

// Construção da consulta com base nos filtros
if (!empty($pastas_selecionadas)) { //Verifica se há pastas selecionadas
    $ids_pastas = implode(',', array_map('intval', $pastas_selecionadas)); // Cria uma variável para guardar os ids e passa eles para inteiros (intval), para isso é usado o método array_map, que vai passar por todos os elementos de uma array que no caso é a pastas_selecionadas. Já o implode pega esses elementos já transformados em inteiros e guarda todos em uma STRING que por sua vez separa os elementos por vírgulas
    $sql = "SELECT * FROM documentos WHERE id_pasta IN ($ids_pastas) ORDER BY titulo ASC"; //Define a consulta com todos os ids selecionados 
} else {
    $sql = "SELECT * FROM documentos ORDER BY titulo ASC"; // Se nenhuma pasta for selecionada, retorna todos os documentos
}

// Executa a consulta
$resultado = mysqli_query($conexao, $sql);

// Exibe os resultados filtrados
if ($resultado && mysqli_num_rows($resultado) > 0) {
    while ($registro = mysqli_fetch_assoc($resultado)) {
        $titulo = $registro['titulo'];
        $id = $registro['id'];
        //Ancora que vai levar o usuário até o editor, para o mesmo editar o documento selecionado
        echo '<a href="editor.php?id=' . $id . '">' . htmlspecialchars($titulo) . '</a><br>';
    }
} else {
    echo "Nenhum documento encontrado.";
}
?>
