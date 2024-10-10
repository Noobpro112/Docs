<?php global $conexao; //Variável global para a conexão com o banco de dados
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

            //Redirecionar usuário dependendo do tipo de login
            if($_SESSION['usuario_tipo'] == 'ADM'){
                header('Location: ../pgs/admin/home.php', true, 301); //Redirecionar para a home do admin
                exit();
            }else{
                header('Location: ../pgs/colaborador/home.php', true, 301); //Redirecionar para a home do colaborador
                exit();
            }

        }else{ //Não encontrou o usuario com tais dados, então vamos descobrir o que o usuário digitou errado ou se ele está inativo
            $SelectEmail = "SELECT * FROM tb_usuario WHERE usuario_email = '$email'"; //Buscar pelo email digitado pelo usuário, verificando assim se o email existe ou não
            $executeEmail = $conexao -> query($SelectEmail); //Executando o SelectEmail

            if($executeEmail && $executeEmail -> num_rows > 0){ //Se o email foi encontrado na database, precisamos verificar se ele está ativo

                $SelectEmailAtivo = "SELECT * FROM tb_usuario WHERE usuario_email = '$email' AND usuario_ativo = 0"; //Buscamos pelo email e pelo usuario ativo, uma vez que já sabemos que o email existe na database, só precisamos saber se o user está ativo ou não

                $executeEmailAtivo = $conexao -> query($SelectEmailAtivo); //Executando o SelectEmailAtivo

                if($executeEmailAtivo && $executeEmailAtivo -> num_rows > 0){ //Se encontrou algum usuário assim, quer dizer que ele está com a conta inativa
                    header('Location: ../index.php?status=ativoemailfailed', true, 301);//Usuario Inativo
                    exit();
                } else{ //Caso a conta esteja ativa, então só pode ser a senha digitada que não deixou a pessoa entrar no sistema
                    header('Location: ../index.php?status=senhafailed', true, 301);//Senha incorreta
                    exit();
                }
            }else{ //Caso não foi achado o email, então precisamos verficar se a senha está correta ou não também

                    $SelectSenha = "SELECT * FROM tb_usuario WHERE usuario_senha = '$senha'"; //Buscamos pela senha para ver se pelo menos a pessoa digitou a senha correta
                    $executeSenha = $conexao -> query($SelectSenha); //Executando o SelectSenha

                    if($executeSenha && $executeSenha -> num_rows > 0){ //Se encontrou tal senha, precisamos conferir primeiro se aquela conta está ativa

                        $SelectSenhaAtivo = "SELECT * FROM tb_usuario WHERE usuario_senha= '$senha' AND usuario_ativo = 0"; //Buscamos pela senha e pelo usuario ativo, uma vez que já sabemos que a senha existe na database, só precisamos saber se o user está ativo ou não
                        $executeSenhaAtivo = $conexao -> query($SelectSenhaAtivo); //Executando o SelectSenhaAtivo

                        if($executeSenhaAtivo && $executeSenhaAtivo -> num_rows > 0){ //Se encontrou algum usuário assim, quer dizer que ele está com a conta inativa
                            header('Location: ../index.php?status=ativosenhafailed', true, 301);//Usuario Inativo
                            exit();
                        } else{ //Caso a conta esteja ativa, então só pode ser o email digitado que não deixou a pessoa entrar no sistema
                            header('Location: ../index.php?status=emailfailed', true, 301); //Email incorreto
                            exit();
                        }
                    }else{ //Caso nem o email e nem a senha sejão encontrados, então os dois foram digitados erroneamente
                        header('Location: ../index.php?status=bothfailed', true, 301); //Ambos estão errados
                        exit();
                    }
                }
            }  

    }else{
        header('Location: ../index.php?status=fail', true, 301); //Dados não foram enviados corretamente
        exit();
    }
