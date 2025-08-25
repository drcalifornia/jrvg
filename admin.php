<?php include("db_connect.php"); ?>

<?php
// Função para excluir item
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM tb_itens WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: admin.php");
    exit;
}

// Função para adicionar item
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_item'])) {
    $descricao = $_POST['descricao'];
    $tipo = $_POST['tipo'];

    // Upload da imagem
    if (isset($_FILES['attach']) && $_FILES['attach']['error'] == 0) {
        $uploadDir = "img/";
        $fileName = time() . "_" . basename($_FILES['attach']['name']);
        $filePath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['attach']['tmp_name'], $filePath)) {
            $stmt = $conn->prepare("INSERT INTO tb_itens (descricao, attach, tipo) VALUES (?, ?, ?)");
            $stmt->bind_param("ssi", $descricao, $filePath, $tipo);
            $stmt->execute();
            $stmt->close();
        }
    }

    header("Location: admin.php");
    exit;
}

// Buscar todos os itens
$sql = "SELECT id, descricao, attach, tipo FROM tb_itens ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Painel Administrativo</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f6f9;
        }
        .container {
            margin-top: 40px;
        }
        .card img {
            max-width: 100%;
            max-height: 150px;
            object-fit: cover;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0,0,0,0.2);
        }
        .modal-content {
            border-radius: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Painel Administrativo</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">+ Adicionar Item</button>
    </div>

    <!-- Tabela de itens -->
    <div class="row">
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                        <?php if (!empty($row['attach'])): ?>
                            <img src="<?= htmlspecialchars($row['attach']) ?>" alt="Imagem">
                        <?php else: ?>
                            <img src="https://via.placeholder.com/300x150?text=Sem+Imagem" alt="Sem imagem">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($row['descricao']) ?></h5>
                            <p class="card-text">
                                <span class="badge bg-<?= $row['tipo'] == 1 ? 'info' : 'success' ?>">
                                    <?= $row['tipo'] == 1 ? 'Pessoal' : 'Profissional' ?>
                                </span>
                            </p>
                            <a href="?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm"
                               onclick="return confirm('Tem certeza que deseja excluir este item?')">
                                Excluir
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-muted">Nenhum item encontrado.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Modal de adicionar item -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="admin.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Adicionar Novo Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <input type="text" name="descricao" id="descricao" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="tipo" class="form-label">Tipo</label>
                        <select name="tipo" id="tipo" class="form-control" required>
                            <option value="1">Pessoal</option>
                            <option value="2">Profissional</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="attach" class="form-label">Imagem</label>
                        <input type="file" name="attach" id="attach" class="form-control" accept="image/*" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" name="add_item" class="btn btn-primary">Adicionar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>
