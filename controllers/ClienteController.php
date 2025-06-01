<?php
session_start();
require_once '../models/Cliente.php';

if (isset($_GET['acao']) && $_GET['acao'] === 'excluir' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    Cliente::excluir($id);
    header('Location: ../views/cliente/listar.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [
        'id' => filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT),
        'nome' => filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
        'cpf' => filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_STRING),
        'idade' => filter_input(INPUT_POST, 'idade', FILTER_VALIDATE_INT),
        'cidade' => filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
        'endereco' => filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
        'data_nascimento' => $_POST['data_nascimento'], 
        'estado_civil' => filter_input(INPUT_POST, 'estado_civil', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
        'sexo' => $_POST['sexo'] 
    ];

    if (Cliente::salvar($dados)) {
        header('Location: ../views/cliente/listar.php');
    } else {
        echo "<script>alert('Erro ao salvar cliente.'); window.history.back();</script>";
    }
    exit;
}
