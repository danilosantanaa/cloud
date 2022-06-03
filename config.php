<?php
session_start();

// define("HOSTNAME", "clouddanilosantanamysql.mysql.database.azure.com");
// define("USERNAME", "rootdanilosantana");
// define("PASS", "danilo77");
// define("PORT", 3606);
// define("DBNAME", "db_cloud1");

// define("HOSTNAME", "localhost");
// define("USERNAME", "id19014766_danilosantana17");
// define("PASS", "|Rw]7!9K0e<kmDe[");
// define("PORT", 3306);
// define("DBNAME", "id19014766_cloud");


define("HOSTNAME", "34.69.205.28");
define("USERNAME", "root");
define("PASS", "Aa@jackson123");
define("PORT", 3606);
define("DBNAME", "db_cloud1");

try {
   $conn = new PDO("mysql:host=". HOSTNAME ."; port=". PORT .";dbname=". DBNAME, USERNAME, PASS);
} catch(PDOExecption $e) {
    echo "<p>Erro ao realizar a conexão com o banco de dado!</p>";
    die();
}

// USUARIO
$user = "guest";
$password = password_hash("guest", PASSWORD_DEFAULT);

// Fazendo cadastro automatico
$sql = "select * from tb_usuario WHERE usuario = '$user' ";

$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll();


if(count($result) == 0) {
    $sql = "insert into tb_usuario(usuario, senha, is_admin) VALUES ('$user', '$password', '1')";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
}

