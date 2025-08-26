<?php
include("db_connect.php");

// Lê os dados enviados no corpo da requisição
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['ordem']) && is_array($data['ordem'])) {
    $stmt = $conn->prepare("UPDATE tb_itens SET ordem = ? WHERE id = ?");
    foreach ($data['ordem'] as $posicao => $id) {
        $ordemAtual = $posicao + 1;
        $stmt->bind_param("ii", $ordemAtual, $id);
        $stmt->execute();
    }
    $stmt->close();
    echo json_encode(["status" => "ok"]);
    exit;
}

echo json_encode(["status" => "erro"]);
