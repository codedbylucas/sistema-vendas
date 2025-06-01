<?php
session_start();
require_once '../../models/Estoque.php';

if (!isset($_SESSION['usuario_id']) || !in_array($_SESSION['tipo'], ['admin', 'funcionario'])) {
    header("Location: ../login/index.php");
    exit;
}

$estoques = Estoque::listarTodosComProduto();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lista de Estoque</title>
    <link rel="stylesheet" href="../../assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
</head>

<body class="layout">
    <aside class="sidebar">
        <h2 class="logo">Estoque</h2>
        <nav>
            <ul>
                <li><a href="../painel/<?= $_SESSION['tipo'] ?>.php"><i class="fas fa-arrow-left" aria-hidden="true"></i> Voltar</a></li>
                <li><a href="form.php"><i class="fas fa-plus" aria-hidden="true"></i> Novo Estoque</a></li>
            </ul>
        </nav>
    </aside>

    <main class="main">
        <h1><i class="fas fa-warehouse" aria-hidden="true"></i> Estoque de Produtos</h1>
        <p>Bem-vindo, <?= htmlspecialchars($_SESSION['nome']) ?>!</p>

        <div class="table-wrapper">
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Cor</th>
                        <th>Voltagem</th>
                        <th>Situação</th>
                        <th>Saldo</th>
                        <th>Preço (R$)</th>
                        <th>Descrição</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($estoques)): ?>
                        <tr>
                            <td colspan="8">Nenhum estoque cadastrado ainda.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($estoques as $estoque): ?>
                            <tr>
                                <td><?= htmlspecialchars($estoque['nome_produto']) ?></td>
                                <td><?= htmlspecialchars($estoque['cor']) ?></td>
                                <td><?= htmlspecialchars($estoque['voltagem']) ?></td>
                                <td><?= htmlspecialchars($estoque['situacao']) ?></td>
                                <td><?= (int)$estoque['saldo_estoque'] ?></td>
                                <td>R$ <?= number_format($estoque['preco_estoque'], 2, ',', '.') ?></td>
                                <td><?= htmlspecialchars($estoque['descricao_estoque']) ?></td>
                                <td>
                                    <a class="action edit" href="form.php?id=<?= $estoque['id'] ?>" title="Editar">
                                        <i class="fas fa-edit" aria-hidden="true"></i>
                                    </a>
                                    <a class="action delete" href="../../controllers/EstoqueController.php?acao=excluir&id=<?= $estoque['id'] ?>" onclick="return confirm('Deseja excluir este registro de estoque?')" title="Excluir">
                                        <i class="fas fa-trash-alt" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
