<?php
session_start();
require_once '../../models/Cliente.php';

if (!isset($_SESSION['usuario_id']) || !in_array($_SESSION['tipo'], ['admin', 'funcionario'])) {
    header("Location: ../login/index.php");
    exit;
}

$cliente = [
    'id' => '',
    'nome' => '',
    'cpf' => '',
    'idade' => '',
    'cidade' => '',
    'endereco' => '',
    'data_nascimento' => '',
    'estado_civil' => '',
    'sexo' => ''
];

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $cliente = Cliente::buscarPorId($_GET['id']);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title><?= $cliente['id'] ? 'Editar Cliente' : 'Cadastrar Cliente' ?></title>
    <link rel="stylesheet" href="../../assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
</head>
<body class="layout">
    <aside class="sidebar">
        <h2 class="logo">Clientes</h2>
        <nav>
            <ul>
                <li><a href="listar.php"><i class="fas fa-arrow-left" aria-hidden="true"></i> Voltar</a></li>
            </ul>
        </nav>
    </aside>

    <main class="main">
        <h1><i class="fas fa-user-edit" aria-hidden="true"></i> <?= $cliente['id'] ? 'Editar Cliente' : 'Cadastrar Cliente' ?></h1>

        <div class="form-container">
            <form action="../../controllers/ClienteController.php" method="POST">
                <input type="hidden" name="id" value="<?= htmlspecialchars($cliente['id']) ?>">

                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" id="nome" required value="<?= htmlspecialchars($cliente['nome']) ?>">
                </div>

                <div class="form-group">
                    <label for="cpf">CPF:</label>
                    <input type="text" name="cpf" id="cpf" value="<?= htmlspecialchars($cliente['cpf']) ?>">
                </div>

                <div class="form-group">
                    <label for="idade">Idade:</label>
                    <input type="number" name="idade" id="idade" value="<?= htmlspecialchars($cliente['idade']) ?>">
                </div>

                <div class="form-group">
                    <label for="cidade">Cidade:</label>
                    <input type="text" name="cidade" id="cidade" value="<?= htmlspecialchars($cliente['cidade']) ?>">
                </div>

                <div class="form-group">
                    <label for="endereco">Endereço:</label>
                    <input type="text" name="endereco" id="endereco" value="<?= htmlspecialchars($cliente['endereco']) ?>">
                </div>

                <div class="form-group">
                    <label for="data_nascimento">Data de Nascimento:</label>
                    <input type="date" name="data_nascimento" id="data_nascimento" value="<?= htmlspecialchars($cliente['data_nascimento']) ?>">
                </div>

                <div class="form-group">
                    <label for="estado_civil">Estado Civil:</label>
                    <select name="estado_civil" id="estado_civil">
                        <option value="">Selecione</option>
                        <option value="solteiro" <?= $cliente['estado_civil'] === 'solteiro' ? 'selected' : '' ?>>Solteiro</option>
                        <option value="casado" <?= $cliente['estado_civil'] === 'casado' ? 'selected' : '' ?>>Casado</option>
                        <option value="divorciado" <?= $cliente['estado_civil'] === 'divorciado' ? 'selected' : '' ?>>Divorciado</option>
                        <option value="viúvo" <?= $cliente['estado_civil'] === 'viúvo' ? 'selected' : '' ?>>Viúvo</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="sexo">Sexo:</label>
                    <select name="sexo" id="sexo">
                        <option value="">Selecione</option>
                        <option value="masculino" <?= $cliente['sexo'] === 'masculino' ? 'selected' : '' ?>>Masculino</option>
                        <option value="feminino" <?= $cliente['sexo'] === 'feminino' ? 'selected' : '' ?>>Feminino</option>
                        <option value="outro" <?= $cliente['sexo'] === 'outro' ? 'selected' : '' ?>>Outro</option>
                    </select>
                </div>

                <button type="submit" class="btn"><i class="fas fa-save"></i> Salvar</button>
            </form>
        </div>
    </main>
</body>
</html>
