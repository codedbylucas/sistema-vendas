<?php
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo'] !== 'admin') {
    header("Location: ../login/index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Painel do Admin</title>
    <link rel="stylesheet" href="../../assets/css/dashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="layout">

    <aside class="sidebar">
        <h2 class="logo">Admin</h2>
        <nav>
            <ul>
                <li><a href="../cliente/listar.php"><i class="fas fa-users" aria-hidden="true"></i> Clientes</a></li>
                <li><a href="../usuario/listar.php"><i class="fas fa-user-cog" aria-hidden="true"></i> Funcionários</a></li>
                <li><a href="../produto/listar.php"><i class="fas fa-box-open" aria-hidden="true"></i> Produtos</a></li>
                <li><a href="../estoque/listar.php"><i class="fas fa-warehouse" aria-hidden="true"></i> Estoque</a></li>
                <li><a href="../pedido/listar_todos.php"><i class="fas fa-file-invoice" aria-hidden="true"></i> Pedidos </a></li>
                <li><a href="../../controllers/LogoutController.php" class="logout"><i class="fas fa-sign-out-alt" aria-hidden="true"></i> Sair</a></li>
            </ul>
        </nav>
    </aside>

    <main class="main">
        <h1>Bem-vindo, <?= htmlspecialchars($_SESSION['nome']) ?></h1>
        <p>Painel de Administração</p>

        <div class="card-grid">
            <a href="../cliente/listar.php" class="card">
                <i class="fas fa-users fa-2x" aria-hidden="true"></i><br><span>Clientes</span>
            </a>
            <a href="../usuario/listar.php" class="card">
                <i class="fas fa-user-cog fa-2x" aria-hidden="true"></i><br><span>Funcionários</span>
            </a>
            <a href="../produto/listar.php" class="card">
                <i class="fas fa-box-open fa-2x" aria-hidden="true"></i><br><span>Produtos</span>
            </a>
            <a href="../estoque/listar.php" class="card">
                <i class="fas fa-warehouse fa-2x" aria-hidden="true"></i><br><span>Estoque</span>
            </a>
            <a href="../pedido/listar_todos.php" class="card">
                <i class="fas fa-file-invoice fa-2x" aria-hidden="true"></i><br><span>Pedidos</span>
            </a>
        </div>
    </main>
</body>
</html>
