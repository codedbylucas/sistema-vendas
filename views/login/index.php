<?php
session_start();
if (isset($_SESSION['usuario_id'])) {
    header("Location: ../painel/" . $_SESSION['tipo'] . ".php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistema</title>
    <link rel="stylesheet" href="../../assets/css/dashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
</head>
<body class="login-layout">
    <div class="login-box">
        <h1 class="login-title">Bem-vindo</h1>
        <p class="login-subtitle">Acesse sua conta para continuar</p>

        <form action="../../controllers/LoginController.php" method="POST" class="login-form">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Digite seu e-mail" required>

            <label for="senha">Senha</label>
            <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>

            <button type="submit" class="btn">Entrar</button>
        </form>

        <p class="login-footer">Desenvolvido por Lucas Gabriel Silva</p>
    </div>
</body>
</html>
