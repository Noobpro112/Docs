<?php
session_start();
include_once(__DIR__ . "/../include/conexao.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = $_SESSION['usuario_id'];
    $email = $conexao->real_escape_string($_POST['email']);
    $senha_atual = $_POST['current-password'];
    $nova_senha = $_POST['new-password'];
    $tema = isset($_POST['theme']) ? 1 : 0;

    // Debug para verificar os dados recebidos
    error_log("Arquivos recebidos: " . print_r($_FILES, true));

    // Verifica se a senha atual está correta
    $senha_atual_hash = hash('sha256', $senha_atual);
    $check_senha = "SELECT * FROM tb_usuario WHERE id_usuario = ? AND usuario_senha = ?";
    $stmt = $conexao->prepare($check_senha);
    $stmt->bind_param("is", $id_usuario, $senha_atual_hash);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        // Verifica se foi enviada uma imagem e se não houve erros
        if(isset($_FILES['profile-picture']) && $_FILES['profile-picture']['error'] === UPLOAD_ERR_OK && !empty($_FILES['profile-picture']['tmp_name'])) {
            // Lê o conteúdo do arquivo
            $foto = file_get_contents($_FILES['profile-picture']['tmp_name']);

            if ($foto === false) {
                error_log("Erro ao ler o arquivo de imagem");
                die('Erro ao ler o arquivo de imagem');
            }

            // Atualiza email e foto
            $query = "UPDATE tb_usuario SET usuario_email = ?, usuario_foto = ? WHERE id_usuario = ?";
            $stmt = $conexao->prepare($query);

            if (!$stmt) {
                error_log("Erro ao preparar a query: " . $conexao->error);
                die('Erro ao preparar a query: ' . $conexao->error);
            }

            // Bind dos parâmetros
            if (!$stmt->bind_param("ssi", $email, $foto, $id_usuario)) {
                error_log("Erro no bind_param: " . $stmt->error);
                die('Erro no bind_param: ' . $stmt->error);
            }

            // Executa a atualização
            if (!$stmt->execute()) {
                error_log("Erro na execução: " . $stmt->error);
                die('Erro na execução: ' . $stmt->error);
            }

            error_log("Atualização realizada com sucesso");
        } else {
            error_log("Nenhuma imagem enviada ou erro no upload");
            // Se não houver foto, atualiza apenas o email
            $query = "UPDATE tb_usuario SET usuario_email = ? WHERE id_usuario = ?";
            $stmt = $conexao->prepare($query);
            $stmt->bind_param("si", $email, $id_usuario);
            $stmt->execute();
        }

        // Se uma nova senha foi fornecida, atualiza ela também
        if(!empty($nova_senha)) {
            $nova_senha_hash = hash('sha256', $nova_senha);
            $query = "UPDATE tb_usuario SET usuario_senha = ? WHERE id_usuario = ?";
            $stmt = $conexao->prepare($query);
            $stmt->bind_param("si", $nova_senha_hash, $id_usuario);
            $stmt->execute();
        }

        $_SESSION['usuario_email'] = $email;
        header("Location: ../pgs/admin/perfil.php?status=success");
    } else {
        header("Location: ../pgs/admin/perfil.php?status=wrong_password");
    }
    exit;
}