<?php global $conexao;

include_once('../include/conexao.php');

if(isset($_POST['id_usuario_delete'])){
    $id_usuario = $conexao -> real_escape_string($_POST['id_usuario_delete']);

    $UpdateAtivo = $conexao -> prepare("UPDATE tb_usuario SET usuario_ativo = 0 WHERE id_usuario = ?");

    $UpdateAtivo -> bind_param('i', $id_usuario);

    $UpdateAtivo -> execute();

    if($UpdateAtivo){
        header('Location: ../pgs/admin/cadastrar_colaborador.php?status=successDelete', true, 301);
        exit();
    } else{
        header('Location: ../pgs/admin/cadastrar_colaborador.php?status=failUpdateAtivo', true, 301);
        exit();
    }
} else{
    header('Location: ../pgs/admin/cadastrar_colaborador.php?status=fail', true, 301);
    exit();
}

//Fechar conexão com a databse
$conexao->close();