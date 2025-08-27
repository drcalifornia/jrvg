<?php include("db_connect.php"); ?>

<?php
// Buscar itens pessoais e profissionais
$sql = "SELECT descricao, attach, tipo FROM tb_itens ORDER BY ordem ASC";
$result = $conn->query($sql);

$itens_pessoais = [];
$itens_profissionais = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['tipo'] == 1) {
            $itens_pessoais[] = $row;
        } elseif ($row['tipo'] == 2) {
            $itens_profissionais[] = $row;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Jorge Ricardo Velez Guevara</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bandeiras -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/6.6.6/css/flag-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body, html {
            height: 100%;
            margin: 0;
        }
        .bg-cover {
            /*background-image: url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1600&q=80');*/
            background-image: url('http://jorgericardovelez.com.br/img/1756152697_1000025609.jpeg');
            background-size: cover;
            background-position: center;
            height: 100vh;
            color: white;
            text-shadow: 1px 1px 3px #000;
        }
        .overlay {
            background-color: rgba(0, 0, 0, 0.6);
            height: 100%;
            padding: 60px 0;
        }
        .section {
            padding: 80px 0;
        }
        .section-light {
            background-color: #f8f9fa;
        }
        .section-dark {
            background-color: #343a40;
            color: white;
        }
        .accordion-body img {
            max-width: 100%;
            max-height: 300px;
            object-fit: contain;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0,0,0,0.2);
        }
        .accordion-body p {
            margin-top: 10px;
            font-size: 15px;
        }
    </style>
</head>
<body>

<!-- Barra de idiomas -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark py-2">
    <div class="container-fluid d-flex justify-content-end">
        <ul class="navbar-nav flex-row gap-3">
            <li class="nav-item">
                <a class="nav-link" href="#" onclick="trocarIdioma('pt')">
                    <span class="flag-icon flag-icon-br"></span> BRA
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" onclick="trocarIdioma('en')">
                    <span class="flag-icon flag-icon-us"></span> USA
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" onclick="trocarIdioma('es')">
                    <span class="flag-icon flag-icon-es"></span> SPA
                </a>
            </li>
        </ul>
    </div>
</nav>

<!-- Capa -->
<header class="bg-cover">
    <div class="overlay d-flex flex-column justify-content-center align-items-center text-center">
        <h1 class="display-4">Jorge Ricardo Velez</h1>
        <p class="lead">Um homem de poucas palavras e muito conhecimento</p>
        <a href="#conteudo" class="btn btn-primary btn-lg mt-4">Saiba Mais</a>
    </div>
</header>

<!-- Seção 1 -->
<section class="section section-light text-center" id="conteudo">
    <div class="container">
        <!-- Título -->
        <h2 class="mb-4">Breve História</h2>

        <!-- Texto centralizado -->
        <p class="lead">
            Este espacio fue creado con el propósito de compartir mi recorrido, tanto en el ámbito profesional como en el personal. 
            A lo largo de mi vida he transitado distintos caminos, enfrentado desafíos y celebrado logros que me han formado como persona y como profesional.
        </p>
        <p class="lead">
            Aquí encontrarás los capítulos que marcaron mi carrera, las experiencias que dejaron huella y los momentos personales que dieron sentido a mi trayecto. 
            Mi intención es dejar un registro que no solo hable de lo que hice, sino también de quién soy y de lo que aprendí en el camino.
        </p>
    </div>
</section>

