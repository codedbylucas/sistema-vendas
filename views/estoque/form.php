<?php
session_start();
require_once '../../models/Estoque.php';
require_once '../../models/Produto.php';
require_once '../../config/db.php'; // Conexão necessária

if (!isset($_SESSION['usuario_id']) || !in_array($_SESSION['tipo'], ['admin', 'funcionario'])) {
    header("Location: ../login/index.php");
    exit;
}

$estoque = [
    'id' => '',
    'produto_id' => '',
    'saldo' => '',
    'preco' => '',
    'descricao' => ''
];

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $pdo = Conexao::conectar();
    $sql = "SELECT * FROM estoque WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $stmt->execute();
    $estoque = $stmt->fetch(PDO::FETCH_ASSOC) ?: $estoque;
}

$produtos = Produto::listarTodos();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title><?= $estoque['id'] ? 'Editar Estoque' : 'Novo Estoque' ?></title>
    <link rel="stylesheet" href="../../assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
</head>

<body class="layout">
    <aside class="sidebar">
        <h2 class="logo">Estoque</h2>
        <nav>
            <ul>
                <li><a href="listar.php"><i class="fas fa-arrow-left" aria-hidden="true"></i> Voltar</a></li>
            </ul>
        </nav>
    </aside>

    <main class="main">
        <h1><i class="fas fa-boxes-stacked" aria-hidden="true"></i> <?= $estoque['id'] ? 'Editar Estoque' : 'Novo Estoque' ?></h1>

        <form method="POST" action="../../controllers/EstoqueController.php" class="styled-form">
            <input type="hidden" name="id" value="<?= htmlspecialchars($estoque['id']) ?>">

            <label for="produto_id">Produto:</label>
            <select name="produto_id" id="produto_id" required>
                <option value="">-- Selecione --</option>
                <?php foreach ($produtos as $produto): ?>
                    <option value="<?= $produto['id'] ?>" <?= $produto['id'] == $estoque['produto_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($produto['descricao']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="saldo">Saldo (Quantidade):</label>
            <input type="number" id="saldo" name="saldo" value="<?= htmlspecialchars($estoque['saldo']) ?>" required>

            <label for="preco">Preço por unidade (R$):</label>
            <input type="number" id="preco" name="preco" step="0.01" value="<?= htmlspecialchars($estoque['preco']) ?>" required>

            <label for="descricao">Descrição do estoque:</label>
            <textarea name="descricao" id="descricao"><?= htmlspecialchars($estoque['descricao']) ?></textarea>

            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn"><i class="fas fa-save" aria-hidden="true"></i> Salvar</button>
                <a href="listar.php" class="btn secondary"><i class="fas fa-times" aria-hidden="true"></i> Cancelar</a>
            </div>
        </form>
    </main>
</body>

</html>