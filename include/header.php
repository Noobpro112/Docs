<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once(__DIR__ . "/conexao.php");
require_once(__DIR__ . "/../functions/funcoes_perfil.php");
?>

<style>
   :root {
    --primary-color: #121820;
    --primary-font: "Montserrat", sans-serif;
}


header {
    background-color: var(--primary-color);
    display: flex;
    justify-content:space-between;
    padding: 20px 10%;
    align-items: center;
    position: relative; /* Para controlar o z-index */
    z-index: 9999;
}


.circle {
    background-color: #fff;
    border-radius: 30px;
    width: 50px;
    height: 50px;
    display: flex;
    justify-content: center;
    align-items: center;
    border: none;
    cursor: pointer;
}

.circle img {
    width: 45px;
    height: auto;
    border-radius: 100%;
}

.menuDropDown {
    background-color: var(--primary-color);
    opacity: 0;
    width: fit-content;
    height: fit-content;
    padding: 25px 40px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: start;
    position: absolute;
    right: 45px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    transform: translateY(-100%);
    visibility: hidden;
    transition: all 0.3s ease;
    z-index: 100;
}

.menuDropDown.show {
    transform: translateY(0);
    opacity: 0.8;
    visibility: visible;
  }

.menuDropDown p {
    color: #fff;
    font-size: 17px;
    font-weight: 600;
    font-family: var(--primary-font);
    margin: 15px 0px;
}

.menuDropDown a {
    display: flex;
    padding: 15px 10px;
    border-top: 1px solid #fff;
    width: 100%;
    text-decoration: none;
    align-items: center;
}

.menuDropDown a i {
    color:#fff;
    font-size: 18px;
    margin-right: 15px;
}

.menuDropDown a label {
    color: #fff;
    font-size: 17px;
    font-family: var(--primary-font);
}


.menuDropDown a:hover {
    background-color: #444;
}


.headerBusca {
    background-color: #fff;
    padding: 1px 1px;
    border-radius: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.headerBusca input {
    border: none;
    padding: 8px 0px 8px 20px;
    border-top-left-radius: 30px;
    border-bottom-left-radius: 30px;
    width: 350px;
    font-size: 15px;
    font-family: var(--primary-font);
}

.headerBusca i {
    font-size: 20px;
    color: var(--primary-color);
    padding: 5px 10px;
    border-left: 1px solid #bbbbbb;
}


</style>

<script>
    // Function pro dropdown do header
    function toggleMenu() {
            const menu = document.getElementById('menuDropDown');
            menu.classList.toggle('show');
        }

        window.onclick = function (event) {
            const menu = document.getElementById('menuDropDown');
            const icon = document.querySelector('.circle');
            if (!menu.contains(event.target) && !icon.contains(event.target)) {
                menu.classList.remove('show');
            }
        }
</script>

<header>
    <div class="headerLogo">
        <a href="home.php"><img src="../../imgs/logo-branca-t.png" alt="Logo" width="80px"></a>
    </div>
    <div class="headerBusca">
        <input type="text" id="" name="" placeholder="Pesquisa...">
        <i class="fa-solid fa-magnifying-glass"></i>
    </div>
    <div class="DropDown" id="menu-icon">
        <button class="circle" onclick="toggleMenu()">
            <img src="<?php echo getProfilePicture(); ?>" alt="Foto do usuário" class="user-pic">
        </button>
    </div>
</header>

<div class="menuDropDown" id="menuDropDown">
    <p><?php echo $_SESSION['usuario_nome']; ?></p> <!--Puxar do banco de dados o nome do colaborador!!!!!-->
    <a href="/perfil.php">
        <i class="fa-solid fa-gear"></i>
        <label>Configurações</label>
    </a>

    <a href="../../functions/logout.php">
        <i class="fa-solid fa-right-from-bracket"></i>
        <label>Logout</label>
    </a>
</div>

<div class="main-container">