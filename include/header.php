<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once(__DIR__ . "/conexao.php");
require_once(__DIR__ . "/../functions/funcoes_perfil.php");
?>

<style>
    .navbar {
        background-color: #1b1e23;
        padding: 10px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1000;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .nav-brand {
        color: white;
        text-decoration: none;
        font-size: 24px;
        font-weight: bold;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .user-name {
        color: white;
        font-size: 16px;
    }

    .user-pic {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #007bff;
        cursor: pointer;
    }

    /* Estilo para o dropdown do perfil */
    .user-dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        right: 0;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
        border-radius: 5px;
        margin-top: 5px;
    }

    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    .dropdown-content a:hover {
        background-color: #f1f1f1;
        border-radius: 5px;
    }

    .user-dropdown:hover .dropdown-content {
        display: block;
    }
    .main-container {
        margin-top: 60px; /* Mesma altura do navbar */
        padding: 20px;
        width: 100%;
        box-sizing: border-box;
    }

    /* Ajuste o body para todas as páginas */
    body {
        margin: 0;
        padding: 0;
        min-height: 100vh;
    }
</style>
</style>

<div class="navbar">
    <a href="../admin/home.php" class="nav-brand">T</a>

    <div class="user-info">
        <span class="user-name"><?php echo $_SESSION['usuario_nome']; ?></span>
        <div class="user-dropdown">
            <img src="<?php echo getProfilePicture(); ?>" alt="Foto do usuário" class="user-pic">
            <div class="dropdown-content">
                <a href="../admin/perfil.php">Perfil</a>
                <a href="../../functions/logout.php">Sair</a>
            </div>
        </div>
    </div>
</div>
<div class="main-container">