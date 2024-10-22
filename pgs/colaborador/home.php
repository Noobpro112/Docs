<?php global $conexao; ?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Collab</title>
    <link rel="icon" type="image/x-icon" href="../../imgs/favicon.ico">
    <link rel="stylesheet" href="../../css/home_collab.css">
    <link rel="stylesheet" href="../../css/header.css"> <!--Link para CSS externo, os estilos estarão lá-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"><!--Link para usar os icones da bootstrap-->
    <script src="https://kit.fontawesome.com/a760d1109c.js" crossorigin="anonymous"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');
    </style>
</head>

<body>
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
                <i class="fa-solid fa-user"></i>
            </button>
        </div>

    </header>
    <div class="menuDropDown" id="menuDropDown">
        <p>Colaborador Nome</p> <!--Puxar do banco de dados o nome do colaborador!!!!!-->
        <a href="#">
            <i class="fa-solid fa-gear"></i>
            <label>Configurações</label>
        </a>

        <a href="#">
            <i class="fa-solid fa-right-from-bracket"></i>
            <label>Logout</label>
        </a>
    </div>

    <script>
        function toggleMenu() {
            const menu = document.getElementById('menuDropDown');
            menu.classList.toggle('show');
        }

        window.onclick = function(event) {
            const menu = document.getElementById('menuDropDown');
            const icon = document.querySelector('.circle');
            if (!menu.contains(event.target) && !icon.contains(event.target)) {
                menu.classList.remove('show'); 
            }
        }
    </script>

</body>

</html>