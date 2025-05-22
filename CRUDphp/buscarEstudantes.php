<?php
require_once 'controllers/Controller.php';

$controller = new Controller();
$filtroNome = $_GET['nome'] ?? null;
$filtroAno = $_GET['ano_ingresso'] ?? null;
$filtroCurso = $_GET['curso'] ?? null;
$estudantes = $controller->listar($filtroNome, $filtroAno, $filtroCurso);   
header('Content-Type: application/json');
echo json_encode($estudantes);
?>