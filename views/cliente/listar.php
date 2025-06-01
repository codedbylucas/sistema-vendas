<?php
session_start();
require_once '../../models/Cliente.php';

if (!isset($_SESSION['usuario_id']) || !in_array($_SESSION['tipo'], ['admin', 'funcionario'])) {
    header("Location: ../login/index.php");
    exit;
}

$clientes = Cliente::listarTodos();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Clientes</title>
    <link rel="stylesheet" href="../../assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
</head>

<body class="layout">
    <aside class="sidebar">
        <h2 class="logo">Clientes</h2>
        <nav>
            <ul>
                <li><a href="../painel/funcionario.php"><i class="fas fa-arrow-left" aria-hidden="true"></i> Voltar</a></li>
            </ul>
        </nav>
    </aside>

    <main class="main">
        <h1><i class="fas fa-users" aria-hidden="true"></i> Lista de Clientes</h1>
        <a href="form.php" class="btn"><i class="fas fa-user-plus" aria-hidden="true"></i> Novo Cliente</a>

        <div class="table-wrapper">
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>Idade</th>
                        <th>Cidade</th>
                        <th>Endereço</th>
                        <th>Data Nasc.</th>
                        <th>Estado Civil</th>
                        <th>Sexo</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($clientes)): ?>
                        <?php foreach ($clientes as $cliente): ?>
                            <tr>
                                <td><?= htmlspecialchars($cliente['id']) ?></td>
                                <td><?= htmlspecialchars($cliente['nome']) ?></td>
                                <td><?= htmlspecialchars($cliente['cpf']) ?></td>
                                <td><?= htmlspecialchars($cliente['idade']) ?></td>
                                <td><?= htmlspecialchars($cliente['cidade']) ?></td>
                                <td><?= htmlspecialchars($cliente['endereco']) ?></td>
                                <td><?= htmlspecialchars(date('d/m/Y', strtotime($cliente['data_nascimento']))) ?></td>
                                <td><?= htmlspecialchars(ucfirst($cliente['estado_civil'])) ?></td>
                                <td><?= htmlspecialchars(ucfirst($cliente['sexo'])) ?></td>
                                <td>
                                    <a href="form.php?id=<?= $cliente['id'] ?>" class="action edit" title="Editar">
                                        <i class="fas fa-edit" aria-hidden="true"></i>
                                    </a>
                                    <a href="../../controllers/ClienteController.php?acao=excluir&id=<?= $cliente['id'] ?>" class="action delete" title="Excluir" onclick="return confirm('Deseja excluir este cliente?')">
                                        <i class="fas fa-trash-alt" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10">Nenhum cliente cadastrado ainda.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>