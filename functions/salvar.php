<?php
include_once("../include/conexao.php");
global $conn;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $conteudo = $_POST['conteudo'];
    $id = $_POST['id'];
    $tamanho_fonte = $_POST['tamanho_fonte'];

    // Prepare a atualização
    $stmt = $conn->prepare("UPDATE documentos SET titulo = ?, conteudo = ?, tamanho_fonte = ? WHERE id = ?");
    $stmt->bind_param("ssii", $titulo, $conteudo, $tamanho_fonte, $id); // Bind para o novo campo

    if ($stmt->execute()) {
        echo "Conteúdo atualizado com sucesso.";
    } else {
        echo "Erro ao atualizar: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
