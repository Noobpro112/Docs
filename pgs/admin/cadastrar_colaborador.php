<?php global $conexao; ?> 
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar</title>
    <link rel="stylesheet" href="../../css/cadastrar_colaborador.css"> <!--Link para CSS externo, os estilos estarão lá-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"><!--Link para usar os icones da bootstrap-->

</head>
<body>
    <main>
        <!--Forms para a box onde o admin vai colocar as informações para cadastro-->
        <form action="../../functions/cadastrar_colaborador.php" class="InsertBox" method="POST">

            <!--Bloco PHP para verficar as repostas de erro do servidor-->
            <?php
                if(isset($_GET['status']) && ($_GET['status'] == 'failEmail')){
                    echo '<h4> Email indisponível </h4>'; //H4 para email já utilizado
                }elseif(isset($_GET['status']) && ($_GET['status'] == 'failExSTP')){
                    echo '<h4> Erro ao Cadastrar </h4>'; //H4 para erro na hora do cadastro
                }elseif(isset($_GET['status']) && ($_GET['status'] == 'fail')){
                    echo '<h4> Dados não fornecidos </h4>'; //H4 para dados não fornecidos pelo usuário
                }else{

                }
            ?>

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
            <h5>Tipo do usuário</h5> <!--H5 para a senha-->
            <select name="tipo_usuario" id="tipo_usuario"> <!--Select para escolher o tipo de usuário que queira cadastrar-->
                <option value="ADM">Administrador</option> <!--Opção 1 - Administrador-->
                <option value="COLLAB">Colaborador</option> <!--Opção 2 - Colaborador-->
            </select>
            <br>
            <br>
            <input type="submit" name="Enviar" value="Cadastrar"> <!--Input para enviar as informações para o banco de dados-->
        </form>

        <!--div para buscar pelo nome dos colaboradores-->
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
            
            <?php
            include_once('../../include/conexao.php');

            $SelectUsuarios = "SELECT * FROM usuario_ativos";
            $executeSelectUsuario = $conexao -> query($SelectUsuarios);

            if($executeSelectUsuario && $executeSelectUsuario -> num_rows > 0){
                while($row = $executeSelectUsuario -> fetch_assoc()){
                    ?>
                            <div class="Conteudo">
                                <!-- Local onde ficará a forto de perfil do usuário (figure) -->
                                <figure class="FotoPerfil">
                                    <!--Codigo do bootstrap da foto perfil, so para padrão, depois irei adicionar a foto real que a pessoa inseriu-->
                                    <i class="bi bi-person-circle"></i>
                                </figure>
                                <div class="InfoPrincipal">
                                    <h4> <?php echo $row['usuario_nome'] ?></h4> <!-- H4 onde ficarão os nomes dos colaboradores-->
                                    <!-- Local onde ficará a setinha apontada para baixo, onde o admin pode ver outras informações do colaborador (figure) -->
                                    <h4> <?php echo $row['usuario_tipo'] ?> </h4>
                                </div>
                                <figure class="SetinhaBaixo">
                                    <!--Codigo do bootstrap da seta para baixo-->
                                    <i class="bi bi-arrow-down-short"></i>
                                </figure>
                            </div>
                            <hr>
                    <?php
                }
            } else{
                echo '<h4> Nenhum Usuário ativo</h4>'; //H4 para caso nenhum usuário esteja ativo
            }
            
            ?>
            </div>
    </main>
</body>
</html>