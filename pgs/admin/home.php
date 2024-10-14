<?php global $conexao; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<?php
session_start();
include_once('../../include/conexao.php');
$sql = "SELECT * FROM documentos";
$resultado = mysqli_query($conexao, $sql);
?>
<head>
    <meta charset="UTF-8">
    <title>HOME ADM</title>
</head>
<body>
<h1>Selecione um Arquivo:</h1>
<?php
while ($registro = mysqli_fetch_assoc($resultado)) {
    $titulo = $registro['titulo'];
    $id = $registro['id'];
    echo '<a href="editor.php?id=' . $id . '">' . $titulo . ' ' . $id . '</a><br>'; // AQUI ELE TA MOSTRANDO OS ARQUIVOS. então você pode colocar como um botão ou da forma que preferir.
}
?>
<form method="post" action=../../functions/criar_documento.php>
<button type="submit">Novo Documento.</button>
</form>
<br>
<a href="cadastrar_colaborador.php">Cadastrar colaborador</a>
</body>
</html>