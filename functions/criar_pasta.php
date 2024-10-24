<?php global $conexao;

include_once('../include/conexao.php');

if(isset($_POST['nome_pasta']) && !empty($_POST['select_documents'])){
    $nome_pasta = $conexao -> real_escape_string($_POST['nome_pasta']);
    $documentos_selecionados = $_POST['select_documents'];
    date_default_timezone_set('America/Sao_Paulo'); 
    $data_hoje = date('Y-m-d');

    $CriarPasta = $conexao -> prepare("INSERT INTO tb_pasta (pasta_nome, pasta_data_criacao) VALUES (?, ?)");

    $CriarPasta -> bind_param('ss', $nome_pasta, $data_hoje);

    if($CriarPasta -> execute()){
        $pasta_id = $conexao -> insert_id;

        foreach($documentos_selecionados as $id_docs){
            $AdicionarPasta = $conexao -> prepare("UPDATE documentos SET id_pasta = ? WHERE id= ?");
            $AdicionarPasta -> bind_param('ii', $pasta_id, $id_docs);
        }

        if($AdicionarPasta -> execute()){
            header('Location: ../pgs/admin/home.php?status=success');
            exit();
        } else{
            header('Location: ../pgs/admin/home.php?status=failID');
            exit();
        }

    }else{
        header('Location: ../pgs/admin/home.php?status=failIP');
        exit();
    }

} else{
    header('Location: ../pgs/admin/home.php?status=fail');
    exit();
}

$conexao -> close();
