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
        <!--Form que será usado para pesquisar por pastas e também para filtrar os documentos pela pasta-->
        <form action="" method="POST">
            <!--Input do tipo search que será usado para o usuário pesquisar por pastas que ele queira filtrar-->
            <input type="search" id="pesquisa" placeholder="Pesquise pelas pastas" onkeyup="filtrarPastas();"> <!--Atributo que acionará a função toda vez que o usuário digitar uma nova tecla-->
            <br>
            <!--Código PHP para selecionar as pastas que já existem para o usuario filtrar por pastas-->
            <?php
                $SelectPastas = "SELECT * FROM tb_pasta";
                $executePasta = $conexao -> query($SelectPastas);

                if($executePasta -> num_rows > 0){
                    while($rowPasta = $executePasta -> fetch_assoc()){
                        ?>  
                        <!--Div que armazena todas as pastas que serviram como filtro-->
                        <div class="pasta-item" data-nome="<?php echo $rowPasta['pasta_nome']; ?>"> <!--Atributo data, nesse caso descrito como nome, onde o HTML armazena dados que não são exibidos na tela do usuário-->
                            <!--label para mostrar o nome das pastas do lado do checkbox-->
                            <label for="pasta_<?php echo $rowPasta['id_pasta']; ?>">
                                <?php echo htmlspecialchars($rowPasta['pasta_nome']); ?>
                            </label>
                            <!--FIM LABEL PARA INPUTS-->

                            <!--Input checkbox para o usuário selecionar a pasta que ele deseja filtrar os documentos,o atributo name é uma array para permitir o usuário selecionar mais de uma pasta para pesquisa -->
                            <input 
                                type="checkbox" 
                                id="pasta_<?php echo $rowPasta['id_pasta']; ?>" 
                                name="pastas[]" 
                                value="<?php echo $rowPasta['id_pasta']; ?>"
                                class="checkbox-pasta"
                            > 
                            <!--FIM INPUT CHECKBOX-->

                        </div>
                        <!--Fim da DIV pasta item-->
                        <?php
                    }
                }else{
                    echo "Nenhuma pasta foi criada ainda";
                }

            ?>
            <!--DIV que será usada para exibir uma mensagem caso o javascript não encontre nenhuma pasta no banco de dados que possua o nome pesquisado pelo usuário-->
            <div class="pastasEncontradas" style="display: none;">Pasta não encontrada</div>
            <!--FIM DIV pastasEncontradas-->
        </form>
        <!--Fim DO FORMS PARA FILTRO DOS DOCUMENTOS-->
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
            var termoPesquisa = $('#pesquisa').val().toLowerCase(); // Guarda o valor atual do elemento que possui o id #pesquisa, que seria um input tipo search (Lembrando que esse valor irá atualizar a cada nova tecla digitada) e vai passar para minusculas para facilitar a manipulação
            var pastasEncontradas = false; // Variável para verificar se foi encontrada alguma pasta com base na pesquisa digitada pelo usuário
            $('.pasta-item').each(function() { //Seleciona cada elemento no HTML que possui a classe = pasta-item e roda em cada uma função, por isso o each(function())
                var nomePasta = $(this).data('nome').toLowerCase(); // Cria uma variável para acessar o elemento atual da interação, por isso o (this) e pega no atributo nome que foi passado lá no HTML dentro do atributo data e parassa tudo para minusculo
                if (nomePasta.includes(termoPesquisa)) { //Basicamente pega o nome da pasta que foi salvo acima e verifica se o termoPesquisa, ou seja, o que o usuario digitou esta incluso nesse nome da pasta
                    $(this).show(); // Caso o termo estiver incluido no nome da pasta, então mostra o elemento atual da iteração, por isso o (this).show();
                    pastasEncontradas = true; // Define a variável como true, pois foi encontrada alguma pasta de acordo com aquilo que foi digitado pelo usuário
                } else {
                    $(this).hide(); // Caso não inclua, então o JS esconde aquele o elemento atual, ou seja, não permite que o usuário veja aquela pasta, logo ela não aparece na pesquisa
                }
            });

            // Caso a variável responsável por verificar se foi encontrada alguma pasta estiver definida com true, então ele esconde a div com classe = pastasEncontradas
            if (pastasEncontradas) {
                $('.pastasEncontradas').hide(); 
            } else { // Caso contrário, ele mostra a DIV aparecendo a mensagem de Pasta não encontrada
                $('.pastasEncontradas').show();
            }
        }

        $(document).ready(function() { // Aciona a função quando todos os elementos do HTML estiverem carregados
            // Função para realizar a requisição AJAX sempre que o usuário interagir com os filtros
            function filtrarDocumentos() {
                var pastasSelecionadas = []; // Define uma variável que armazenará todas as pastas que foram selecionadas pelo usuário para filtro
                $("input[name='pastas[]']:checked").each(function() { // Pega todos os elementos do HTML que são inputs, possuem o name = pastas[] e estão seleciondaos(checked) e itera sobre cada um uma função
                    pastasSelecionadas.push($(this).val()); //Obtém o valor do elemento atual na iteração, que seria o id da pasta que foi definido lá no HTML como value e adiciona na array criada anteriormente
                });

                // Inicia um AJAX
                $.ajax({
                    url: 'filtro_ajax.php', // Para onde irá os dados do AJAX para manipulação
                    type: 'POST', //Define o tipo de requisição como POST
                    data: { // Passa os dados que serão manipulados, no caso a array que foi criada e iterada acima
                        pastas: pastasSelecionadas
                    },
                    //É definida uma função que será chamada caso a requisição for bem-sucedida
                    success: function(response) {
                        // Atualiza a lista de documentos na página sem recarregar
                        $('#documentosList').html(response);
                    }
                });
            }

            // Chama um envento listener, que basicamente aciona a funçãp acima de filtrarDocumentos toda vez que os inputs de tipo cehckbox da página mudarem de estado, ou seja, serem marcados ou desmarcados
            $("input.checkbox-pasta[type='checkbox']").on('change', function() {
                filtrarDocumentos();
            });

            // Chama o filtro inicial quando a página carrega
            filtrarDocumentos();
        });
    </script>
</body>
</html>