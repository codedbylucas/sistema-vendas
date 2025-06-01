<?php
session_start();
require_once '../config/db.php';
require_once '../models/Pedido.php';

if (isset($_GET['acao']) && $_GET['acao'] === 'cancelar' && isset($_GET['id'])) {
    $pedido_id = $_GET['id'];

    if (Pedido::cancelarPedido($pedido_id)) {
        echo "<script>alert('Pedido cancelado com sucesso!'); window.location.href = '../views/pedido/meus_pedidos.php';</script>";
    } else {
        echo "<script>alert('Erro ao cancelar pedido.'); window.history.back();</script>";
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = Conexao::conectar();

    $cliente_id = $_POST['cliente_id'] ?? $_SESSION['usuario_id'];
    $data_entrega = $_POST['data_entrega'] ?? '';
    $itens = [];
    $total = 0;

    try {
        if (isset($_POST['produto_id']) && isset($_POST['quantidade'])) {
            $produto_id = intval($_POST['produto_id']);
            $quantidade = intval($_POST['quantidade']);

            $sql = "SELECT e.id AS estoque_id, e.saldo, e.preco FROM estoque e WHERE e.produto_id = :produto_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
            $stmt->execute();
            $estoque = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$estoque || $estoque['saldo'] < $quantidade) {
                throw new Exception("Estoque insuficiente para o produto selecionado.");
            }

            $subtotal = $estoque['preco'] * $quantidade;
            $total += $subtotal;

            $itens[] = [
                'produto_id' => $produto_id,
                'quantidade' => $quantidade,
                'preco_unitario' => $estoque['preco'],
                'subtotal' => $subtotal,
                'estoque_id' => $estoque['estoque_id']
            ];
        }

        elseif (!empty($_POST['selecionados']) && is_array($_POST['selecionados'])) {
            $selecionados = $_POST['selecionados'];
            $quantidades = $_POST['quantidade'] ?? [];

            foreach ($selecionados as $produto_id) {
                $quantidade = intval($quantidades[$produto_id]);

                $sql = "SELECT e.id AS estoque_id, e.saldo, e.preco FROM estoque e WHERE e.produto_id = :produto_id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
                $stmt->execute();
                $estoque = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$estoque || $estoque['saldo'] < $quantidade) {
                    throw new Exception("Estoque insuficiente para o produto ID $produto_id");
                }

                $subtotal = $estoque['preco'] * $quantidade;
                $total += $subtotal;

                $itens[] = [
                    'produto_id' => $produto_id,
                    'quantidade' => $quantidade,
                    'preco_unitario' => $estoque['preco'],
                    'subtotal' => $subtotal,
                    'estoque_id' => $estoque['estoque_id']
                ];
            }
        }

        else {
            throw new Exception("Nenhum produto selecionado.");
        }

        $pdo->beginTransaction();

        $sql = "INSERT INTO pedidos (cliente_id, data_entrega, total) VALUES (:cliente_id, :data_entrega, :total)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':cliente_id', $cliente_id);
        $stmt->bindParam(':data_entrega', $data_entrega);
        $stmt->bindParam(':total', $total);
        $stmt->execute();
        $pedido_id = $pdo->lastInsertId();

        foreach ($itens as $item) {
            $sql = "INSERT INTO itens_pedido (pedido_id, produto_id, quantidade, preco_unitario, subtotal)
                    VALUES (:pedido_id, :produto_id, :quantidade, :preco_unitario, :subtotal)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':pedido_id', $pedido_id);
            $stmt->bindParam(':produto_id', $item['produto_id']);
            $stmt->bindParam(':quantidade', $item['quantidade']);
            $stmt->bindParam(':preco_unitario', $item['preco_unitario']);
            $stmt->bindParam(':subtotal', $item['subtotal']);
            $stmt->execute();

            $sql = "UPDATE estoque SET saldo = saldo - :quantidade WHERE id = :estoque_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':quantidade', $item['quantidade'], PDO::PARAM_INT);
            $stmt->bindParam(':estoque_id', $item['estoque_id'], PDO::PARAM_INT);
            $stmt->execute();
        }

        $pdo->commit();

        echo "<script>alert('Pedido realizado com sucesso!'); window.location.href = '../views/pedido/comprar.php';</script>";
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "<script>alert('Erro ao processar pedido: " . $e->getMessage() . "'); window.history.back();</script>";
    }
}
