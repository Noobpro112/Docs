<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <main>
        <!-- Forms do login -->
        <form action="functions/login.php" method="POST">
            <!-- php para tratar se o erro foi na senha, email ou ambos -->
            <?php
                if(isset($_GET['status']) && ($_GET['status'] == 'emailfailed')){
                    echo '<h4> Email incorreto </h4>'; //H4 para email incorreto
                }elseif(isset($_GET['status']) && ($_GET['status'] == 'senhafailed')){
                    echo '<h4> Senha incorreta </h4>';//H4 para senha incorreta
                } elseif(isset($_GET['status']) && ($_GET['status'] == 'bothfailed')){
                    echo '<h4> Email e senha incorretos </h4>'; //H4 para ambos incorretos
                }elseif(isset($_GET['status']) && ($_GET['status'] == 'ativoemailfailed')){
                    echo '<h4> Usuário com email inativo </h4>'; //H4 para usuário com tal email inativo
                }elseif(isset($_GET['status']) && ($_GET['status'] == 'ativosenhafailed')){
                    echo '<h4> Usuário com senha inativa </h4>'; //H4 para usuário com tal senha inativo
                }elseif(isset($_GET['status']) && ($_GET['status'] == 'fail')){
                    echo '<h4> Erro ao enviar dados </h4>'; //H4 para caso os dados não forem enviados
                }else{
                    //Else para não acontecer nada caso não tenha nenhum erro no login
                }
            ?>
            Email
            <label>
                <input type="email" name="email">
            </label> <!-- Input do Email -->
            Senha
            <label>
                <input type="password" name="senha">
            </label> <!-- Input da Senha -->
            <input type="submit" value="Logar"> <!-- Input para enviar informações -->
        </form>
    </main>
</body>
</html>