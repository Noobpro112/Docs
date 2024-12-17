<?php global $conexao; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<?php
session_start();
include_once('../../include/conexao.php');
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Collab</title>
    <link rel="icon" type="image/x-icon" href="../../imgs/favicon.ico">
    <link rel="stylesheet" href="../../css/home_collab.css">
    <link rel="stylesheet" href="../../css/header.css"> <!--Link para CSS externo, os estilos estarão lá-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <!--Link para usar os icones da bootstrap-->
    <script src="https://kit.fontawesome.com/a760d1109c.js" crossorigin="anonymous"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');
        #link-cadastrarColaborador {
            display: none;
        }
    </style>
</head>

<body>
    <?php include_once("../../include/header.php"); ?>



</body>

</html>