<?php
require_once 'controllers/Controller.php';
$controller = new Controller();
$estudantes = $controller->listar();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Lista de Estudantes</title>
</head>
<body>
    <h2>Lista de Estudantes</h2>

    <form method="get" action="">
        <label for="nome">Buscar por nome:</label>
        <input type="text" id="nome" name="nome" placeholder="Digite o nome do estudante">
        <button type="submit">Buscar</button>
    </form>
    <br>    
    <?php if (!empty($estudantes)): ?>
        <table border="1">
            <tr>
                <th>Matrícula</th>
                <th>Nome</th>
                <th>Curso</th>
                <th>Ano de Ingresso</th>
                <th>Nome Responsável</th>
                <th>Contato Responsável</th>
                <th>Parentesco</th>
            </tr>
            <?php foreach ($estudantes as $estudante): ?>
                <tr>
                <td><?= htmlspecialchars($estudante->matricula) ?></td>
                    <td><?= htmlspecialchars($estudante->nome) ?></td>
                    <td><?= htmlspecialchars($estudante->curso) ?></td>
                    <td><?= htmlspecialchars($estudante->ano_ingresso) ?>
                    <td><?= htmlspecialchars($estudante->nomeResponsavel) ?></td>
                    <td><?= htmlspecialchars($estudante->contatoResponsavel) ?></td>
                    <td><?= htmlspecialchars($estudante->parentescoResponsavel) ?></td>
                    <td>
                        <a href="router.php?rota=formAtualizar&matricula=<?= $estudante->matricula ?>">
                           Atualizar
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Nenhum estudante cadastrado.</p>
    <?php endif; ?>

    <br>
    <button onclick="window.location.href='index.php'">Voltar ao Menu</button>
</body>
</html>