<?php include("db_connect.php"); ?>

<?php
// Buscar itens pessoais e profissionais
$sql = "SELECT a.descricao, attach, tipo, b.descricao as idioma FROM tb_itens a LEFT JOIN tb_idiomas b ON a.id_idioma = b.id ORDER BY ordem ASC";
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

// Idioma padrão
$idioma_ativo = 'es'; // es = espanhol

// Usar esse idioma para definir as strings
if ($idioma_ativo == 'pt') {
    $desc_titulo = ' ';
    $saiba_mais = 'Saiba Mais';
    $breve_historia = 'Breve História';
    $breve_historia_p1 = 'Este espaço foi criado com o propósito de compartilhar minha trajetória, tanto no âmbito profissional quanto no pessoal. Ao longo da minha vida, percorri diferentes caminhos, enfrentei desafios e celebrei conquistas que me formaram como pessoa e como profissional.';
    $breve_historia_p2 = 'Aqui você encontrará os capítulos que marcaram minha carreira, as experiências que deixaram marcas e os momentos pessoais que deram sentido à minha jornada. Minha intenção é deixar um registro que fale não apenas do que fiz, mas também de quem sou e do que aprendi ao longo do caminho.';
    $breve_historia_p3 = '<b>Agradecimento</b><br>Quero expressar meu mais sincero agradecimento a Carlos, Fergus e Verônica pelo valioso apoio e dedicação na criação do meu site. Graças ao esforço, criatividade e comprometimento de vocês, hoje tenho uma ferramenta que reflete de forma clara e profissional o meu trabalho, minhas ideias e meus sonhos.<br>A paciência de vocês, suas contribuições e o tempo investido neste projeto tornaram possível que esta página não seja apenas um espaço digital, mas também um reflexo de quem eu sou e do que desejo compartilhar com os outros.<br>Com todo carinho e gratidão,<br><br>Ricardo Velez';
    $mais_jr = 'Mais Sobre Jorge Ricardo';
    $pessoal = 'Pessoal';
    $profissional = 'Profissional';
    $contato = 'Entre em Contato';
    $direitos = 'Todos os direitos reservados.';
} elseif ($idioma_ativo == 'en') {
    $desc_titulo = ' ';
    $saiba_mais = 'Learn More';
    $breve_historia = 'Brief History';
    $breve_historia_p1 = 'This space was created with the intention of sharing my journey, both professional and personal. Throughout my life, I have followed different paths, faced challenges, and celebrated achievements that have shaped me as a person and as a professional.';
    $breve_historia_p2 = 'Here you will find the chapters that marked my career, the experiences that left a lasting impression, and the personal moments that gave meaning to my path. My intention is to leave a record that speaks not only of what I did, but also of who I am and what I learned along the way.';
    $breve_historia_p3 = '<b>Gratitude</b><br>I want to express my deepest gratitude to Carlos, Fergus, and Verónica for their valuable support and dedication in creating my website. Thanks to their effort, creativity, and commitment, I now have a tool that clearly and professionally reflects my work, my ideas, and my dreams.<br>Their patience, input, and the time they invested in this project made it possible for this page to be not just a digital space, but also a reflection of who I am and what I want to share with others.<br>With all my affection and gratitude,<br><br>Ricardo Velez';
    $mais_jr = 'More About Jorge Ricardo';
    $pessoal = 'Personal';
    $profissional = 'Professional';
    $contato = 'Contact Me';
    $direitos = 'All rights reserved.';
} else {
    // Espanhol (padrão)
    $desc_titulo = ' ';
    $saiba_mais = 'Saber Más';
    $breve_historia = 'Breve Historia';
    $breve_historia_p1 = 'Este espacio fue creado con el propósito de compartir mi recorrido, tanto en el ámbito profesional como en el personal. A lo largo de mi vida he transitado distintos caminos, enfrentado desafíos y celebrado logros que me han formado como persona y como profesional.';
    $breve_historia_p2 = 'Aquí encontrarás los capítulos que marcaron mi carrera, las experiencias que dejaron huella y los momentos personales que dieron sentido a mi trayecto. Mi intención es dejar un registro que no solo hable de lo que hice, sino también de quién soy y de lo que aprendí en el camino.';
    $breve_historia_p3 = '<b>Agradecimiento</b><br>Quiero expresar mi más sincero agradecimiento a Carlos, Fergus y Verónica por el valioso apoyo y dedicación en la creación de mi página web. Gracias a su esfuerzo, creatividad y compromiso, hoy cuento con una herramienta que refleja de manera clara y profesional mi trabajo, mis ideas y mis sueños.<br>Su paciencia, sus aportes y el tiempo invertido en este proyecto han hecho posible que esta página no sea solo un espacio digital, sino también un reflejo de lo que soy y de lo que quiero compartir con los demás.<br>Con todo cariño y gratitud,<br><br>Ricardo Velez';
    $mais_jr = 'Más Sobre Jorge Ricardo';
    $pessoal = 'Personal';
    $profissional = 'Profesional';
    $contato = 'Contacto';
    $direitos = 'Todos los derechos reservados.';
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
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap" rel="stylesheet" />

    <style>
        body, html {
            height: 100%;
            margin: 0;
        }
        .bg-cover {
            /*background-image: url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1600&q=80');*/
            background-image: url('http://jorgericardovelez.com.br/img/1756152697_1000025609_v2.jpeg');
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
        nav-link.active {
            font-weight: bold;
            color: #ffc107 !important; /* amarelo */
        }
        .sign {
            font-family: "Dancing Script", cursive;
        }
    </style>
</head>
<body>

<!-- Barra de idiomas -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark py-2">
    <div class="container-fluid d-flex justify-content-end">
        <ul class="navbar-nav flex-row gap-3">
            <li class="nav-item">
                <a class="nav-link <?php echo ($idioma_ativo == 'pt') ? 'active' : ''; ?>" href="#">
                    <span class="flag-icon flag-icon-br"></span> BRA
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($idioma_ativo == 'en') ? 'active' : ''; ?>" href="#">
                    <span class="flag-icon flag-icon-us"></span> USA
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($idioma_ativo == 'es') ? 'active' : ''; ?>" href="#">
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
        <p class="lead" id="desc-titulo"><?php echo($desc_titulo);?></p>
        <a href="#conteudo" class="btn btn-primary btn-lg mt-4" id="saiba-mais"><?php echo($saiba_mais);?></a>
    </div>
</header>

<!-- Seção 1 -->
<section class="section section-light text-center" id="conteudo">
    <div class="container">
        <!-- Título -->
        <h2 class="mb-4" id="breve-historia"><?php echo($breve_historia);?></h2>

        <!-- Texto centralizado -->
        <p class="lead" id="bh-p1">
            <?php echo($breve_historia_p1);?>
        </p>
        <p class="lead" id="bh-p2">
            <?php echo($breve_historia_p2);?>
        </p>
        <p class="lead" id="bh-p3">
            <?php echo($breve_historia_p3);?>
        </p>
    </div>
</section>

<!-- Seção Pessoal e Profissional -->
<section class="section section-light" id="pessoal-profissional">
    <div class="container">
        <h2 class="mb-4" id="mais-jr"><?php echo($mais_jr);?></h2>
        <div class="accordion" id="accordionExample">

            <!-- Pessoal -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingPessoal">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapsePessoal" aria-expanded="false" aria-controls="collapsePessoal" id="btn-pessoal">
                        <?php echo($pessoal);?>
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
                                        <p class="descricao_item"><?= $item['descricao']; ?></p>
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
                        data-bs-target="#collapseProfissional" aria-expanded="false" aria-controls="collapseProfissional" id="btn-profissional">
                        <?php echo($profissional);?>
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
                                        <p class="descricao_item"><?= $item['descricao']; ?></p>
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
        <h2 class="mb-5" id="contato"><?php echo($contato);?></h2>
        <div class="row g-4 justify-content-center">
            <!-- WhatsApp -->
            <div class="col-6 col-md-4">
                <a href="https://wa.me/5561996921971" target="_blank" class="text-decoration-none text-white">
                    <i class="fab fa-whatsapp fa-3x mb-2"></i>
                    <p class="mb-0">+55 61 99692-1971</p>
                </a>
            </div>
            <!-- E-mail -->
            <div class="col-6 col-md-4">
                <a href="mailto:ricvel299@hotmail.com" class="text-decoration-none text-white">
                    <i class="fas fa-envelope fa-3x mb-2"></i>
                    <p class="mb-0">ricvel299@hotmail.com</p>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Rodapé -->
<footer class="text-center text-white bg-dark py-4">
    <p class="mb-0" id="rodape">© 2025 JRVG. <?php echo($direitos);?></p>
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
<script>
    const traducoes = {
        pt: {
            desc_titulo: " ",
            saiba_mais: "Saiba Mais",
            breve_historia: "Breve História",
            breve_historia_p1: 'Este espaço foi criado com o propósito de compartilhar minha trajetória, tanto no âmbito profissional quanto no pessoal. Ao longo da minha vida, percorri diferentes caminhos, enfrentei desafios e celebrei conquistas que me formaram como pessoa e como profissional.',
            breve_historia_p2: 'Aqui você encontrará os capítulos que marcaram minha carreira, as experiências que deixaram marcas e os momentos pessoais que deram sentido à minha jornada. Minha intenção é deixar um registro que fale não apenas do que fiz, mas também de quem sou e do que aprendi ao longo do caminho.',
            breve_historia_p3: '<br><h2>Agradecimento</h2><br>Quero expressar meu mais sincero agradecimento a Carlos, Fergus e Verônica pelo valioso apoio e dedicação na criação do meu site. Graças ao esforço, criatividade e comprometimento de vocês, hoje tenho uma ferramenta que reflete de forma clara e profissional o meu trabalho, minhas ideias e meus sonhos.<br>A paciência de vocês, suas contribuições e o tempo investido neste projeto tornaram possível que esta página não seja apenas um espaço digital, mas também um reflexo de quem eu sou e do que desejo compartilhar com os outros.<br>Com todo carinho e gratidão,<br><p class="sign">Ricardo Velez</p>',
            mais_jr: "Mais Sobre Jorge Ricardo",
            pessoal: "Pessoal",
            profissional: "Profissional",
            contato: "Entre em Contato",
            direitos: "Todos os direitos reservados."
        },
        en: {
            desc_titulo: " ",
            saiba_mais: "Learn More",
            breve_historia: "Brief History",
            breve_historia_p1: 'This space was created with the intention of sharing my journey, both professional and personal. Throughout my life, I have followed different paths, faced challenges, and celebrated achievements that have shaped me as a person and as a professional.',
            breve_historia_p2: 'Here you will find the chapters that marked my career, the experiences that left a lasting impression, and the personal moments that gave meaning to my path. My intention is to leave a record that speaks not only of what I did, but also of who I am and what I learned along the way.',
            breve_historia_p3: '<br><h2>Gratitude</h2><br>I want to express my deepest gratitude to Carlos, Fergus, and Verónica for their valuable support and dedication in creating my website. Thanks to their effort, creativity, and commitment, I now have a tool that clearly and professionally reflects my work, my ideas, and my dreams.<br>Their patience, input, and the time they invested in this project made it possible for this page to be not just a digital space, but also a reflection of who I am and what I want to share with others.<br>With all my affection and gratitude,<br><p class="sign">Ricardo Velez</p>',
            mais_jr: "More About Jorge Ricardo",
            pessoal: "Personal",
            profissional: "Professional",
            contato: "Contact Me",
            direitos: "All rights reserved."
        },
        es: {
            desc_titulo: " ",
            saiba_mais: "Saber Más",
            breve_historia: "Breve Historia",
            breve_historia_p1: 'Este espacio fue creado con el propósito de compartir mi recorrido, tanto en el ámbito profesional como en el personal. A lo largo de mi vida he transitado distintos caminos, enfrentado desafíos y celebrado logros que me han formado como persona y como profesional.',
            breve_historia_p2: 'Aquí encontrarás los capítulos que marcaron mi carrera, las experiencias que dejaron huella y los momentos personales que dieron sentido a mi trayecto. Mi intención es dejar un registro que no solo hable de lo que hice, sino también de quién soy y de lo que aprendí en el camino.',
            breve_historia_p3: '<br><h2>Agradecimiento</h2><br>Quiero expresar mi más sincero agradecimiento a Carlos, Fergus y Verónica por el valioso apoyo y dedicación en la creación de mi página web. Gracias a su esfuerzo, creatividad y compromiso, hoy cuento con una herramienta que refleja de manera clara y profesional mi trabajo, mis ideas y mis sueños.<br>Su paciencia, sus aportes y el tiempo invertido en este proyecto han hecho posible que esta página no sea solo un espacio digital, sino también un reflejo de lo que soy y de lo que quiero compartir con los demás.<br>Con todo cariño y gratitud,<br><p class="sign">Ricardo Velez</p>',
            mais_jr: "Más Sobre Jorge Ricardo",
            pessoal: "Personal",
            profissional: "Profesional",
            contato: "Contacto",
            direitos: "Todos los derechos reservados."
        }
    };

    async function traduzirTexto(texto, idiomaDestino = "en") {
        console.log(texto);
        try {
            const response = await fetch("traduzir.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    q: texto,
                    source: "es",
                    target: idiomaDestino,
                    format: "text"
                })
            });
            const data = await response.json();
            return data.translatedText;
        } catch (error) {
            console.error("Erro ao traduzir:", error);
            return texto; // Fallback: retorna texto original
        }
    }
