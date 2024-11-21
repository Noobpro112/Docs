<?php global $conexao;

include_once('../include/conexao.php');

if(isset($_POST['email_usuario']) && isset($_POST['senha_usuario']) && isset($_POST['id_usuario'])){
    $new_email = $conexao -> real_escape_string($_POST['email_usuario']);
    $new_senha = $conexao -> real_escape_string($_POST['senha_usuario']);
    $id_usuario = $conexao -> real_escape_string($_POST['id_usuario']);

    $SelectUsuarios = "SELECT * FROM usuarios_ativos"; //Selecionar os usuários ativos que são pegos pela View
    $executeSelectUsuario = $conexao -> query($SelectUsuarios);

    $new_hash_password = hash('sha256', $new_senha);

    //Bloco PHP para procurar e verificar se o email já está sendo utilizado ou não
    if($executeSelectUsuario && $executeSelectUsuario -> num_rows > 0){ 
        while($row = $executeSelectUsuario -> fetch_assoc()){
            if($new_email == $row['usuario_email']){
                header('Location: ../pgs/admin/cadastrar_colaborador.php?status=failEmailUpdate', true, 301); //Caso o Email estiver sendo utilizado já devolve para a pagina do cadastro do colaborador e aparece a mensagem de email indisponível
                exit();
            } else{
            }
        }
    }else{
        header('Location: ../pgs/admin/cadastrar_colaborador.php?status=failView', true, 301); //Caso de problema na View já devolve para a página originária dizendo que a view deu erro
        exit();
    }

    //Bloco IF/ELSE para verificar se o usuário deseja trocar só a senha, email ou os dois 
    if($new_senha == '' && $new_email != ''){
        $UpdateUsuario = $conexao -> prepare("UPDATE tb_usuario SET usuario_email = ? WHERE id_usuario = ?"); //Caso for apenas o email, o update é feito só no email

        $UpdateUsuario -> bind_param('si', $new_email, $id_usuario);
    
        $UpdateUsuario -> execute();
    
        if($UpdateUsuario){
            header('Location: ../pgs/admin/cadastrar_colaborador.php?status=successUP', true, 301);
            exit();
        }else{
            header('Location: ../pgs/admin/cadastrar_colaborador.php?status=failUpdate', true, 301);
            exit();
        }
    }elseif($new_senha != '' && $new_email == ''){
        $UpdateUsuario = $conexao -> prepare("UPDATE tb_usuario SET usuario_senha = ? WHERE id_usuario = ?"); //Caso for apenas a senha, o update é feito só na senha

        $UpdateUsuario -> bind_param('si', $new_hash_password, $id_usuario);
    
        $UpdateUsuario -> execute();
    
        if($UpdateUsuario){
            header('Location: ../pgs/admin/cadastrar_colaborador.php?status=successUP', true, 301);
            exit();
        }else{
            header('Location: ../pgs/admin/cadastrar_colaborador.php?status=failUpdate', true, 301);
            exit();
        }
    } else{
        $UpdateUsuario = $conexao -> prepare("UPDATE tb_usuario SET usuario_email = ?, usuario_senha = ? WHERE id_usuario = ?"); //Caso for para trocar os dois, o update é feito nos dois (senha e email)

        $UpdateUsuario -> bind_param('ssi', $new_email, $new_hash_password, $id_usuario);
    
        $UpdateUsuario -> execute();
    
        if($UpdateUsuario){
            header('Location: ../pgs/admin/cadastrar_colaborador.php?status=successUP', true, 301);
            exit();
        }else{
            header('Location: ../pgs/admin/cadastrar_colaborador.php?status=failUpdate', true, 301);
            exit();
        }
    }
}else{
    header('Location: ../pgs/admin/cadastrar_colaborador.php?status=fail', true, 301);
    exit();
}

//Fechar conexão com a databse
$conexao->close();