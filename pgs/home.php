<?php global $conexao; ?> 
<!DOCTYPE html>
<html lang="pt-BR">
<?php
session_start();
include_once('../include/conexao.php');
$sql = "SELECT * FROM tb_documento";
$resultado = mysqli_query($conexao, $sql);
?>
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<h1>Selecione um Arquivo:</h1>
<?php
while ($registro = mysqli_fetch_assoc($resultado)) {
    $titulo = $registro['documento_titulo'];
    $id = $registro['id_documento'];
    echo '<a href="editor.php?id=' . $id . '">' . $titulo . ' ' . $id . '</a><br>';
}
?>
<a href="Editor.php">Novo Documento.</a>
<br>
<a href="cadastrar_colaborador.php">Cadastrar colaborador</a>
</body>
</html>