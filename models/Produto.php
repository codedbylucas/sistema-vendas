<?php
require_once __DIR__ . '/../config/db.php';

class Produto
{
    public static function listarTodos()
    {
        $pdo = Conexao::conectar();
        $sql = 'SELECT * FROM produtos ORDER BY descricao';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function buscarPorId($id)
    {
        $pdo = Conexao::conectar();
        $sql = 'SELECT * FROM produtos WHERE id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function salvar($dados)
    {
        $pdo = Conexao::conectar();

        if (!empty($dados['id'])) {
            $sql = "UPDATE produtos 
                SET descricao = :descricao, cor = :cor, voltagem = :voltagem, situacao = :situacao 
                WHERE id = :id";
        } else {
            $sql = "INSERT INTO produtos (descricao, cor, voltagem, situacao) 
                VALUES (:descricao, :cor, :voltagem, :situacao)";
        }

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':descricao', $dados['descricao']);
        $stmt->bindParam(':cor', $dados['cor']);
        $stmt->bindParam(':voltagem', $dados['voltagem']);
        $stmt->bindParam(':situacao', $dados['situacao']);

        if (!empty($dados['id'])) {
            $stmt->bindParam(':id', $dados['id'], PDO::PARAM_INT);
        }

        return $stmt->execute();
    }

    public static function excluir($id)
    {
        $pdo = Conexao::conectar();
        $sql = 'DELETE FROM produtos WHERE id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
