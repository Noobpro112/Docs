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
    $stmt->bind_param("ssii", $titulo, $conteudo, $tamanho_fonte, $id);
    if (isset($_FILES['image'])) {
        $uploadDir = 'uploads/';
        $uploadFile = $uploadDir . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            echo json_encode(['success' => true, 'url' => $uploadFile]);
        } else {
            echo json_encode(['success' => false]);
        }
        exit;
    }

    if ($stmt->execute()) {
        echo "Conteúdo atualizado com sucesso.";
    } else {
        echo "Erro ao atualizar: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();

