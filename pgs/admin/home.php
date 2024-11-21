<?php global $conexao; ?>
<!DOCTYPE html>
<html lang="pt-BR">
    <?php
    session_start();
    include_once('../../include/conexao.php');
    ?>
<head>
    <meta charset="UTF-8">
    <title>HOME ADM</title>
    <link rel="icon" type="image/x-icon" href="../../imgs/favicon.ico">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"><!--Link para usar os icones da bootstrap-->
    <link rel="stylesheet" href="../../css/home_adm.css"><!--Link css da home do admin-->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" /> <!--Link do css para a parte Select Multiple, onde esse css está para mostrar como ficaria, mas pode ser trocado-->
</head>
<body>
    <h1>Selecione um Arquivo:</h1>
    <div id="documentosList">
        <!-- Os documentos filtrados serão carregados aqui -->
    </div>

    <!--Botão para usuário acessar os filtros de pesquisa-->
    <button id="button_filtro" onclick="showFiltros();">
        <i class="bi bi-funnel"></i>
    </button>
    <!--FIM do Botão button_filtro-->

    <!--Div que vai aparecer quando o usuario clicar no icone de filtrar-->
    <div id="filtros">
        <form action="" method="POST">
            <input type="search" id="pesquisa" placeholder="Pesquise pelas pastas" onkeyup="filtrarPastas();">
            <br>
            <?php
                $SelectPastas = "SELECT * FROM tb_pasta";
                $executePasta = $conexao -> query($SelectPastas);

                if($executePasta -> num_rows > 0){
                    while($rowPasta = $executePasta -> fetch_assoc()){
                        ?>  
                        <div class="pasta-item" data-nome="<?php echo $rowPasta['pasta_nome']; ?>">
                            <label for="pasta_<?php echo $rowPasta['id_pasta']; ?>">
                                <?php echo htmlspecialchars($rowPasta['pasta_nome']); ?>
                            </label>
                            <input 
                                type="checkbox" 
                                id="pasta_<?php echo $rowPasta['id_pasta']; ?>" 
                                name="pastas[]" 
                                value="<?php echo $rowPasta['id_pasta']; ?>"
                                class="checkbox-pasta"
                            >
                        </div>
                        <?php
                    }
                }else{
                    echo "Nenhuma pasta foi criada ainda";
                }

            ?>
            <div class="pastasEncontradas" style="display: none;">Pasta não encontrada</div>
        </form>
    </div>
    <!--FIM da DIV filtro -->
    <!--Div que vai aparecer ao clicar no +-->
    <div id="opcoes">
        <button onclick="showCriarPasta();" id="criar_pasta_button"> <!--Botão para criar uma nova pasta-->
            <h4>Criar Pasta</h4>
        </button>
        <br>
        <form method="post" action=../../functions/criar_documento.php> <!--Forms e botão para criar novo documento-->
            <button type="submit">
                <h4>Novo Documento.</h4>
            </button>
        </form>
    </div>
    <!--FIM da DIV opcoes-->

    <!--Botão para criar nova pasta ou documento que chama a function do JS para mostrar a div acima-->
    <button onclick="showPopUp();" id="plus_button">
        <i class="bi bi-plus"></i>
    </button>
    <!--FIM do Botão plus_button-->

    <!--Form que vai aparecer ao clicar no botão de criar pasta, onde o usuário vai poder criar pastas e adcionar documentos nela-->
    <form action="../../functions/criar_pasta.php" id="criar_pasta_form" method="POST">
        <button id="close_button" type="button" onclick="close_criar_pasta();"> X </button> <!--Botão com um X para fechar o forms, dessa forma chamar a função em JS que troca o display do forms-->
        <h4>CRIAR PASTA</h4>
        <h6>Nome</h6>
        <section id="NomePasta">
            <input type="text" name="nome_pasta" id="nome_pasta" onkeyup="checarNomePasta();">
            <i class="bi bi-exclamation-lg" id="exclamacao"></i>
            <p id="resposta_check"></p>
        </section>
        <h6>Adicionar documentos</h6>
        <select name="select_documents[]" id="select_documents" multiple> <!--Select Multiplo, onde o usuário irá escolher quais documentos ele quer que estejam naquela determinada pasta que está prestes a criar-->
            <?php
                $SelectDocumentos = "SELECT * FROM documentos_pasta";
                $executeView = $conexao -> query($SelectDocumentos);

                if($executeView -> num_rows > 0){
                    while($rowView = $executeView -> fetch_assoc()){
                        ?>
                        <option value="<?php echo $rowView['id'] ?>">
                            <?php echo $rowView['titulo'] ?>
                        </option>
                        <?php
                    }
                }
            ?>
        </select>   
        
        <!--Botão para enviar o forms-->
        <button type="submit"> 
            <h6>Enviar</h6>
        </button>
    </form>
    <!--FIM do FORMS criar_pasta_form-->
    <br>
    <br>
    <a href="cadastrar_colaborador.php">Cadastrar colaborador</a>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!--Scripts para chamar a biblioteca Jquery do JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script> <!--Scripts para charmar a biblioteca Select2 do Jquery, que permite novas funcionalides à tag <select> -->
    <script>
        //Function para trocar o display da div opcoes, onde o usuário poderá criar pastas ou criar documentos
        function showPopUp() {
            let div_opcoes = document.getElementById('opcoes'); 
            div_opcoes.style.display = (div_opcoes.style.display === 'none' || div_opcoes.style.display === '') ? 'block' : 'none';
        }

        //Function para trocar o display do forms de criar pasta, onde o usuário poderá criar pastas
        function showCriarPasta() {
            let form_criar_pasta = document.getElementById('criar_pasta_form'); //Pegar o forms pelo Id e guardar em uma variável
            form_criar_pasta.style.display = (form_criar_pasta.style.display === 'none' || form_criar_pasta.style.display === '') ? 'block' : 'none';
        }

        //Function para trocar o display do forms, mais especificamente escondelo usando o botão vermelho
        function close_criar_pasta(){
            let form_criar_pasta = document.getElementById('criar_pasta_form'); //Pegar o forms pelo Id e guardar em uma variável
            form_criar_pasta.style.display = 'none'; //Trocar display para none, escondendo o forms
        }

        //Function para trocar o display da div opcoes, onde o usuário poderá criar pastas ou criar documentos
        function showFiltros() {
            let div_filtros = document.getElementById('filtros'); 
            div_filtros.style.display = (div_filtros.style.display === 'none' || div_filtros.style.display === '') ? 'block' : 'none';
        }

        $(document).ready(function() { //Garante que esse comando seja executado apenas depois da página estar completamente carregada
            $('#select_documents').select2({ //Inicializa o select2 no <select> que possui id = select_documents
                placeholder: "Selecionar documentos", //Adiciona placeholder à ele, pois teoricamente um select não tem placeholder
                allowClear: true //Adciona o comando onde o select pode ser 'limpo', limpando as opções já selecionadas pelo usuário
            });
        });

        //Função para pesquisar para ver o nome da pasta já existe enquanto a pessoa digita
        function checarNomePasta(){
            let nome_pasta = document.getElementById('nome_pasta').value; //Pega o valor digitado e quando em uma variável
            let xhr = new XMLHttpRequest(); //Cria um objeto XMLHttpRequest, que é usado para interajir com o servidor

            xhr.open('POST', '../../functions/checarNomePasta.php', true); //Detalhes da requisição
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded'); //Seta o tipo das informações 
            //Bloco IF/ELSE para verficar a resposta do servidor 
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) { //se tudo ocorrer corretamente ele pega a resposta do servidor e armazena em uma variável
                    const response = xhr.responseText;
                    document.getElementById('resposta_check').innerHTML = response;
                    //Bloco IF/ELSE para verficar qual foi a resposta e trocar o display do icone de exclamacao
                    if (response === 'Pasta existente') {
                        document.getElementById('exclamacao').style.display = 'block';
                    } else {
                        document.getElementById('exclamacao').style.display = 'none';
                    }
                }
            };
            xhr.send('nome_pasta=' + encodeURIComponent(nome_pasta)); //Enviando a requisição e também os dados que serão tratados no PHP
        }

        // Função para filtrar as pastas enquanto o usuário digita
        function filtrarPastas() {
            var termoPesquisa = $('#pesquisa').val().toLowerCase(); // Pega o termo de pesquisa em minúsculo
            var pastasEncontradas = false; // Variável para verificar se encontrou algum usuário
            $('.pasta-item').each(function() {
                var nomePasta = $(this).data('nome').toLowerCase(); // Obtém o nome da pasta em minúsculo
                if (nomePasta.includes(termoPesquisa)) {
                    $(this).show(); // Exibe a pasta
                    pastasEncontradas = true;
                } else {
                    $(this).hide(); // Esconde a pasta
                }
            });

            // Exibe a mensagem caso nenhum usuário tenha sido encontrado
            if (pastasEncontradas) {
                $('.pastasEncontradas').hide(); // Esconde a mensagem
            } else {
                $('.pastasEncontradas').show(); // Exibe a mensagem de "Usuário não encontrado"
            }
        }

        $(document).ready(function() {
            // Função para realizar a requisição AJAX sempre que o usuário interagir com os filtros
            function filtrarDocumentos() {
                // Coleta os valores das pastas selecionadas
                var pastasSelecionadas = [];
                $("input[name='pastas[]']:checked").each(function() {
                    pastasSelecionadas.push($(this).val());
                });

                $.ajax({
                    url: 'filtro_ajax.php', // Arquivo que irá processar a requisição
                    type: 'POST',
                    data: {
                        pastas: pastasSelecionadas
                    },
                    success: function(response) {
                        // Atualiza a lista de documentos na página sem recarregar
                        $('#documentosList').html(response);
                    }
                });
            }

            // Chamando a função de filtro quando o usuário alterar a seleção das pastas
            $("input[type='checkbox']").on('change', function() {
                filtrarDocumentos();
            });

            // Chama o filtro inicial quando a página carrega
            filtrarDocumentos();
        });

    </script>
</body>
</html>