</script>
<script>
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();

            // Atualiza classe 'active'
            document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
            this.classList.add('active');

            const idioma = this.textContent.trim().toLowerCase().substring(0, 2); // 'br', 'us', 'es'

            const lang = idioma === 'br' ? 'pt' : idioma === 'us' ? 'en' : 'es';

            const t = traducoes[lang];

            document.getElementById('desc-titulo').textContent = t.desc_titulo;
            document.getElementById('saiba-mais').textContent = t.saiba_mais;
            document.getElementById('breve-historia').textContent = t.breve_historia;
            document.getElementById('bh-p1').innerHTML = t.breve_historia_p1;
            document.getElementById('bh-p2').innerHTML = t.breve_historia_p2;
            document.getElementById('bh-p3').innerHTML = t.breve_historia_p3;
            document.getElementById('mais-jr').textContent = t.mais_jr;
            document.getElementById('btn-pessoal').textContent = t.pessoal;
            document.getElementById('btn-profissional').textContent = t.profissional;
            document.getElementById('contato').textContent = t.contato;
            document.getElementById('rodape').textContent = `© 2025 JRVG. ${t.direitos}`;

            // Traduz os cards dinamicamente
            /*const descricoes = document.querySelectorAll('.descricao_item'); // classe usada nos cards
            console.log(descricoes);
            descricoes.forEach(async (el) => {
                const textoOriginal = el.dataset.original || el.innerText;

                // Cache do texto original no dataset
                if (!el.dataset.original) el.dataset.original = textoOriginal;

                const traducao = await traduzirTexto(textoOriginal, lang);
                el.innerText = traducao;
            });*/
        });
    });
</script>
</body>
</html>

<?php $conn->close(); ?>
