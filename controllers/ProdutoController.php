<?php
session_start();
require_once '../models/Produto.php';

if (isset($_GET['acao']) && $_GET['acao'] === 'excluir' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    Produto::excluir($id);
    header('Location: ../views/produto/listar.php');
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [
        'id' => filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT),
        'descricao' => filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
        'cor' => filter_input(INPUT_POST, 'cor', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
        'voltagem' => filter_input(INPUT_POST, 'voltagem', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
        'situacao' => $_POST['situacao'] ?? 'ativo'
    ];

    if (!$dados['descricao'] || !$dados['cor'] || !$dados['voltagem']) {
        header('Location: ../views/produto/form.php?erro=campos_obrigatorios');
        exit;
    }


    Produto::salvar($dados);

    header('Location: ../views/produto/listar.php');
    exit;
}