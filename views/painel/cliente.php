<?php
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo'] !== 'cliente') {
    header("Location: ../login/index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Painel do Cliente</title>
    <link rel="stylesheet" href="../../assets/css/dashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="layout">
    <aside class="sidebar">
        <h2 class="logo">Cliente</h2>
        <nav>
            <ul>
                <li><a href="../pedido/comprar.php"><i class="fas fa-cart-plus" aria-hidden="true"></i> Comprar</a></li>
                <li><a href="../pedido/meus_pedidos.php"><i class="fas fa-receipt" aria-hidden="true"></i> Meus Pedidos</a></li>
                <li><a href="../../controllers/LogoutController.php" class="logout"><i class="fas fa-sign-out-alt" aria-hidden="true"></i> Sair</a></li>
            </ul>
        </nav>
    </aside>

    <main class="main">
        <h1>Olá, <?= htmlspecialchars($_SESSION['nome']) ?></h1>
        <p>Painel do Cliente</p>

        <div class="card-grid">
            <a href="../pedido/comprar.php" class="card">
                <i class="fas fa-cart-plus fa-2x" aria-hidden="true"></i><br><span>Fazer Compra</span>
            </a>
            <a href="../pedido/meus_pedidos.php" class="card">
                <i class="fas fa-receipt fa-2x" aria-hidden="true"></i><br><span>Meus Pedidos</span>
            </a>
        </div>
    </main>
</body>
</html>
