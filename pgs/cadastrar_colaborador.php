<?php global $conexao; ?> 
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar</title>
    <link rel="stylesheet" href="../css/cadastrar_colaborador.css"> <!--Link para CSS externo, os estilos estarão lá-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"><!--Link para usar os icones da bootstrap-->

</head>
<body>
    <main>
        <!--Forms para a box onde o admin vai colocar as informações para cadastro-->
        <form class="InsertBox">
            <h5>Nome</h5> <!--H5 para o nome-->
            <input type="text" name="nome"> <!--Input para inserir nome-->
            <br>
            <br>
            <h5>Email</h5> <!--H5 para o email-->
            <input type="email" name="email"> <!--Input para inserir email-->
            <br>
            <br>
            <h5>Senha</h5> <!--H5 para a senha-->
            <input type="password" name="senha"> <!--Input para inserir senha-->
            <br>
            <br>
            <input type="submit" name="Enviar" value="Cadastrar"> <!--Input para enviar as informações para o banco de dados-->
        </form>

        <!--form para buscar pelo nome dos colaboradores-->
        <div class="BarraPesquisa">
            <!-- Local onde ficará a imagem da lupa para pequisa por usuário (figure) -->
            <figure class="LupaPesquisa">
                <!--Codigo do bootstrap da lupa de pesquisa-->
                <i class="bi bi-search"></i>
            </figure>

            <input type="text" name="NomePesquisa"> <!--Input para inserir nome, porém na parte de pesquisa por colaborador-->
        </div>

        <!--div onde ficarão ficarão listados os nomes dos colaboradores que já estão cadastrados-->
        <div class="CadastrosBox">
            <!-- Local onde ficará a forto de perfil do usuário (figure) -->
            <figure class="FotoPerfil">
            </figure> 

            <h4></h4> <!-- H4 onde ficarão os nomes dos colaboradores-->

            <!-- Local onde ficará a setinha apontada para baixo, onde o admin pode ver outras informações do colaborador (figure) -->
            <figure class="SetinhaBaixo">
            </figure>
        </div>
    </main>
</body>
</html>