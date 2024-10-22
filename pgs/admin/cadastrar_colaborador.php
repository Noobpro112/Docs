<?php global $conexao; ?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar</title>
    <link rel="icon" type="image/x-icon" href="../../imgs/favicon.ico">
    <link rel="stylesheet" href="../../css/cadastrar_colaborador.css">
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
    <main>
        <!--Forms para a box onde o admin vai colocar as informações para cadastro-->
        <form action="../../functions/cadastrar_colaborador.php" class="InsertBox" method="POST">

            <!--Bloco PHP para verficar as repostas de erro do servidor-->
            <?php
            if (isset($_GET['status']) && ($_GET['status'] == 'failEmail')) {
                echo '<h4> Email indisponível </h4>'; //H4 para email já utilizado
            } elseif (isset($_GET['status']) && ($_GET['status'] == 'failExSTP')) {
                echo '<h4> Erro ao Cadastrar </h4>'; //H4 para erro na hora do cadastro
            } elseif (isset($_GET['status']) && ($_GET['status'] == 'fail')) {
                echo '<h4> Dados não fornecidos </h4>'; //H4 para dados não fornecidos pelo usuário
            } else {
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
        <!-- FIM forms de cadastro-->


        <!-- Inicio Div Mais Infos - Essa div engloba a barra de pesquisa em cima e os dados dos usuários que aparecerão em baixo, dessa forma eles ficam juntos-->
        <div id="MainDivInfos">
            <!--div para buscar pelo nome dos colaboradores-->
            <div class="BarraPesquisa">
                <!-- Local onde ficará a imagem da lupa para pequisa por usuário (figure) -->
                <figure class="LupaPesquisa">
                    <!--Codigo do bootstrap da lupa de pesquisa-->
                    <i class="bi bi-search"></i>
                </figure>
                <input type="text" name="NomePesquisa"> <!--Input para inserir nome, porém na parte de pesquisa por colaborador-->
            </div>

            <!--Bloco PHP para verficar as repostas de erro do servidor-->
            <?php
            if (isset($_GET['status']) && ($_GET['status'] == 'failEmailUpdate')) {
                echo '<h3> Email indisponível </h3>'; //H4 para email já utilizado
            } elseif (isset($_GET['status']) && ($_GET['status'] == 'failView')) {
                echo '<h3> Erro em buscar usuários </h3>'; //H4 para erro na hora da execução da view
            } elseif (isset($_GET['status']) && ($_GET['status'] == 'failUpdate')) {
                echo '<h3> Falha ao atualizar informações </h3>'; //H4 para falha no processo de update
            } elseif (isset($_GET['status']) && ($_GET['status'] == 'failUpdateAtivo')) {
                echo '<h3> Erro ao excluir Usuário </h3>'; //H4 para erro ao excluir
            } elseif (isset($_GET['status']) && ($_GET['status'] == 'fail')) {
                echo '<h3> Erro nos dados </h3>'; //H4 para dados não fornecidos
            }
            ?>

            <!--div onde ficarão ficarão listados os nomes dos colaboradores que já estão cadastrados, iniciada antes do PHP pois ela é a div principal, ettão só serão criadas outras divs para as informações dos usuarios-->
            <div class="CadastrosBox">

                <?php
                include_once('../../include/conexao.php');

                $SelectUsuarios = "SELECT * FROM usuarios_ativos"; //Selecionar os usuários ativos que são pegos pela View
                $executeSelectUsuario = $conexao->query($SelectUsuarios);

                if ($executeSelectUsuario && $executeSelectUsuario->num_rows > 0) {
                    while ($row = $executeSelectUsuario->fetch_assoc()) {
                ?>
                        <!-- Inicio Div Conteudo - Div para mostrar o nome e tipo do usuário além da setinha para acessar mais informações-->
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
                            <!--Button para chamar a função onclick para mostrar o forms abaixo com as informações e também para o adm poder trocar caso ele queira-->
                            <button id="setinha_button" onclick="ShowFormInfo(this);"> <!-- Goi passado o parâmetro THIS na função para o JS identificar onde está o botão que foi clicado, tipo o botão manda um sinal "Hey, Eu estou aqui para o JS" -->
                                <figure class="SetinhaBaixo">
                                    <!--Codigo do bootstrap da seta para baixo-->
                                    <i class="bi bi-arrow-down-short"></i>
                                </figure>
                            </button>
                        </div>
                        <!-- FIM Div Conteudo -->

                        <!-- Forms onde vão aparecer o email e a senha do usuário, podendo ser alteradas pelo próprio ADM, além disso ele vai poder excluir o usuário também -->
                        <form action="../../functions/update_infos.php" method="POST" class="Form_show_infos">
                            <!-- Primeira Section (EMAIL)- H4 do Email e input do Email -->
                            <section class="sections_infos" id="section_email">
                                <h4>Email:</h4>
                                <input type="email" name="email_usuario" placeholder="<?php echo $row['usuario_email'] ?>">
                                <input type="hidden" name="id_usuario" value="<?php echo $row['id_usuario'] ?>"> <!-- input escondido para levar o valor do id do usuario -->
                            </section>
                            <!-- FIM Section EMAIL -->
                            <!-- Segunda Section (Senha)- H4 da Senha, input da Email, botão de salvar e botão de delete -->
                            <section class="sections_infos" id="section_senha">
                                <h4>Senha:</h4>
                                <input type="password" name="senha_usuario" value="<?php echo $row['usuario_senha'] ?>">
                                <input type="submit" value="SALVAR">
                        </form>
                        <!-- FIM Forms-->

                        <form action="../../functions/excluir_usuario.php" method="POST">
                            <input type="hidden" name="id_usuario_delete" value="<?php echo $row['id_usuario'] ?>"> <!-- input escondido para levar o valor do id do usuario -->
                            <button class="delete_button" type="submit">
                                <figure id="delete_icon">
                                    <i class="bi bi-trash-fill"></i>
                                </figure>
                            </button>
                        </form>
                        <!-- FIM Forms-->

                        </section>
                        <!-- FIM Section Senha -->
                        <hr> <!-- HR para separar cada usuário e suas informações-->
                <?php
                    }
                } else {
                    echo '<h4> Nenhum Usuário ativo</h4>'; //H4 para caso nenhum usuário esteja ativo
                }

                ?>
            </div>
            <!-- FIM Cadastro BOX-->
        </div>
        <!-- FIM DIv Mais Infos -->
    </main>
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


        function ShowFormInfo(button) { //Criar a função em JS que será chamada ao usuário clicar na seta - passamos como parâmetro justamente o botão por meio daquele comando THIS para assim podermos buscar pelo forms
            const form_infos = button.parentElement.nextElementSibling; //Criamos a varíavel que irá guardar o forms que queremos que apareça. Portanto, colocamos button.parentElement para buscar o elemento pai onde o botão está inserido, que no caso seria a div com class="Conteudo". Logo mais, nós adicionamos o parâmetro nextElementSibling, que irá buscar pelo elemento irmão (do lado) do div PAI do nosso botão, que no caso é justamente o forms, dess forma chegamos até o forms que queremos trocar o display para ele aparecer
            form_infos.style.display = (form_infos.style.display === 'none' || form_infos.style.display === '') ? 'flex' : 'none'; //Queremos acessar o estilo do forms, mais especificamente o display dele, por isso colocamos: form_infos.style.display. Após isso vem a parte crucial do código, temos nossa condição, se o display estiver como none ou se o display estiver vazio (o que seria para saber se o forms está aparecendo ou não). Depois disso, usamos o '?' que serve como encurtamento do bloco if/else, então se algum dos argumentos for TRUE - ou seja o forms não está visível - ele passa o display para flex para ele ficar visível, caso contrário se nenhuma delas for verdadeira então o forms está visível, portanto ele manda o display ficar none para o forms se esconder quando o usuário clicar na setinha denovo
        }
    </script>
</body>

</html>