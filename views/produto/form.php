<?php
session_start();
require_once '../../models/Produto.php';

if (!isset($_SESSION['usuario_id']) || !in_array($_SESSION['tipo'], ['admin', 'funcionario'])) {
    header("Location: ../login/index.php");
    exit;
}

$produto = [
    'id' => '',
    'descricao' => '',
    'cor' => '',
    'voltagem' => '',
    'situacao' => 'ativo'
];

if (isset($_GET['id'])) {
    $produto = Produto::buscarPorId($_GET['id']);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title><?= $produto['id'] ? 'Editar Produto' : 'Novo Produto' ?></title>
    <link rel="stylesheet" href="../../assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
</head>
<body class="layout">
    <aside class="sidebar">
        <h2 class="logo">Produtos</h2>
        <nav>
            <ul>
                <li><a href="listar.php"><i class="fas fa-arrow-left"></i> Voltar</a></li>
            </ul>
        </nav>
    </aside>

    <main class="main">
        <h1><?= $produto['id'] ? 'Editar Produto' : 'Cadastrar Produto' ?></h1>

        <div class="form-container">
            <form action="../../controllers/ProdutoController.php" method="POST">
                <input type="hidden" name="id" value="<?= $produto['id'] ?>">

                <div class="form-group">
                    <label for="descricao">Descrição:</label>
                    <input type="text" name="descricao" id="descricao" required value="<?= $produto['descricao'] ?>">
                </div>

                <div class="form-group">
                    <label for="cor">Cor:</label>
                    <input type="text" name="cor" id="cor" value="<?= $produto['cor'] ?>">
                </div>

                <div class="form-group">
                    <label for="voltagem">Voltagem:</label>
                    <input type="text" name="voltagem" id="voltagem" value="<?= $produto['voltagem'] ?>">
                </div>

                <div class="form-group">
                    <label for="situacao">Situação:</label>
                    <select name="situacao" id="situacao">
                        <option value="ativo" <?= $produto['situacao'] === 'ativo' ? 'selected' : '' ?>>Ativo</option>
                        <option value="inativo" <?= $produto['situacao'] === 'inativo' ? 'selected' : '' ?>>Inativo</option>
                    </select>
                </div>

                <button type="submit" class="btn">Salvar</button>
            </form>
        </div>
    </main>
</body>
</html>
