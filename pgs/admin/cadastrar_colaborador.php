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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <!--Link para usar os icones da bootstrap-->
    <script src="https://kit.fontawesome.com/a760d1109c.js" crossorigin="anonymous"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');

        .headerBusca {
            display: none !important;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <?php include_once("../../include/header.php"); ?>
    <main>
        <section class="section1">
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

                <input class="inputsCadastrar" type="text" name="nome" placeholder="Nome">
                <!--Input para inserir nome-->
                <input class="inputsCadastrar" type="email" name="email" placeholder="Email">
                <div class="linhaSenha"> <!--Input para inserir email-->
                    <input class="inputsCadastrar" type="password" name="senha" placeholder="Senha" id="senha">
                    <!--Input para inserir senha-->
                    <i class="fa-solid fa-eye-slash" id="togglePassword"></i>
                </div>
                <div class="tipoUsuarioLinha">
                    <p>Tipo do usuário:</p> <!--H5 para a senha-->
                    <select name="tipo_usuario" id="tipo_usuario">
                        <!--Select para escolher o tipo de usuário que queira cadastrar-->
                        <option value="ADM">Administrador</option> <!--Opção 1 - Administrador-->
                        <option value="COLLAB">Colaborador</option> <!--Opção 2 - Colaborador-->
                    </select>
                </div>
                <input class="buttonCadastrar" type="submit" name="Enviar" value="Cadastrar">
                <!--Input para enviar as informações para o banco de dados-->
            </form>
            <!-- FIM forms de cadastro-->
        </section>

        <section class="section2">
            <!-- Inicio Div Mais Infos - Essa div engloba a barra de pesquisa em cima e os dados dos usuários que aparecerão em baixo, dessa forma eles ficam juntos-->
            <div id="MainDivInfos">
                <!--div para buscar pelo nome dos colaboradores-->
                <div class="BarraPesquisa">
                    <!-- Local onde ficará a imagem da lupa para pequisa por usuário (figure) -->
                    <figure class="LupaPesquisa">
                        <!--Codigo do fontawesome da lupa de pesquisa-->
                        <i class="bi bi-search"></i>
                    </figure>
                    <input type="search" name="NomePesquisa" placeholder="Buscar" oninput="filtrarUsuarios();"
                        id="pesquisa_usuario">
                    <!--Input para inserir nome, porém na parte de pesquisa por colaborador, para pesquisar o colaborador direto para então realizar as demais funções-->
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
                } elseif (isset($_GET['status']) && ($_GET['status'] == 'successUP')) {
                    echo '<h3> Dados Atualizados </h3>'; //H4 para erro ao excluir
                } elseif (isset($_GET['status']) && ($_GET['status'] == 'successDelete')) {
                    echo '<h3> Usuário deletado com sucesso </h3>'; //H4 para erro ao excluir
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
                            <div class="item" data-nome="<?php echo $row['usuario_nome']; ?>">
                                <!-- Inicio Div item-titulo - Div para mostrar o nome e tipo do usuário além da setinha para acessar mais informações-->
                                <div class="item-titulo">
                                    <!-- Local onde ficará a forto de perfil do usuário (figure) -->
                                    <figure class="FotoPerfil">
                                        <!--Codigo do bootstrap da foto perfil, so para padrão, depois irei adicionar a foto real que a pessoa inseriu-->
                                        <i class="bi bi-person-circle"></i>
                                    </figure>
                                    <div class="InfoPrincipal">
                                        <h4><?php echo $row['usuario_nome'] ?></h4>
                                        <!-- H4 onde ficarão os nomes dos colaboradores-->
                                        <!-- Local onde ficará a setinha apontada para baixo, onde o admin pode ver outras informações do colaborador (figure) -->
                                        <h4><?php echo $row['usuario_tipo'] ?></h4>
                                    </div>
                                    <!--Button para chamar a função onclick para mostrar o forms abaixo com as informações e também para o adm poder trocar caso ele queira-->
                                    <button id="setinha_button" onclick="ShowFormInfo(this);">
                                        <!-- Goi passado o parâmetro THIS na função para o JS identificar onde está o botão que foi clicado, tipo o botão manda um sinal "Hey, Eu estou aqui para o JS" -->
                                        <figure class="SetinhaBaixo">
                                            <!--Codigo do fontawesome da seta para baixo-->
                                            <i class="fa-solid fa-angle-down"></i>
                                        </figure>
                                    </button>
                                </div>
                                <!-- FIM Div item-titulo -->

                                <!-- Forms onde vão aparecer o email e a senha do usuário, podendo ser alteradas pelo próprio ADM, além disso ele vai poder excluir o usuário também -->
                                <form action="../../functions/update_infos.php" method="POST" class="Form_show_infos">
                                    <!-- Primeira Section (EMAIL)- H4 do Email e input do Email -->
                                    <div class="linha01">
                                        <section class="sections_infos" id="section_email">
                                            <div class="labelAlinhamento"><label>Email:</label></div>
                                            <input class="inputInformacoes01" type="email" name="email_usuario"
                                                placeholder="<?php echo $row['usuario_email'] ?>">
                                            <input type="hidden" name="id_usuario" value="<?php echo $row['id_usuario'] ?>">
                                            <!-- input escondido para levar o valor do id do usuario -->
                                        </section>
                                    </div>
                                    <!-- FIM Section EMAIL -->
                                    <!-- Segunda Section (Senha)- H4 da Senha, input da Email, botão de salvar e botão de delete -->
                                    <div class="linha02">


                                        <section class="sections_infos" id="section_senha">
                                            <div class="labelAlinhamento"><label>Senha:</label></div>
                                            <input class="inputInformacoes02" type="password" name="senha_usuario" value=""
                                                placeholder="Troque a senha aqui">
                                            <input id="salvar" type="submit" value="Salvar">
                                </form>
                                <!-- FIM Forms-->

                                <form action="../../functions/excluir_usuario.php" method="POST" class="formDeletar">
                                    <input type="hidden" name="id_usuario_delete" value="<?php echo $row['id_usuario'] ?>">
                                    <!-- input escondido para levar o valor do id do usuario -->
                                    <button class="delete_button" type="submit">
                                        <figure id="delete_icon">
                                            <i class="fa-solid fa-trash"></i>
                                        </figure>
                                    </button>
                                </form>

                                <!-- FIM Forms-->

                </section>
                </div>
                <!-- FIM Section Senha -->
                </div>
                <!-- FIM div item -->

                <?php
                        }
                    } else {
                        echo '<h4> Nenhum Usuário ativo</h4>'; //H4 para caso nenhum usuário esteja ativo
                    }

                    ?>
        <!-- DIV que mostrar a mensagem que nenhum usuário foi encontrado, caso o nome digitado pela pessoa não for achada na função do JS -->
        <div class="usuarioNaoEncontrado" style="display: none;">Usuário não encontrado</div>
        </div>
        <!-- FIM Cadastro BOX-->
        </div>
        <!-- FIM DIv Mais Infos -->
        </section>


    </main>
    <script>

        const senhaInput = document.getElementById("senha");
        const togglePassword = document.getElementById("togglePassword");

        togglePassword.addEventListener("click", function () {
            // Alternar o tipo de input entre "password" e "text"
            const isPassword = senhaInput.type === "password";
            senhaInput.type = isPassword ? "text" : "password";

            // Alternar o ícone entre "fa-eye" e "fa-eye-slash"
            togglePassword.classList.toggle("fa-eye");
            togglePassword.classList.toggle("fa-eye-slash");
        });


        function ShowFormInfo(button) { //Criar a função em JS que será chamada ao usuário clicar na seta - passamos como parâmetro justamente o botão por meio daquele comando THIS para assim podermos buscar pelo forms
            const form_infos = button.parentElement.nextElementSibling; //Criamos a varíavel que irá guardar o forms que queremos que apareça. Portanto, colocamos button.parentElement para buscar o elemento pai onde o botão está inserido, que no caso seria a div com class="Conteudo". Logo mais, nós adicionamos o parâmetro nextElementSibling, que irá buscar pelo elemento irmão (do lado) do div PAI do nosso botão, que no caso é justamente o forms, dess forma chegamos até o forms que queremos trocar o display para ele aparecer
            form_infos.style.display = (form_infos.style.display === 'none' || form_infos.style.display === '') ? 'flex' : 'none'; //Queremos acessar o estilo do forms, mais especificamente o display dele, por isso colocamos: form_infos.style.display. Após isso vem a parte crucial do código, temos nossa condição, se o display estiver como none ou se o display estiver vazio (o que seria para saber se o forms está aparecendo ou não). Depois disso, usamos o '?' que serve como encurtamento do bloco if/else, então se algum dos argumentos for TRUE - ou seja o forms não está visível - ele passa o display para flex para ele ficar visível, caso contrário se nenhuma delas for verdadeira então o forms está visível, portanto ele manda o display ficar none para o forms se esconder quando o usuário clicar na setinha denovo
        }



        function filtrarUsuarios() {
            var termoPesquisa = $('#pesquisa_usuario').val().toLowerCase(); // Pega o elemento do HTML com id = pesquisa_usuario, que no caso é um input tipo search e pega o valor atual dele e passa tudo para minusculas
            var usuariosEncontrados = false; // Variável para verificar se encontrou algum usuário

            // Exibe todos os itens se a pesquisa estiver vazia
            if (termoPesquisa === "") {
                $('.item').show(); // Exibe todos os itens
                $('.usuarioNaoEncontrado').hide(); // Esconde a mensagem de "Usuário não encontrado"
                return;
            }

            // Pega todos os elementos que possuem a classe item, que no caso é uma DIV que mostra as informações de cada usuário e itera sobre cada um uma função
            $('.item').each(function () {
                var nomeUsuario = $(this).data('nome').toLowerCase(); // pega o valor nome do atributo data (definido lá no HTML) do elemento atual que está sendo iterado passa tudo para minusculas e guarda em uma variável

                // Verifica se o nome do usuário contém o termo de pesquisa
                if (nomeUsuario.indexOf(termoPesquisa) !== -1) { // O método indexOf serve para verificar se um indice, no caso o termoPesquisa definido lá em cima, está incluido em uma determinada string, no caso nomeUsuario. Caso não for encontrado retorna -1, por isso !== -1
                    $(this).show(); // Exibe o item atual da iteração 
                    usuariosEncontrados = true; // Marca como encontrado
                } else {
                    $(this).hide(); // Esconde o item atual da iteração
                }
            });

            // Exibe a mensagem caso nenhum usuário tenha sido encontrado
            if (usuariosEncontrados) {
                $('.usuarioNaoEncontrado').hide(); // Esconde a mensagem
            } else {
                $('.usuarioNaoEncontrado').show(); // Exibe a mensagem de "Usuário não encontrado"
            }
        }
    </script>
</body>

</html>