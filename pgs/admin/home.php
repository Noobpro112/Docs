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
    <form method="post" action=../../functions/criar_documento.php>
    <button type="submit">Novo Documento.</button>
    </form>
    <br>

    <!--Div que vai aparecer ao clicar no +-->
    <div id="opcoes">
        <button onclick="showCriarPasta();" id="criar_pasta_button"> <!--Botão para criar uma nova pasta-->
            <h6>Criar Pasta</h6>
        </button>
    </div>
    <!--FIM da DIV opcoes-->

    <!--Botão para criar nova pasta ou documento-->
    <button onclick="showPopUp();" id="plus_button">
        <i class="bi bi-plus"></i>
    </button>
    <!--FIM do Botão plus_button-->

    <!--Form que vai aparecer ao clicar no botão de criar pasta, onde o usuário vai poder criar pastas e adcionar documentos nela-->
    <form action="../../functions/criar_pasta.php" id="criar_pasta_form">
        <h4>CRIAR PASTA</h4>
        <h6>Nome</h6>
        <input type="text" name="nome_pasta">
        <h6>Adicionar documentos</h6>
        <select name="select_documents" id="select_documentos">
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
        <button type="submit">
            <h6>Enviar</h6>
        </button>
    </form>
    <!--FIM da DIV criar_pasta_div-->
    <br>
    <br>
    <a href="cadastrar_colaborador.php">Cadastrar colaborador</a>
    <script>
        function showPopUp(){
            let div_opcoes = document.getElementById('opcoes');

            div_opcoes.style.display = (div_opcoes.style.display === 'none' || div_opcoes.style.display === '') ? 'flex' : 'none';
        }

        function showCriarPasta(){
            let form_criar_pasta = document.getElementById('criar_pasta_form');

            form_criar_pasta.style.display = (form_criar_pasta.style.display === 'none' || form_criar_pasta.style.display === '') ? 'block' : 'none';
        }
    </script>
</body>
</html>