<?php session_start();
global $conn;
include_once('../include/conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = "Documento Sem Titulo";
    $conteudo = "Digite Aqui...";
    $id_user = $_SESSION['usuario_id'];

    $stmt = $conn->prepare("INSERT INTO documentos (titulo, conteudo,ID_Usuario) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $titulo, $conteudo, $id_user);

    if ($stmt->execute()) {
        $last_id = $conn->insert_id;
        echo "Redirecionando...";
        header('Location: ../pgs/admin/editor.php?id=' . $last_id);
        exit;
    } else {
        echo "Erro ao salvar: " . $stmt->error;
    }


    $stmt->close();
}

$conn->close();