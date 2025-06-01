<?php
session_start();
require_once '../../models/LoginCliente.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo'] !== 'funcionario') {
    header("Location: ../login/index.php");
    exit;
}

$usuarios = LoginCliente::listarTodos();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Logins de Clientes</title>
    <link rel="stylesheet" href="../../assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="layout">
    <aside class="sidebar">
        <h2 class="logo">Clientes</h2>
        <nav>
            <ul>
                <li><a href="../painel/funcionario.php"><i class="fas fa-arrow-left"></i> Voltar</a></li>
            </ul>
        </nav>
    </aside>

    <main class="main">
        <h1><i class="fas fa-id-card-alt"></i> Logins de Clientes</h1>

        <div class="actions" style="margin-bottom: 20px;">
            <a href="cadastrar_cliente.php" class="btn"><i class="fas fa-plus"></i> Novo Login</a>
        </div>

        <div class="table-wrapper">
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>E-mail</th>
                        <th>Cliente</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?= $usuario['id'] ?></td>
                            <td><?= htmlspecialchars($usuario['email']) ?></td>
                            <td><?= htmlspecialchars($usuario['nome_cliente'] ?? '-') ?></td>
                            <td>
                                <a href="cadastrar_cliente.php?id=<?= $usuario['id'] ?>" class="action edit"><i class="fas fa-edit"></i></a>
                                <a href="../../controllers/LoginClienteController.php?acao=excluir&id=<?= $usuario['id'] ?>"
                                    class="action delete"
                                    onclick="return confirm('Tem certeza que deseja excluir este login?')">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>