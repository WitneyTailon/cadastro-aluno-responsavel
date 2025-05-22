<?php
require_once 'controllers/Controller.php';
$controller = new Controller();

$filtroAno = isset($_GET['ano_ingresso']) ? $_GET['ano_ingresso'] : null;
$filtroNome = isset($_GET['nome']) ? $_GET['nome'] : null;
$filtroCurso = isset($_GET['curso']) ? $_GET['curso'] : null;
$estudantes = $controller->listar($filtroNome, $filtroAno, $filtroCurso);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Estudantes</title>
    <link rel="stylesheet" href="css/styleListar.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<main>
<!-- Header com navbar -->
<header class="navbar">
        <nav class="navbar fixed-top" style="background-color: #57AB48;">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="./images/LogoAmelia.png" alt="Logo Amélia" width="113px" height="70px">
                </a>
                <!-- Botão do menu (offcanvas) -->
                <button class="navbar-toggler" style="color: white; border: 0;" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                    <img src="./images/MenuIcon.png" alt="Menu" width="40px" height="40px">
                </button>

                <!-- Menu lateral -->
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">EEEP Amélia Figueiredo de Lavor</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                            <li class="nav-item">
                                <a class="nav-link" onclick="window.location.href='index.php'" href="#">Início</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="router.php?rota=listar">Listar Estudantes</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="router.php?rota=cadastrarEstudante">Cadastrar Estudantes</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <div class="imagem"></div>

    <h2>Lista de Estudantes</h2>

    <form method="get" action="">
        <i class="fa-solid fa-magnifying-glass"></i>
        <div class="nome">
            <input type="text" id="nome" autocomplete="off" name="nome" placeholder="Digite o nome do estudante" value="<?= htmlspecialchars($filtroNome ?? '') ?>">
        </div>
        <select name="ano_ingresso" aria-label="Small select example">
            <option value="">Selecione a série do aluno</option>
            <option value="2023" <?= ($filtoAno ?? '') == '2023' ? 'selected' : '' ?>>3°</option>
            <option value="2024" <?= ($filtoAno ?? '') == '2024' ? 'selected' : '' ?>>2°</option>
            <option value="2025" <?= ($filtoAno ?? '') == '2025' ? 'selected' : '' ?>>1°</option>
            <option value="concluido" <?= ($filtoAno ?? '') == 'concluido' ? 'selected' : '' ?>>Concluiu</option>
        </select>
        <select name="curso" aria-label="Small select example">
            <option value="">Selecione o curso do estudante</option>
            <option value="Informática" <?= ($filtroCurso ?? '') == 'Informática' ? 'selected' : '' ?>>Informática</option>
            <option value="Enfermagem" <?= ($filtroCurso ?? '') == 'Enfermagem' ? 'selected' : '' ?>>Enfermagem</option>
            <option value="Administração" <?= ($filtroCurso ?? '') == 'Administração' ? 'selected' : '' ?>>Administração</option>
            <option value="Des. de Sistemas" <?= ($filtroCurso ?? '') == 'Des. de Sistemas' ? 'selected' : '' ?>>Des. de Sistemas</option>
        </select>
        <div class="buttonL">
        <button type="button" onclick="window.location.href='router.php?rota=listar'" class="limpB">
            X
        </button>
        </div>
    </form>

    <?php if (!empty($estudantes)): ?>
        <div id="card-container">
            <?php foreach ($estudantes as $estudante): ?>
                <div style="display: none;"><?=$router = "router.php?rota=detalhesEstudante&matricula=$estudante->matricula&nome=$estudante->nome&curso=$estudante->curso&anoIngresso=$estudante->ano_ingresso&id=$estudante->id";?></div>
                <div class="estudante-card">
                    <div class="imgAluno">
                        <img src="./images/userImage.png" alt="Foto do estudante">
                    </div>
                    <div class="estudante-info">
                        <strong><?= htmlspecialchars($estudante->nome) ?></strong>
                        <div class="dadoAluno">
                            <span><?= htmlspecialchars($estudante->curso) ?></span> -
                            <span><?= htmlspecialchars($estudante->ano_ingresso) ?></span>
                        </div>
                    </div>
                    <a href="<?=$router?>" class="estudante-card-link">
                        mais detalhes ->
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <button class="voltar-btn" onclick="window.location.href='index.php'">Voltar ao Menu</button>

    </main>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const nomeInput = document.getElementById('nome');
        const anoSelect = document.querySelector('select[name="ano_ingresso"]');
        const cursoSelect = document.querySelector('select[name="curso"]');
        let timer;

        function atualizarResultados() {
            const params = new URLSearchParams();
            
            if (nomeInput.value) params.append('nome', nomeInput.value);
            if (anoSelect.value) params.append('ano_ingresso', anoSelect.value);
            if (cursoSelect.value) params.append('curso', cursoSelect.value);

            fetch(`buscarEstudantes.php?${params.toString()}`)
                .then(response => response.json())
                .then(estudantes => {
                    const container = document.getElementById('card-container');
                    
                    // Limpa o container de forma segura
                    while (container.firstChild) {
                        container.removeChild(container.firstChild);
                    }

                    if (estudantes.length === 0) {
                        const p = document.createElement('p');
                        p.style.textAlign = 'center';
                        p.textContent = 'Nenhum estudante encontrado.';
                        container.appendChild(p);
                        return;
                    }

                    estudantes.forEach(estudante => {
                        // Cria elementos DOM manualmente
                        const card = document.createElement('div');
                        card.className = 'estudante-card';

                        const imgDiv = document.createElement('div');
                        imgDiv.className = 'imgAluno';
                        const img = document.createElement('img');
                        img.src = './images/userImage.png';
                        img.alt = 'Foto do estudante';
                        imgDiv.appendChild(img);

                        const infoDiv = document.createElement('div');
                        infoDiv.className = 'estudante-info';
                        const strong = document.createElement('strong');
                        strong.textContent = estudante.nome;
                        
                        const dadosDiv = document.createElement('div');
                        dadosDiv.className = 'dadoAluno';
                        const cursoSpan = document.createElement('span');
                        cursoSpan.textContent = estudante.curso;
                        const anoSpan = document.createElement('span');
                        anoSpan.textContent = estudante.ano_ingresso;
                        
                        dadosDiv.appendChild(cursoSpan);
                        dadosDiv.appendChild(document.createTextNode(' - '));
                        dadosDiv.appendChild(anoSpan);

                        infoDiv.appendChild(strong);
                        infoDiv.appendChild(dadosDiv);

                        const link = document.createElement('a');
                        // Constrói a URL dinamicamente com os dados do estudante
                        link.href = `router.php?rota=detalhesEstudante&matricula=${estudante.matricula}&nome=${encodeURIComponent(estudante.nome)}&curso=${encodeURIComponent(estudante.curso)}&anoIngresso=${estudante.ano_ingresso}&id=${estudante.id}`;
                        textContent = mais detalhes->
                        link.className = 'estudante-card-link';
                        const icon = document.createElement('i');
                        icon.className = 'fa-solid fa-circle-info';
                        link.appendChild(icon);

                        card.appendChild(imgDiv);
                        card.appendChild(infoDiv);
                        card.appendChild(link);

                        container.appendChild(card);
                    });
                });
        }

        nomeInput.addEventListener('input', function() {
            clearTimeout(timer);
            timer = setTimeout(atualizarResultados, 500);
        });

        anoSelect.addEventListener('change', atualizarResultados);
        cursoSelect.addEventListener('change', atualizarResultados);
        atualizarResultados();
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>
</html>