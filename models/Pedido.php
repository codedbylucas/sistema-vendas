<?php
require_once __DIR__ . '/../config/db.php';

class Pedido
{
    public static function listarProdutosDisponiveis()
    {
        $pdo = Conexao::conectar();
        $sql = "SELECT 
                    p.id,
                    p.descricao,
                    e.saldo,
                    e.preco,
                    e.id AS estoque_id
                FROM produtos p
                JOIN estoque e ON p.id = e.produto_id
                WHERE p.situacao = 'ativo' AND e.saldo > 0
                ORDER BY p.descricao";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function listarItensDoPedido($pedido_id)
    {
        $pdo = Conexao::conectar();
        $sql = "SELECT 
                ip.quantidade,
                ip.preco_unitario,
                ip.subtotal,
                pr.descricao AS nome_produto
            FROM itens_pedido ip
            JOIN produtos pr ON pr.id = ip.produto_id
            WHERE ip.pedido_id = :pedido_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':pedido_id', $pedido_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function listarPedidosPorCliente($cliente_id)
    {
        $pdo = Conexao::conectar();
        $sql = "SELECT 
                p.id,
                p.data_inclusao,
                p.data_entrega,
                p.total,
                p.status
            FROM pedidos p
            WHERE p.cliente_id = :cliente_id
            ORDER BY p.data_inclusao DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':cliente_id', $cliente_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function listarTodosComFiltros($filtros = [])
    {
        $pdo = Conexao::conectar();

        $sql = "SELECT 
                p.id,
                p.cliente_id,
                u.nome AS cliente_nome,
                p.data_inclusao,
                p.data_entrega,
                p.total,
                p.status 
            FROM pedidos p
            JOIN usuarios u ON u.id = p.cliente_id
            WHERE 1=1";

        $params = [];

        if (!empty($filtros['cliente_nome'])) {
            $sql .= " AND u.nome LIKE :cliente_nome";
            $params[':cliente_nome'] = '%' . $filtros['cliente_nome'] . '%';
        }

        if (!empty($filtros['data_inicio']) && !empty($filtros['data_fim'])) {
            $sql .= " AND p.data_inclusao BETWEEN :data_inicio AND :data_fim";
            $params[':data_inicio'] = $filtros['data_inicio'] . ' 00:00:00';
            $params[':data_fim'] = $filtros['data_fim'] . ' 23:59:59';
        }

        if (!empty($filtros['pedido_id'])) {
            $sql .= " AND p.id = :pedido_id";
            $params[':pedido_id'] = $filtros['pedido_id'];
        }

        $sql .= " ORDER BY p.data_inclusao DESC";

        $stmt = $pdo->prepare($sql);
        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function cancelarPedido($pedido_id)
    {
        $pdo = Conexao::conectar();

        $sql = "SELECT produto_id, quantidade FROM itens_pedido WHERE pedido_id = :pedido_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':pedido_id', $pedido_id);
        $stmt->execute();
        $itens = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $pdo->beginTransaction();

        try {
            foreach ($itens as $item) {
                $sql = "UPDATE estoque SET saldo = saldo + :qtd WHERE produto_id = :produto_id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':qtd', $item['quantidade']);
                $stmt->bindParam(':produto_id', $item['produto_id']);
                $stmt->execute();
            }

            $sql = "UPDATE pedidos SET status = 'cancelado' WHERE id = :pedido_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':pedido_id', $pedido_id);
            $stmt->execute();

            $pdo->commit();
            return true;
        } catch (Exception $e) {
            $pdo->rollBack();
            return false;
        }
    }
}
