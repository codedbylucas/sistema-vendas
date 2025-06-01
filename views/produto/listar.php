<?php
session_start();
require_once '../../models/Produto.php';

if (!isset($_SESSION['usuario_id']) || !in_array($_SESSION['tipo'], ['admin', 'funcionario'])) {
    header("Location: ../login/index.php");
    exit;
}

$produtos = Produto::listarTodos();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Lista de Produtos</title>
    <link rel="stylesheet" href="../../assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
</head>

<body class="layout">
    <aside class="sidebar">
        <h2 class="logo">Produtos</h2>
        <nav>
            <ul>
                <li><a href="../painel/funcionario.php"><i class="fas fa-arrow-left"></i> Voltar</a></li>
            </ul>
        </nav>
    </aside>

    <main class="main">
        <h1><i class="fas fa-box"></i> Produtos</h1>

        <div class="actions" style="margin-bottom: 20px;">
            <a href="form.php" class="btn"><i class="fas fa-plus"></i> Novo Produto</a>
        </div>


        <div class="table-wrapper">
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Descrição</th>
                        <th>Cor</th>
                        <th>Voltagem</th>
                        <th>Situação</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($produtos as $produto): ?>
                        <tr>
                            <td><?= $produto['id'] ?></td>
                            <td><?= $produto['descricao'] ?></td>
                            <td><?= $produto['cor'] ?></td>
                            <td><?= $produto['voltagem'] ?></td>
                            <td><?= ucfirst($produto['situacao']) ?></td>
                            <td>
                                <a href="form.php?id=<?= $produto['id'] ?>" class="action edit"><i class="fas fa-edit"></i></a>
                                <a href="../../controllers/ProdutoController.php?acao=excluir&id=<?= $produto['id'] ?>" class="action delete" onclick="return confirm('Deseja excluir este produto?')"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>