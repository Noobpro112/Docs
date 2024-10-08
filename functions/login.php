<?php global $conexao; 
    include_once('../include/conexao.php'); //Trazer o script desse caminho, dessa forma especificando a variável conexão


    //Iniciar sessão para guardar informações do usuário
    session_start();    

    if(isset($_POST['email']) && isset($_POST['senha'])){ //Verificando se as variáveis contem algum valor

        //Guardar os valores em variáveis
        $email = $conexao -> real_escape_string($_POST['email']);
        $senha = $conexao -> real_escape_string($_POST['senha']);

        //Query para verificar se o usuário existe
        $SelectUsuario = "SELECT * FROM tb_usuario WHERE usuario_email = '$email' AND usuario_senha = '$senha' AND usuario_ativo = 1";
        $executeSelect = $conexao -> query($SelectUsuario); // Executar consulta

        if($executeSelect && $executeSelect -> num_rows > 0){ // Verificar se a cinsulta deu certo e se recebeu alguma linha
            $rowUsuario = $executeSelect -> fetch_assoc(); //Salvando as informações do usuário

            //Criando Sessão do usuário e salvar seus dados
            $_SESSION['usuario_id'] = $rowUsuario['id_usuario'];
            $_SESSION['usuario_nome'] = $rowUsuario['usuario_nome'];
            $_SESSION['usuario_email'] = $rowUsuario['usuario_email'];
            $_SESSION['usuario_senha'] = $rowUsuario['usuario_senha'];
            $_SESSION['usuario_tipo'] = $rowUsuario['usuario_tipo'];
            
            header('Location: pgs/home.php', 301, true);
            exit();
        }else{
            /*$rowUsuario = $executeSelect -> fetch_assoc(); //Salvando as informações do usuário para verficar qual o erro
            //Guardar Email e Senha para conferir qual está errado
            $usuario_email = $rowUsuario['usuario_email'];
            $usuario_senha = $rowUsuario['usuario_senha'];

            if(($email == $usuario_email) && ($senha != $usuario_senha)){ //Email incorreto
                header('Location: index.php?status=emailfailed', 301, true);
                exit();
            }elseif(($email != $usuario_email) && ($senha == $usuario_senha)){ // Senha incorreta
                header('Location: index.php?status=senhafailed', 301, true);
                exit();
            }else{ //Se caiu no else, ambos estão errados
                header('Location: index.php?status=bothfailed', 301, true);
                exit();
            }*/
            header('Location: index.php?status=fail', 301, true);
            exit();
        }

    }else{
        header('Location: index.php?status=fail', 301, true);
        exit();
    }
?>

