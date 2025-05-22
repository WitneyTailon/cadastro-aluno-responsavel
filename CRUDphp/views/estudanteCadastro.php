<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Estudante</title>
    <link rel="stylesheet" href="css/styleCadastro.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <?php if(isset($_GET['sucesso'])): ?>
        <p style="color: green;">Estudante cadastrado com sucesso!</p>
    <?php endif; ?>
    <main>
    <div class="data">
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
    <div id="estudante">
        <form action="router.php?rota=cadastrarEstudante" method="POST">
        <h2>Cadastro Aluno</h2>
        <div class="input-group mb-3">
            <span class="input-group-text" id="inputGroup-sizing-default"><i class="fa-solid fa-id-card"></i>Número da matrícula</span>
            <input type="number" name="matricula" placeholder="Digite o número da matrícula" maxlength="7" required class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="inputGroup-sizing-default"><i class="fa-solid fa-user"></i>Nome do estudante</span>
            <input type="text" name="nomeAluno" placeholder="Digite o nome do estudante" maxlength="100" required class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="inputGroup-sizing-default"><i class="fa-solid fa-list"></i>Curso</span>
            <select required class="form-select form-select-sm" name="curso" aria-label="Small select example">
                <option disabled selected>Selecione o curso do estudante</option>
                <option value="Informática">Informática</option>
                <option value="Enfermagem">Enfermagem</option>
                <option value="Administração">Administração</option>
                <option value="Des. de Sistemas">Des. de Sistemas</option>
            </select>
        </div>
        
        <div class="input-group mb-3">
            <span class="input-group-text" id="inputGroup-sizing-default"><i class="fa-solid fa-calendar"></i>Ano de Ingresso</span>
            <input type="number" name="ano_ingresso" placeholder="Digite o ano de ingresso do estudante" min="2000" max="2100" maxlength="4" required class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
        </div>
    </div>

    <div id="responsaveis">
        <h2>Cadastro Responsável</h2>
        <div id="r1">
            <input id="contResp" name="contResp" type="hidden" value="0">
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default"><i class="fa-solid fa-user"></i>Nome do responsável</span>
                <input type="text" name="nomeResponsavel[]" placeholder="Digite o nome do responsável" maxlength="100" required class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">
                    <i class="fa-solid fa-phone"></i>Contato responsável
                </span>
                <input type="text" name="contatoResponsavel[]" placeholder="(00) 00000-0000" class="telefone form-control" maxlength="15" required class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default"><i class="fa-solid fa-hands-holding-child"></i>Parentesco</span>
                <select class="form-select form-select-sm" name="parentescoResponsavel[]" aria-label="Small select example">
                    <option required disabled selected>Selecione o parentesco do responsavel</option>
                    <option value="Mãe">Mãe</option>
                    <option value="Pai">Pai</option>
                    <option value="Irmãos">Irmão/Irmã</option>
                    <option value="Tios">Tio/Tia</option>
                    <option value="Avós">Avô/Avó</option>
                </select>
            </div>
            <button id="buttonR" type="button">+Add Responsável</button>
            <div id="r2" class="escondido">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-default"><i class="fa-solid fa-user"></i>Nome do responsável</span>
                    <input type="text" name="nomeResponsavel[]" placeholder="Digite o nome do responsável" maxlength="100" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-default">
                        <i class="fa-solid fa-phone"></i>Contato responsável
                    </span>
                    <input type="text" name="contatoResponsavel[]" placeholder="(00) 00000-0000" class="telefone form-control" maxlength="15" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                </div>

                
                <div class="input-group mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-default"><i class="fa-solid fa-hands-holding-child"></i>Parentesco</span>
                    <select class="form-select form-select-sm" name="parentescoResponsavel[]" aria-label="Small select example">
                            <option disabled selected>Selecione o parentesco do responsavel</option>
                            <option value="Mãe">Mãe</option>
                            <option value="Pai">Pai</option>
                            <option value="Irmãos">Irmão/Irmã</option>
                            <option value="Tios">Tio/Tia</option>
                            <option value="Avós">Avô/Avó</option>
                    </select>
                </div>
                <button type="button" id="buttonRe">Remover</button>
            </div>
        </div>
    </div>
    <div class="buttons">
        <input class="button" type="submit" value="Cadastrar">
        <button type="button" class="button" onclick="window.location.href='index.php'" class="btn btn-secondary btn-lg">Voltar</button>
    </div>
    </form>
    </div>
    </div>
    </main>
    <script>
        const buttonR = document.getElementById("buttonR");
        const buttonRe = document.getElementById("buttonRe");
        const r2 = document.getElementById("r2");
        const inputsR2 = r2.querySelectorAll("input, select");

        buttonR.addEventListener("click", () => {
            buttonR.classList.add("escondido");
            r2.classList.remove("escondido");
            let contResp = document.getElementById("contResp");
            contResp.value = 1;
            inputsR2.forEach(element => {
                element.required = true;
            });
        });

        buttonRe.addEventListener("click", () => {
            let contResp = document.getElementById("contResp");
            contResp.value = 0;
            inputsR2.forEach(element => {
                element.required = false;
            });
            buttonR.classList.remove("escondido");
            r2.classList.add("escondido");
        });

        // Função que aplica a máscara de telefone
        function aplicarMascaraTelefone(input) {
            input.addEventListener('input', function (e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 11) value = value.slice(0, 11);

                if (value.length <= 10) {
                    value = value.replace(/^(\d{0,2})(\d{0,4})(\d{0,4})/, (_, a, b, c) => {
                        return `(${a}${b ? `) ${b}` : ''}${c ? `-${c}` : ''}`;
                    });
                } else {
                    value = value.replace(/^(\d{0,2})(\d{0,5})(\d{0,4})/, (_, a, b, c) => {
                        return `(${a}${b ? `) ${b}` : ''}${c ? `-${c}` : ''}`;
                    });
                }

                e.target.value = value;
            });
        }

        // Aplica a máscara em todos os inputs .telefone já existentes ao carregar
        document.querySelectorAll('.telefone').forEach(aplicarMascaraTelefone);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>
</html>


