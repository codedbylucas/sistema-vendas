<?php
session_start();
require_once '../../models/Cliente.php';
require_once '../../models/LoginCliente.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo'] !== 'funcionario') {
    header("Location: ../login/index.php");
    exit;
}

$clientes = Cliente::listarTodos();
$edicao = false;

$dados = [
    'id' => '',
    'cliente_id' => '',
    'email' => '',
    'senha' => ''
];

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $edicao = true;
    $dados = LoginCliente::buscarPorId($_GET['id']);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title><?= $edicao ? 'Editar Login de Cliente' : 'Cadastrar Login para Cliente' ?></title>
    <link rel="stylesheet" href="../../assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="layout">
    <aside class="sidebar">
        <h2 class="logo">Usuários</h2>
        <nav>
            <ul>
                <li><a href="listar_clientes.php"><i class="fas fa-arrow-left"></i> Voltar</a></li>
            </ul>
        </nav>
    </aside>

    <main class="main">
        <h1>
            <i class="fas <?= $edicao ? 'fa-user-edit' : 'fa-user-plus' ?>"></i>
            <?= $edicao ? 'Editar Login de Cliente' : 'Cadastrar Login para Cliente' ?>
        </h1>

        <form action="../../controllers/LoginClienteController.php" method="POST" class="styled-form">
            <input type="hidden" name="acao" value="<?= $edicao ? 'editar' : 'cadastrar_cliente' ?>">
            <input type="hidden" name="id" value="<?= $dados['id'] ?>">

            <label for="cliente_id">Cliente:</label>
            <select name="cliente_id" id="cliente_id" required>
                <option value="">Selecione um cliente</option>
                <?php foreach ($clientes as $cliente): ?>
                    <option value="<?= $cliente['id'] ?>" <?= $cliente['id'] == $dados['cliente_id'] ? 'selected' : '' ?>>
                        <?= $cliente['nome'] ?> (<?= $cliente['cpf'] ?>)
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="email">E-mail:</label>
            <input type="email" name="email" id="email" required value="<?= htmlspecialchars($dados['email']) ?>">

            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" <?= $edicao ? '' : 'required' ?> placeholder="<?= $edicao ? 'Deixe em branco para manter a atual' : '' ?>">

            <button type="submit" class="btn">
                <i class="fas fa-save"></i> <?= $edicao ? 'Salvar Alterações' : 'Cadastrar' ?>
            </button>
        </form>
    </main>
</body>
</html>
