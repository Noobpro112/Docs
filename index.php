<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://kit.fontawesome.com/a760d1109c.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');
    </style>
</head>

<body>
    <section class="linhaLogin">
        <div class="boxLogin">
            <!-- Forms do login -->
            <form action="functions/login.php" method="POST">
                <!-- php para tratar se o erro foi na senha, email ou ambos -->
                <?php
                if (isset($_GET['status']) && ($_GET['status'] == 'emailfailed')) {
                    echo '<h4> Email incorreto </h4>'; //H4 para email incorreto
                } elseif (isset($_GET['status']) && ($_GET['status'] == 'senhafailed')) {
                    echo '<h4> Senha incorreta </h4>';//H4 para senha incorreta
                } elseif (isset($_GET['status']) && ($_GET['status'] == 'bothfailed')) {
                    echo '<h4> Email e senha incorretos </h4>'; //H4 para ambos incorretos
                } elseif (isset($_GET['status']) && ($_GET['status'] == 'ativoemailfailed')) {
                    echo '<h4> Usuário com email inativo </h4>'; //H4 para usuário com tal email inativo
                } elseif (isset($_GET['status']) && ($_GET['status'] == 'ativosenhafailed')) {
                    echo '<h4> Usuário com senha inativa </h4>'; //H4 para usuário com tal senha inativo
                } elseif (isset($_GET['status']) && ($_GET['status'] == 'fail')) {
                    echo '<h4> Erro ao enviar dados </h4>'; //H4 para caso os dados não forem enviados
                } else {
                    //Else para não acontecer nada caso não tenha nenhum erro no login
                }
                ?>
                <div class="boxLogin-Title">
                    <h2>Login</h2>
                </div>
                <div class="boxLogin-input inputEmail">
                    <i class="fa-solid fa-user"></i>
                    <input type="email" name="email" placeholder="Email">
                    <!-- Input do Email -->
                </div>
                <div class="boxLogin-input inputSenha">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="senha" placeholder="Senha">
                    <i class="fa-solid fa-eye-slash"></i>
                    <!-- Input da Senha -->
                </div>
                <div class="boxLogin-button">
                    <input type="submit" value="Entrar"> <!-- Input para enviar informações -->
                </div>
            </form>
        </div>
    </section>
</body>

</html>