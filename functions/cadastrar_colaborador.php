<?php global $conexao;

session_start();

include_once('../include/conexao.php');

if(isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['senha']) && isset($_POST['tipo_usuario'])){
    $nome = $conexao -> real_escape_string($_POST['nome']);
    $email = $conexao -> real_escape_string($_POST['email']);
    $senha = $conexao -> real_escape_string($_POST['senha']);

    if($_POST['tipo_usuario'] == 'Administrador'){
        $tipo_usuario = 'ADM';
    }else{
        $tipo_usuario = 'COLLAB';
    }

    date_default_timezone_set('America/Sao_Paulo');
    $date = date('Y-m-d H:i:s');

    $InsertUsuario = "INSERT INTO tb_usuario (usuario_nome, usuario_email, usuario_senha, usuario_tipo, usuario_data_entrada, usuario_ativo)
    VALUES ('$nome', '$email', '$senha', '$tipo_usuario', '$date', 1)";

    $executeInsert = $conexao -> query($InsertUsuario);

    if($executeInsert){
        header('Location: ../pgs/admin/cadastrar_colaborador.php', true, 301);
        exit();
    } else{
        header('Location: ../pgs/admin/cadastrar_colaborador.php?status=failInsert', true, 301);
        exit();
    }

}else{
    header('Location: ../pgs/admin/cadastrar_colaborador.php?status=fail', true, 301);
    exit();
}


