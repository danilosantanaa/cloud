<?php
    require_once("config.php");

    $user = $_POST['user'] ?? null;
    $password = $_POST['pass'] ?? null;

    $loginCorreto = $user != null & $password != null;
    $showAnimation = $user == null  && $password == null || $user == "" && $password == "";
    
    $senhaCorreta =  true;
    // Fazendo uma pesquisa no banco de dados pelo usuário

    if($user != null && $password != null) {
        $sql = "SELECT * FROM tb_usuario WHERE usuario = :USER AND is_admin = '1' LIMIT 1";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(":USER", $user, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch();

        if($result) {
            if(password_verify($password, $result['senha'])) {
                // Criar a sessão e redirecionar o usuário para essa sessão
                $_SESSION['id'] = $result['id'];
                $_SESSION['usuario'] = $result['usuario'];
                $_SESSION['senha'] = $result['senha'];
                $_SESSION['is_admin'] = $result['is_admin'];

                header("location: index.php");
                exit();
            }
        } 

        $senhaCorreta =  false;
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/fontawesome-free-6.1.1-web/css/all.min.css">
    <link rel="stylesheet" href="css/login.css">
    <title>Login</title>
</head>
<body>
    <div id="form-login" class="<?php echo $showAnimation ? "login-in" : "" ?>">

        <form action="login.php" method="post">
            <div id="user-logo"></div>
            <?php
            if(!$senhaCorreta) {
                echo "<div class='login-erro'> <i class=\"fa-solid fa-triangle-exclamation\"></i> Nome de usuário/senha inválido!</div>";
            }
            ?>
            <div class="input">
                <label for="usuarioID">Usuario: </label>
                <input type="text" name="user" id="usuarioID" placeholder="Usuario">
            </div>

            <div class="input">
                <label for="senhaID">Senha: </label>
                <input type="password" name="pass" id="senhaID" placeholder="Senha" >
            </div>

            <div class="input">
                <input type="submit" value="Entrar">
            </div>
        </form>
    </div>
</body>
</html>