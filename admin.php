<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

include("db_connect.php");

// Função para excluir item
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM tb_itens WHERE id = ?");
    $stmt->bind_param("i", $id);
    if (!$stmt->execute()) {
        die("Erro ao excluir item: " . $stmt->error);
    }
    $stmt->close();
    header("Location: admin.php");
    exit;
}

// Função para adicionar item
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_item'])) {
    $descricao = $_POST['descricao'];
    $tipo = intval($_POST['tipo']);
    $dbPath = null;

    // Upload da imagem
    if (isset($_FILES['attach']) && $_FILES['attach']['error'] === 0) {
        $uploadDir = __DIR__ . "/img/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $fileName = time() . "_" . preg_replace("/[^a-zA-Z0-9.\-_]/", "_", basename($_FILES['attach']['name']));
        $filePath = $uploadDir . $fileName;
        $dbPath = "img/" . $fileName;

        if (!move_uploaded_file($_FILES['attach']['tmp_name'], $filePath)) {
            die("Erro ao fazer upload da imagem!");
        }
    }

    $stmt = $conn->prepare("INSERT INTO tb_itens (descricao, attach, tipo) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $descricao, $dbPath, $tipo);
    if (!$stmt->execute()) {
        die("Erro ao salvar no banco de dados: " . $stmt->error);
    }
    $stmt->close();

    header("Location: admin.php");
    exit;
}

// Buscar todos os itens
$sql = "SELECT id, descricao, attach, tipo FROM tb_itens ORDER BY ordem ASC";
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

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

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
        .note-editor.note-frame {
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        #itens-container .card {
            cursor: grab;
            transition: transform 0.2s ease-in-out;
        }
        #itens-container .card:active {
            cursor: grabbing;
            transform: scale(1.02);
        }
    </style>
</head>
<body>

<div class="container">
    <div class="container mt-3 mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h3">Painel Administrativo</h1>
            <div>
                <span class="me-3">Olá, <?= $_SESSION['usuario_nome']; ?>!</span>
                <a href="logout.php" class="btn btn-outline-danger btn-sm">Sair</a>
            </div>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">+ Adicionar Item</button>
    </div>

    <!-- Tabela de itens -->
    <div class="row" id="itens-container">
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="col-md-4 mb-4 card-container" data-id="<?= $row['id'] ?>">
                    <div class="card shadow-sm">
                        <?php if (!empty($row['attach'])): ?>
                            <img src="<?= htmlspecialchars($row['attach']) ?>" alt="Imagem">
                        <?php else: ?>
                            <img src="https://via.placeholder.com/300x150?text=Sem+Imagem" alt="Sem imagem">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= $row['descricao'] ?></h5>
                            <p class="card-text">
                                <span class="badge bg-<?= $row['tipo'] == 1 ? 'info' : 'success' ?>">
                                    <?= $row['tipo'] == 1 ? 'Pessoal' : 'Profissional' ?>
                                </span>
                            </p>
                            <div class="d-flex gap-2">
                                <button class="btn btn-warning btn-sm editar-btn"
                                        data-id="<?= $row['id'] ?>"
                                        data-descricao="<?= htmlspecialchars($row['descricao']) ?>"
                                        data-imagem="<?= $row['attach'] ?>"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editModal">
                                    Editar
                                </button>
                                <a href="?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm"
                                onclick="return confirm('Tem certeza que deseja excluir este item?')">
                                    Excluir
                                </a>
                            </div>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="admin.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Adicionar Novo Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea name="descricao" id="descricao" class="form-control" required></textarea>
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

<!-- Modal de Edição -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editForm" method="POST" action="editar_item.php">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Descrição</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit-id">

                    <div class="mb-3 text-center">
                        <img id="edit-image" src="" alt="Imagem atual" class="img-fluid rounded shadow">
                    </div>

                    <div class="mb-3">
                        <label for="edit-descricao" class="form-label">Descrição</label>
                        <textarea name="descricao" id="edit-descricao" class="form-control" rows="6"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- TinyMCE -->
<script src="https://cdn.tiny.cloud/1/eweyqz79kfjdx9ywj2oi9atta8uq8el5eice0cxfcxs8pg36/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<script>
tinymce.init({
    selector: '#descricao',
    height: 300,
    language: 'pt_BR',
    skin: 'oxide', // tema claro
    plugins: 'lists advlist link image media table code help wordcount',
    toolbar: 'undo redo | formatselect | fontselect fontsizeselect | ' +
             'bold italic underline forecolor backcolor | alignleft aligncenter ' +
             'alignright alignjustify | bullist numlist outdent indent | ' +
             'link image media table | removeformat | code help',
    menubar: true,
    branding: false,
    mobile: {
        menubar: true,
        toolbar: 'undo redo | styles | bold italic underline | alignleft aligncenter alignright | bullist numlist | forecolor backcolor | code'
    }
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // TinyMCE no campo principal e no modal
    tinymce.init({
        selector: '#descricao, #edit-descricao',
        plugins: 'lists link image table code help wordcount',
        toolbar: 'undo redo | styles | bold italic underline | alignleft aligncenter alignright | bullist numlist | forecolor backcolor | code',
        height: 300,
        language: 'pt_BR',
        branding: false,
        menubar: true,
        mobile: {
            menubar: true,
            toolbar: 'undo redo | styles | bold italic underline | alignleft aligncenter alignright | bullist numlist | forecolor backcolor | code'
        }
    });

    // Preencher os dados no modal ao clicar em Editar
    const editButtons = document.querySelectorAll(".editar-btn");
    editButtons.forEach(button => {
        button.addEventListener("click", () => {
            const id = button.dataset.id;
            const descricao = button.dataset.descricao;
            const imagem = button.dataset.imagem;

            document.getElementById("edit-id").value = id;
            document.getElementById("edit-image").src = imagem || "https://via.placeholder.com/300x150?text=Sem+Imagem";

            // Atualiza o TinyMCE dentro do modal
            setTimeout(() => {
                tinymce.get('edit-descricao').setContent(descricao);
            }, 200);
        });
    });
});
</script>

<!-- SortableJS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    const container = document.getElementById("itens-container");

    let sortableInstance = null;
let dragEnabled = false;

function initSortable() {
    sortableInstance = new Sortable(container, {
            animation: 150,
            disabled: true, // inicia desativado
            onEnd: function () {
                const ordem = [];
                document.querySelectorAll("#itens-container .card-container").forEach(card => {
                    ordem.push(card.dataset.id);
                });

                fetch("salvar_ordem.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ ordem })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === "ok") {
                        console.log("Ordem salva com sucesso!");
                    } else {
                        console.error("Erro ao salvar ordem:", data);
                        alert("Erro ao salvar ordem!");
                    }
                })
                .catch(err => {
                    console.error("Falha na requisição:", err);
                    alert("Falha ao salvar ordem!");
                });
            }
        });
    }

    initSortable();

    // Ativa/desativa o drag com duplo clique
    document.querySelectorAll("#itens-container .card-container").forEach(card => {
        card.addEventListener("dblclick", function () {
            dragEnabled = !dragEnabled;
            sortableInstance.option("disabled", !dragEnabled);

            if (dragEnabled) {
                alert("Modo de reordenação ativado! Arraste os cards para reorganizar.");
            } else {
                alert("Modo de reordenação desativado!");
            }
        });
    });
});
</script>

</body>
</html>

<?php $conn->close(); ?>
