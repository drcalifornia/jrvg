<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

include("db_connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $descricao = $_POST['descricao'];

    $stmt = $conn->prepare("UPDATE tb_itens SET descricao = ? WHERE id = ?");
    $stmt->bind_param("si", $descricao, $id);

    if ($stmt->execute()) {
        header("Location: admin.php?success=1");
    } else {
        header("Location: admin.php?error=1");
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: admin.php");
    exit;
}
?>
