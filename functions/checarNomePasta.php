<?php global $conexao;
include_once('../include/conexao.php');

if (isset($_POST['nome_pasta'])) {
    $nome_pasta = $conexao -> real_escape_string($_POST['nome_pasta']);
    $SelecetNomePasta = "SELECT * FROM tb_pasta WHERE pasta_nome = '$nome_pasta'";
    $excutePasta = $conexao -> query($SelecetNomePasta);

    if ($excutePasta -> num_rows > 0) {
        echo "Pasta existente";
    } else {
    }
}
