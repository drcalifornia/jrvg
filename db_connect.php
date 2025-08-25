<?php
$host = "jrvg.mysql.uhserver.com";
$user = "veronica";
$pass = "amoVeronica*2";
$db   = "jrvg";

$conn = new mysqli($host, $user, $pass, $db);

// Verificar conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}
?>
