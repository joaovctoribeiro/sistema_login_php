<?php

    // Conexão
    require_once 'db_connect.php';

    // Sessão
    session_start();

    // Verifica se o botão enviar foi acionado.
    if(isset($_POST['btn-entrar'])) {
        $erros = array();

        // Criando validações pra entrada de dados no banco de dados.
        $login = mysqli_escape_string($connect, $_POST['login']);
        $senha = mysqli_escape_string($connect, $_POST['senha']);
    
        // Validando a população das caixas de texto.
        if(empty($login) or empty($senha)) {
            $erros[] = "<li> O campo Login/Senha precisa ser preenchido. </li>";
        }
        else {

            // Criando a query sql pra verificar se existe o login dentro do banco.
            $sql = "SELECT login FROM usuarios WHERE login = '$login';";
            $resultado = mysqli_query($connect, $sql);

            // Se for maior do que 0, então existe.
            if(mysqli_num_rows($resultado) > 0) {

                $senha = md5($senha); // Criptografando a senha.
                $sql = "SELECT * FROM usuarios WHERE login='$login' AND senha='$senha';";
                $resultado = mysqli_query($connect, $sql);

                // Verificando se login e senha digitados existem.
                if(mysqli_num_rows($resultado) == 1) {
                    $dados = mysqli_fetch_array($resultado);

                    mysqli_close($connect);

                    $_SESSION['logado'] = true;
                    $_SESSION['id_usuario'] = $dados['id'];

                    // Levando para a pagina de home se tudo estiver correto.
                    header('Location: home.php');
                }
                else {
                    $erros[] = "<li> Usuário e Senha não conferem. </li>";
                }

            }
            else {
                $erros[] = "<li> Usuário inexistente. </li>";
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>

    <h1>Logar no sistema</h1>

    <?php
    
        // Mensagens de erro.
        if (!empty($erros)) {
            foreach($erros as $erro) {
                echo $erro;
            } 
        }

    ?>

    <hr>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        Login: <input type="text" name="login" id=""><br>
        Senha: <input type="password" name="senha" id=""><br>
        <button type="submit" name="btn-entrar">Entrar</button>
    </form>

</body>
</html>