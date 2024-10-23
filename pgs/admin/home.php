<?php global $conexao; ?>
<!DOCTYPE html>
<html lang="pt-BR">
    <?php
    session_start();
    include_once('../../include/conexao.php');
    $sql = "SELECT * FROM documentos";
    $resultado = mysqli_query($conexao, $sql);
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
    <?php
    while ($registro = mysqli_fetch_assoc($resultado)) {
        $titulo = $registro['titulo'];
        $id = $registro['id'];
        echo '<a href="editor.php?id=' . $id . '">' . $titulo . ' ' . $id . '</a><br>'; // AQUI ELE TA MOSTRANDO OS ARQUIVOS. então você pode colocar como um botão ou da forma que preferir.
    }
    ?>
    <br>

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
                        <option value="<?php echo $rowView['id'] ?>"> <!--Colocar como opção todos os documentos que não estão em uma pasta ainda-->
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

        $(document).ready(function() { //Garante que esse comando seja executado apenas depois da página estar completamente carregada
            $('#select_documents').select2({ //Inicializa o select2 no <select> que possui id = select_documents
                placeholder: "Selecionar documentos", //Adiciona placeholder à ele, pois teoricamente um select não tem placeholder
                allowClear: true //Adciona o comando onde o select pode ser 'limpo', limpando as opções já selecionadas pelo usuário
            });
        });

        //Função para pesquisar para ver o nome da pasta já existe enquanto a pessoa digita
        function checarNomePasta(){
            let nome_pasta = document.getElementById('nome_pasta').value;
            let xhr = new XMLHttpRequest();

            xhr.open('POST', '../../functions/checarNomePasta.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const response = xhr.responseText;
                    document.getElementById('resposta_check').innerHTML = response;
                    if (response === 'Pasta existente') {
                        document.getElementById('exclamacao').style.display = 'block';
                    } else {
                        document.getElementById('exclamacao').style.display = 'none';
                    }
                }
            };
            xhr.send('nome_pasta=' + encodeURIComponent(nome_pasta));
        }
    </script>
</body>
</html>