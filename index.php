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
                                        <img data-src="<?= htmlspecialchars($item['attach']) ?>" alt="Imagem" class="lazy-img" loading="lazy">
                                        <p><?php echo $item['descricao']; ?></p>
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
                                        <img data-src="<?= htmlspecialchars($item['attach']) ?>" alt="Imagem" class="lazy-img" loading="lazy">
                                        <p><?php echo $item['descricao']; ?></p>
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
    <div class="container">
        <h2 class="mb-4">Entre em contato</h2>
        <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend orci vel nunc ultrices, sed sagittis felis bibendum. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae.
        </p>
        <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur lacinia tellus vitae urna eleifend feugiat. Nam fermentum viverra sagittis. Proin ut semper sem, ac fermentum enim. Sed ut metus nec lacus luctus egestas.
        </p>
    </div>
</section>

<!-- Rodapé -->
<footer class="text-center text-white bg-dark py-4">
    <p class="mb-0">© 2025 JRVG. Todos os direitos reservados.</p>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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
