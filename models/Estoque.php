<?php
require_once __DIR__ . '/../config/db.php';

class Estoque
{
    public static function listarTodosComProduto()
    {
        $pdo = Conexao::conectar();
        $sql = "SELECT 
                    e.id,
                    e.produto_id,
                    e.saldo AS saldo_estoque,
                    e.preco AS preco_estoque,
                    e.descricao AS descricao_estoque,
                    p.descricao AS nome_produto,
                    p.cor,
                    p.voltagem,
                    p.situacao
                FROM estoque e
                JOIN produtos p ON e.produto_id = p.id
                ORDER BY p.descricao";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function salvar($dados)
    {
        $pdo = Conexao::conectar();

        if (!empty($dados['id'])) {
            $sql = "UPDATE estoque SET produto_id = :produto_id, saldo = :saldo, preco = :preco, descricao = :descricao
                WHERE id = :id";
        } else {
            $sql = "INSERT INTO estoque (produto_id, saldo, preco, descricao)
                VALUES (:produto_id, :saldo, :preco, :descricao)";
        }

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':produto_id', $dados['produto_id'], PDO::PARAM_INT);
        $stmt->bindParam(':saldo', $dados['saldo'], PDO::PARAM_INT);
        $stmt->bindParam(':preco', $dados['preco']);
        $stmt->bindParam(':descricao', $dados['descricao']);

        if (!empty($dados['id'])) {
            $stmt->bindParam(':id', $dados['id'], PDO::PARAM_INT);
        }

        return $stmt->execute();
    }

    public static function excluir($id)
    {
        $pdo = Conexao::conectar();
        $sql = "DELETE FROM estoque WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public static function buscarPorId($id)
    {
        $pdo = Conexao::conectar();
        $sql = "SELECT * FROM estoque WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
