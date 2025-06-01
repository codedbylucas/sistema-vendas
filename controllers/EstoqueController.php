<?php
session_start();
require_once '../models/Estoque.php';

if (!isset($_SESSION['usuario_id']) || !in_array($_SESSION['tipo'], ['admin', 'funcionario'])) {
    header("Location: ../views/login/index.php");
    exit;
}

if (isset($_GET['acao']) && $_GET['acao'] === 'excluir' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    Estoque::excluir($id);
    header('Location: ../views/estoque/listar.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [
        'id' => filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT),
        'produto_id' => filter_input(INPUT_POST, 'produto_id', FILTER_VALIDATE_INT),
        'saldo' => filter_input(INPUT_POST, 'saldo', FILTER_VALIDATE_INT),
        'preco' => filter_input(INPUT_POST, 'preco', FILTER_VALIDATE_FLOAT),
        'descricao' => filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_FULL_SPECIAL_CHARS)
    ];

    if (Estoque::salvar($dados)) {
        header('Location: ../views/estoque/listar.php');
    } else {
        echo "<script>alert('Erro ao salvar estoque.'); window.history.back();</script>";
    }
    exit;
}