<!-- Seção Pessoal e Profissional -->
<section class="section section-light" id="pessoal-profissional">
    <div class="container">
        <h2 class="mb-4">Mais Sobre Jorge Ricardo</h2>
        <div class="accordion" id="accordionExample">

            <!-- Pessoal -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingPessoal">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapsePessoal" aria-expanded="false" aria-controls="collapsePessoal">
                        Pessoal
                    </button>
                </h2>
                <div id="collapsePessoal" class="accordion-collapse collapse" aria-labelledby="headingPessoal"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <?php if (!empty($itens_pessoais)): ?>
                            <div class="row">
                                <?php foreach ($itens_pessoais as $item): ?>
                                    <div class="col-md-4 mb-4 text-center">
                                        <?php if (strtolower(pathinfo($item['attach'], PATHINFO_EXTENSION)) === 'pdf'): ?>
                                            <!-- Card para PDFs -->
                                            <button class="btn btn-danger w-100 mb-2 ver-pdf-btn"
                                                    data-pdf="<?= htmlspecialchars($item['attach']) ?>"
                                                    data-descricao="<?= htmlspecialchars($item['descricao']) ?>">
                                                📄 Ver PDF
                                            </button>
                                        <?php else: ?>
                                            <!-- Card para imagens -->
                                            <img data-src="<?= htmlspecialchars($item['attach']) ?>" alt="Imagem" class="lazy-img img-fluid rounded shadow" loading="lazy">
                                        <?php endif; ?>
                                        <p><?= $item['descricao']; ?></p>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <p class="text-muted">Nenhum item pessoal encontrado.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Profissional -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingProfissional">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseProfissional" aria-expanded="false" aria-controls="collapseProfissional">
                        Profissional
                    </button>
                </h2>
                <div id="collapseProfissional" class="accordion-collapse collapse" aria-labelledby="headingProfissional"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <?php if (!empty($itens_profissionais)): ?>
                            <div class="row">
                                <?php foreach ($itens_profissionais as $item): ?>
                                    <div class="col-md-4 mb-4 text-center">
                                        <?php if (strtolower(pathinfo($item['attach'], PATHINFO_EXTENSION)) === 'pdf'): ?>
                                            <!-- Card para PDFs -->
                                            <button class="btn btn-danger w-100 mb-2 ver-pdf-btn"
                                                data-pdf="<?= htmlspecialchars($item['attach']) ?>"
                                                data-descricao="<?= htmlspecialchars($item['descricao']) ?>">
                                            📄 Ver PDF
                                        </button>
                                        <?php else: ?>
                                            <!-- Card para imagens -->
                                            <img data-src="<?= htmlspecialchars($item['attach']) ?>" alt="Imagem" class="lazy-img img-fluid rounded shadow" loading="lazy">
                                        <?php endif; ?>
                                        <p><?= $item['descricao']; ?></p>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <p class="text-muted">Nenhum item profissional encontrado.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Seção 2 -->
<section class="section section-dark">
    <div class="container text-center">
        <h2 class="mb-5">Entre em Contato</h2>
        <div class="row g-4 justify-content-center">
            <!-- Facebook -->
            <div class="col-6 col-md-3">
                <a href="https://facebook.com/seuperfil" target="_blank" class="text-decoration-none text-white">
                    <i class="fab fa-facebook fa-3x mb-2"></i>
                    <p class="mb-0">/seuperfil</p>
                </a>
            </div>
            <!-- Instagram -->
            <div class="col-6 col-md-3">
                <a href="https://instagram.com/seuperfil" target="_blank" class="text-decoration-none text-white">
                    <i class="fab fa-instagram fa-3x mb-2"></i>
                    <p class="mb-0">@seuperfil</p>
                </a>
            </div>
            <!-- WhatsApp -->
            <div class="col-6 col-md-3">
                <a href="https://wa.me/5561999999999" target="_blank" class="text-decoration-none text-white">
                    <i class="fab fa-whatsapp fa-3x mb-2"></i>
                    <p class="mb-0">+55 (61) 99999-9999</p>
                </a>
            </div>
            <!-- E-mail -->
            <div class="col-6 col-md-3">
                <a href="mailto:contato@seusite.com" class="text-decoration-none text-white">
                    <i class="fas fa-envelope fa-3x mb-2"></i>
                    <p class="mb-0">contato@seusite.com</p>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Rodapé -->
<footer class="text-center text-white bg-dark py-4">
    <p class="mb-0">© 2025 JRVG. Todos os direitos reservados.</p>
</footer>

<!-- Modal PDF -->
<div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="pdfModalLabel">Visualizar PDF</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <iframe id="pdfFrame" src="" width="100%" height="600px" style="border:none;"></iframe>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.querySelectorAll('.ver-pdf-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const pdfUrl = this.dataset.pdf;
        const descricao = this.dataset.descricao;

        // Atualiza título do modal
        //document.getElementById('pdfModalLabel').textContent = descricao;

        // Seta o PDF no iframe
        if (/Mobi|Android/i.test(navigator.userAgent)) {
            window.open(pdfUrl, '_blank');
        } else {
            document.getElementById('pdfFrame').src = pdfUrl;
            const modal = new bootstrap.Modal(document.getElementById('pdfModal'));
            modal.show();
        }
    });
});

// Limpar o iframe ao fechar o modal (para economizar memória no mobile)
document.getElementById('pdfModal').addEventListener('hidden.bs.modal', function() {
    document.getElementById('pdfFrame').src = "";
});
</script>

<script>
// Lazy loading: só carrega as imagens quando a aba do accordion for aberta
document.querySelectorAll('.accordion-collapse').forEach(section => {
    section.addEventListener('shown.bs.collapse', function() {
        const imgs = this.querySelectorAll('.lazy-img');
        imgs.forEach(img => {
            if (!img.src) {
                img.src = img.dataset.src;
            }
        });
    });
});
</script>
</body>
</html>

<?php $conn->close(); ?>
