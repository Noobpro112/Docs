<?php global $conexao;

session_start();

include_once('../include/conexao.php');

if(isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['senha']) && isset($_POST['tipo_usuario'])){
    //Guardar os dados digitados em vaiáveis
    $nome = $conexao -> real_escape_string($_POST['nome']); 
    $email = $conexao -> real_escape_string($_POST['email']);
    $senha = $conexao -> real_escape_string($_POST['senha']);
    $tipo = $conexao -> real_escape_string($_POST['tipo_usuario']);

    //Buscar pelo nosso fusohorário
    date_default_timezone_set('America/Sao_Paulo'); 
    $date = date('Y-m-d H:i:s'); //Definir a data de quando a pessoa fez o cadastro

    //Preparando a query para ser usada, assim melhora a performance da database, além de previnir SQL Injections
    $StoredPrcedureCadastrar = $conexao -> prepare("CALL cadastrar_usuario(?, ?, ?, ?, ?, @Confirmacao)"); //Os '?' são usados para onde irão as variáveis

    $StoredPrcedureCadastrar -> bind_param('sssss', $nome, $email, $senha, $tipo, $date); //Passar os parâmetros através do bind_param || primeiro vai o tipo dos valores, no caso 5 strings e depois as variáveis que vão preencher aqueles pontos de interrogação em cima
    $StoredPrcedureCadastrar -> execute(); //Executar a Stored Procedure

    $SelectResultConfirm = "SELECT @Confirmacao AS Confirmacao"; //Buscar pelo valor retornado pela stored procedure, o qual fica guardado numa sessão temporária toda vez que é executada a Stored Procedure
    $executeResultConfirm = $conexao -> query($SelectResultConfirm);

    if($executeResultConfirm){
        $resultado = $executeResultConfirm -> fetch_assoc(); //Buscar pelo resultado

        $Confirmacao = $resultado['Confirmacao']; //Guardar em uma variável o resultado

        if($Confirmacao == TRUE){
            header('Location: ../pgs/admin/cadastrar_colaborador.php', true, 301); //Enviar para a página de cadastro caso a resposta for TRUE
            exit();
        }else{
            header('Location: ../pgs/admin/cadastrar_colaborador.php?status=failEmail', true, 301); //Enviar para a página de cadastro com falaha caso a resposta for FALSE
            exit();
        }
    } else{
        header('Location: ../pgs/admin/cadastrar_colaborador.php?status=failExSTP', true, 301); //Enviar para a página de cadastro com falaha caso a resposta for FALSE
        exit();
    }


}else{
    header('Location: ../pgs/admin/cadastrar_colaborador.php?status=fail', true, 301);
    exit();
}
//Fechar conexão com a databse
$conexao->close();