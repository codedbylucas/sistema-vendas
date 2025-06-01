<?php
session_start();
require_once '../models/LoginCliente.php';
require_once '../models/Cliente.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo'] !== 'funcionario') {
    header("Location: ../views/login/index.php");
    exit;
}

// Exclusão
if (isset($_GET['acao']) && $_GET['acao'] === 'excluir' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    LoginCliente::excluir($id);
    header("Location: ../views/usuario/listar_clientes.php");
    exit;
}

// Edição
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['acao'] === 'editar') {
    $id = intval($_POST['id']);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $cliente_id = intval($_POST['cliente_id']);
    $senha = $_POST['senha'];

    $cliente = Cliente::buscarPorId($cliente_id);
    $nome = $cliente['nome'] ?? '';

    if (!$nome || !$email || !$cliente_id) {
        echo "<script>alert('Preencha todos os campos corretamente.'); window.history.back();</script>";
        exit;
    }

    if (!empty($senha)) {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        LoginCliente::atualizarComSenha($id, $cliente_id, $nome, $email, $senhaHash);
    } else {
        LoginCliente::atualizarSemSenha($id, $cliente_id, $nome, $email);
    }

    header("Location: ../views/usuario/listar_clientes.php");
    exit;
}

// Cadastro
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['acao'] === 'cadastrar_cliente') {
    $cliente_id = intval($_POST['cliente_id']);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'];

    $cliente = Cliente::buscarPorId($cliente_id);
    $nome = $cliente['nome'] ?? '';

    if (empty($cliente_id) || empty($email) || empty($senha) || empty($nome)) {
        echo "<script>alert('Preencha todos os campos corretamente.'); window.history.back();</script>";
        exit;
    }

    $dados = [
        'cliente_id' => $cliente_id,
        'nome' => $nome,
        'email' => $email,
        'senha' => password_hash($senha, PASSWORD_DEFAULT)
    ];

    if (LoginCliente::cadastrar($dados)) {
        echo "<script>alert('Login cadastrado com sucesso!'); window.location.href = '../views/usuario/listar_clientes.php';</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar login.'); window.history.back();</script>";
    }
} else {
    header("Location: ../views/painel/funcionario.php");
    exit;
}
