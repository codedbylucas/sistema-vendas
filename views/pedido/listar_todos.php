<?php
session_start();
require_once '../../models/Pedido.php';

if (!isset($_SESSION['usuario_id']) || !in_array($_SESSION['tipo'], ['admin', 'funcionario'])) {
    header("Location: ../login/index.php");
    exit;
}

$filtros = [
    'cliente_nome' => $_GET['cliente_nome'] ?? '',
    'data_inicio' => $_GET['data_inicio'] ?? '',
    'data_fim' => $_GET['data_fim'] ?? '',
    'pedido_id' => $_GET['pedido_id'] ?? ''
];

$pedidos = Pedido::listarTodosComFiltros($filtros);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Todos os Pedidos</title>
    <link rel="stylesheet" href="../../assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
</head>
<body class="layout">
    <aside class="sidebar">
        <h2 class="logo">Pedidos</h2>
        <nav>
            <ul>
                <li><a href="../painel/<?= htmlspecialchars($_SESSION['tipo']) ?>.php"><i class="fas fa-arrow-left" aria-hidden="true"></i> Voltar</a></li>
            </ul>
        </nav>
    </aside>

    <main class="main">
        <h1><i class="fas fa-file-alt" aria-hidden="true"></i> Pedidos do Sistema</h1>

        <form method="GET" class="filter-form">
            <div class="form-group">
                <label for="pedido_id">Nº do Pedido:</label>
                <input type="number" id="pedido_id" name="pedido_id" value="<?= htmlspecialchars($filtros['pedido_id']) ?>">
            </div>

            <div class="form-group">
                <label for="cliente_nome">Cliente:</label>
                <input type="text" id="cliente_nome" name="cliente_nome" value="<?= htmlspecialchars($filtros['cliente_nome']) ?>">
            </div>

            <div class="form-group">
                <label for="data_inicio">Data Início:</label>
                <input type="date" id="data_inicio" name="data_inicio" value="<?= htmlspecialchars($filtros['data_inicio']) ?>">
            </div>

            <div class="form-group">
                <label for="data_fim">Data Fim:</label>
                <input type="date" id="data_fim" name="data_fim" value="<?= htmlspecialchars($filtros['data_fim']) ?>">
            </div>

            <button type="submit" class="btn"><i class="fas fa-search" aria-hidden="true"></i> Filtrar</button>
        </form>

        <?php if (empty($pedidos)): ?>
            <p>Nenhum pedido encontrado.</p>
        <?php else: ?>
            <?php foreach ($pedidos as $pedido): ?>
                <div class="pedido-card">
                    <p><strong>Pedido nº:</strong> <?= $pedido['id'] ?></p>
                    <p><strong>Cliente:</strong> <?= htmlspecialchars($pedido['cliente_nome']) ?></p>
                    <p><strong>Data do pedido:</strong> <?= date('d/m/Y H:i', strtotime($pedido['data_inclusao'])) ?></p>
                    <p><strong>Data da entrega:</strong> <?= date('d/m/Y', strtotime($pedido['data_entrega'])) ?></p>
                    <p><strong>Total:</strong> R$ <?= number_format($pedido['total'], 2, ',', '.') ?></p>

                    <table class="styled-table mini">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th>Quantidade</th>
                                <th>Preço Unitário</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $itens = Pedido::listarItensDoPedido($pedido['id']); ?>
                            <?php foreach ($itens as $item): ?>
                                <tr>
                                    <td><?= htmlspecialchars($item['nome_produto']) ?></td>
                                    <td><?= intval($item['quantidade']) ?></td>
                                    <td>R$ <?= number_format($item['preco_unitario'], 2, ',', '.') ?></td>
                                    <td>R$ <?= number_format($item['subtotal'], 2, ',', '.') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </main>
</body>
</html>
