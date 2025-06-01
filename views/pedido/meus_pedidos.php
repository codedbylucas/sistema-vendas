<?php
session_start();
require_once '../../models/Pedido.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo'] !== 'cliente') {
    header("Location: ../login/index.php");
    exit;
}

$cliente_id = $_SESSION['usuario_id'];
$pedidos = Pedido::listarPedidosPorCliente($cliente_id);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Meus Pedidos</title>
    <link rel="stylesheet" href="../../assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
</head>

<body class="layout">
    <aside class="sidebar">
        <h2 class="logo">Pedidos</h2>
        <nav>
            <ul>
                <li><a href="../painel/cliente.php"><i class="fas fa-arrow-left"></i> Voltar</a></li>
            </ul>
        </nav>
    </aside>

    <main class="main">
        <h1><i class="fas fa-shopping-bag"></i> Meus Pedidos</h1>
        <p>Bem-vindo, <?= $_SESSION['nome'] ?></p>

        <?php if (empty($pedidos)): ?>
            <p>Você ainda não realizou nenhum pedido.</p>
        <?php else: ?>
            <?php foreach ($pedidos as $pedido): ?>
                <div class="pedido-card">
                    <p><strong>Pedido nº:</strong> <?= $pedido['id'] ?></p>
                    <p><strong>Data do pedido:</strong> <?= date('d/m/Y H:i', strtotime($pedido['data_inclusao'])) ?></p>
                    <p><strong>Data da entrega:</strong> <?= date('d/m/Y', strtotime($pedido['data_entrega'])) ?></p>
                    <p><strong>Total:</strong> R$ <?= number_format($pedido['total'], 2, ',', '.') ?></p>
                    <p><strong>Status:</strong>
                        <span style="color:<?= $pedido['status'] === 'cancelado' ? 'red' : ($pedido['status'] === 'confirmado' ? 'green' : '#333') ?>">
                            <?= ucfirst($pedido['status']) ?>
                        </span>
                    </p>

                    <table class="styled-table mini">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th>Qtd</th>
                                <th>Unitário</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $itens = Pedido::listarItensDoPedido($pedido['id']); ?>
                            <?php foreach ($itens as $item): ?>
                                <tr>
                                    <td><?= $item['nome_produto'] ?></td>
                                    <td><?= $item['quantidade'] ?></td>
                                    <td>R$ <?= number_format($item['preco_unitario'], 2, ',', '.') ?></td>
                                    <td>R$ <?= number_format($item['subtotal'], 2, ',', '.') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <?php if ($pedido['status'] !== 'cancelado'): ?>
                        <form action="../../controllers/PedidoController.php" method="GET" class="form-inline">
                            <input type="hidden" name="acao" value="cancelar">
                            <input type="hidden" name="id" value="<?= $pedido['id'] ?>">
                            <button type="submit" class="btn danger" onclick="return confirm('Deseja cancelar este pedido?')">
                                <i class="fas fa-ban"></i> Cancelar Pedido
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </main>
</body>
</html>
