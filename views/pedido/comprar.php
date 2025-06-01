<?php
session_start();
require_once '../../models/Pedido.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo'] !== 'cliente') {
    header("Location: ../login/index.php");
    exit;
}

$produtos = Pedido::listarProdutosDisponiveis();
$cliente_id = $_SESSION['usuario_id'];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Comprar Produtos</title>
    <link rel="stylesheet" href="../../assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
</head>
<body class="layout">
    <aside class="sidebar">
        <h2 class="logo">Comprar</h2>
        <nav>
            <ul>
                <li><a href="../painel/cliente.php"><i class="fas fa-arrow-left"></i> Voltar</a></li>
                <li><a href="meus_pedidos.php"><i class="fas fa-list"></i> Meus Pedidos</a></li>
            </ul>
        </nav>
    </aside>

    <main class="main">
        <h1><i class="fas fa-cart-plus"></i> Comprar Produtos</h1>

        <?php if (empty($produtos)): ?>
            <p>Nenhum produto disponível no momento.</p>
        <?php else: ?>
            <div class="card-grid">
                <?php foreach ($produtos as $p): ?>
                    <div class="card">
                        <h3><?= htmlspecialchars($p['descricao']) ?></h3>
                        <p><strong>Preço:</strong> R$ <?= number_format($p['preco'], 2, ',', '.') ?></p>
                        <p><strong>Saldo:</strong> <?= intval($p['saldo']) ?></p>

                        <?php if ($p['saldo'] <= 0): ?>
                            <p style="color: red;"><strong>Indisponível</strong></p>
                        <?php else: ?>
                            <form action="../../controllers/PedidoController.php" method="POST" class="form-inline">
                                <input type="hidden" name="cliente_id" value="<?= $cliente_id ?>">
                                <input type="hidden" name="produto_id" value="<?= intval($p['id']) ?>">
                                <input type="hidden" name="estoque_id" value="<?= intval($p['estoque_id']) ?>">

                                <div class="form-group-inline">
                                    <label for="quantidade_<?= $p['id'] ?>">Qtd:</label>
                                    <input type="number" id="quantidade_<?= $p['id'] ?>" name="quantidade" min="1" max="<?= $p['saldo'] ?>" required style="width: 60px;">
                                </div>

                                <div class="form-group-inline">
                                    <label for="data_entrega_<?= $p['id'] ?>">Entrega:</label>
                                    <input type="date" id="data_entrega_<?= $p['id'] ?>" name="data_entrega" required>
                                </div>

                                <button type="submit" class="btn"><i class="fas fa-plus"></i> Adicionar</button>
                            </form>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>
