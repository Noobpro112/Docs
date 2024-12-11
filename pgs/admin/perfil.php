<?php
// Inicia a sessão do usuário
session_start();

// Inclui arquivos necessários para conexão com banco de dados e funções
require_once("../../include/conexao.php");
require_once("../../functions/funcoes_perfil.php");

// Verifica se usuário está logado, se não, redireciona para página de login
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Usuário</title>
    <style>
        /* Reset básico de CSS */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        /* Estilo do corpo da página - centraliza todo o conteúdo */
        body {
            background-color: #f5f5f5;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        /* Container principal do perfil */
        .profile-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }

        /* Cabeçalho do perfil - contém foto e nome */
        .profile-header {
            text-align: center;
            margin-bottom: 30px;
        }

        /* Container da foto de perfil */
        .profile-pic-container {
            position: relative;
            width: 150px;
            height: 150px;
            margin: 0 auto 20px;
        }

        /* Estilo da imagem de perfil */
        .profile-pic {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #007bff;
        }

        /* Botão de edição da foto de perfil */
        .edit-pic-btn {
            position: absolute;
            bottom: 5px;
            right: 5px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Estilo dos grupos de formulário */
        .form-group {
            margin-bottom: 20px;
        }

        /* Estilo das labels dos campos */
        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: bold;
        }

        /* Estilo dos campos de input */
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        /* Container do toggle de tema */
        .theme-toggle {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0;
        }

        /* Estilo do switch de tema */
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        /* Esconde o checkbox padrão */
        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        /* Estilo do slider do switch */
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }

        /* Botão do slider */
        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        /* Estado ativo do switch */
        input:checked + .slider {
            background-color: #007bff;
        }

        /* Movimento do botão do switch quando ativo */
        input:checked + .slider:before {
            transform: translateX(26px);
        }

        /* Estilo do botão de salvar */
        .save-btn {
            background: #007bff;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 5px;
            width: 100%;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }

        /* Hover do botão de salvar */
        .save-btn:hover {
            background: #0056b3;
        }

        /* Esconde o input de arquivo */
        #file-input {
            display: none;
        }
        /* Estilo do aviso de segurança */
        .security-notice {
            background-color: #e8f5ff;
            border-left: 4px solid #007bff;
            padding: 10px 15px;
            margin: 15px 0;
            border-radius: 4px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            color: #155724;
            text-align: left;
        }

        .security-icon {
            font-size: 16px;
            flex-shrink: 0;
        }
    </style>
</head>
<body>
<!-- Container principal do perfil -->

<div class="profile-container">
    <!-- Formulário principal -->
    <form action="../../functions/perfil_atuaizar.php" method="POST" enctype="multipart/form-data">
        <!-- Cabeçalho com foto e nome -->
        <div class="profile-header">
            <!-- Container da foto de perfil -->
            <div class="profile-pic-container">
                <!-- Imagem de perfil -->
                <img src="<?php echo getProfilePicture(); ?>" alt="Foto de perfil" class="profile-pic" id="preview-pic">
                <!-- Botão de edição da foto -->
                <button type="button" class="edit-pic-btn" onclick="document.getElementById('file-input').click();">
                    ✏️
                </button>
                <!-- Input oculto para upload de arquivo -->
                <input type="file" id="file-input" name="profile-picture" accept="image/jpeg,image/png,image/gif"
                       onchange="previewImage(this);">
            </div>
            <!-- Aviso de segurança -->
            <div class="security-notice">
                <i class="security-icon">🔒</i>
                <span>Para alterar sua foto de perfil, é necessário confirmar sua senha atual</span>
            </div>
            <!-- Nome do usuário -->
            <h2><?php echo $_SESSION['usuario_nome']; ?></h2>
        </div>

        <!-- Campo de email -->
        <div class="form-group">
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" value="<?php echo $_SESSION['usuario_email']; ?>">
        </div>

        <!-- Campo de senha atual -->
        <div class="form-group">
            <label for="current-password">Senha Atual:</label>
            <input type="password" id="current-password" name="current-password">
        </div>

        <!-- Campo de nova senha -->
        <div class="form-group">
            <label for="new-password">Nova Senha:</label>
            <input type="password" id="new-password" name="new-password">
        </div>

        <!-- Toggle de tema -->
        <div class="theme-toggle">
            <span>Tema:</span>
            <label class="toggle-switch">
                <input type="checkbox" name="theme" id="theme">
                <span class="slider"></span>
            </label>
        </div>

        <!-- Botão de salvar -->
        <button type="submit" class="save-btn">Salvar Alterações</button>
    </form>
    <a href="home.php">
        <br>
    <button type="submit" class="save-btn">Voltar</button>
    </a>

    <!-- Script para preview da imagem -->
    <script>
        // Função para mostrar preview da imagem selecionada
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    // Atualiza a imagem de preview com o arquivo selecionado
                    document.getElementById('preview-pic').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>