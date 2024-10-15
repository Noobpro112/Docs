<?php global $conexao;

session_start();

include_once('../include/conexao.php');

if(isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['senha']) && isset($_POST['tipo_usuario'])){
    $nome = $conexao -> real_escape_string($_POST['nome']); 
    $email = $conexao -> real_escape_string($_POST['email']);
    $senha = $conexao -> real_escape_string($_POST['senha']);

    //Bloco para identificar se o email já está sendo usado ou não
    $SelectEmail = "SELECT * FROM tb_usuario WHERE usuario_email = '$email' AND usuario_ativo = 1";
    $executeSelectEmail = $conexao -> query($SelectEmail);

    if($executeSelectEmail && $executeSelectEmail -> num_rows > 0){
        header('Location: ../pgs/admin/cadastrar_colaborador.php?status=failEmail', true, 301);
        exit();
    }else{
        //Buscar pelo nosso fusohorário
        date_default_timezone_set('America/Sao_Paulo'); 
        $date = date('Y-m-d H:i:s'); //Definir a data de quando a pessoa fez o cadastro

        //Bloco if para identifcar se o usuário é ADM ou COLLAB
        if($_POST['tipo_usuario'] == 'adm'){ 
            $tipo_usuario = 'ADM';
        }else{
            $tipo_usuario = 'COLLAB';
        }
        //Fim do bloco if

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

    }
}else{
    header('Location: ../pgs/admin/cadastrar_colaborador.php?status=fail', true, 301);
    exit();
}

//Fechar conexão com a databse
$conexao->close();