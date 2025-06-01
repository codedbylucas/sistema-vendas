<?php
session_start();

require_once '../models/Usuario.php'; 

$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$senha = $_POST['senha'];

if (!$email || empty($senha)) {
    echo "<script>alert('Preencha todos os campos corretamente.'); window.location.href = '../views/login/index.php';</script>";
    exit;
}

$usuario = Usuario::buscarPorEmail($email);

if ($usuario && password_verify($senha, $usuario['senha'])) {

    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['nome'] = $usuario['nome'];
    $_SESSION['tipo'] = $usuario['tipo'];

    header('Location: ../views/painel/' . $usuario['tipo'] . '.php');
    exit;

} else {
    echo "<script>
        alert('E-mail ou senha inválidos.');
        window.location.href = '../views/login/index.php';
    </script>";
}
