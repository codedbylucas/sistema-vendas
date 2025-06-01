<?php
require_once __DIR__ . '/../config/db.php';

class Cliente
{
    public static function listarTodos()
    {
        $pdo = Conexao::conectar();
        $stmt = $pdo->prepare("SELECT * FROM clientes ORDER BY nome");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function buscarPorId($id)
    {
        $pdo = Conexao::conectar();
        $sql = "SELECT * FROM clientes WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function salvar($dados)
    {
        $pdo = Conexao::conectar();
        if (!empty($dados['id'])) {
            $sql = "UPDATE clientes SET nome = :nome, cpf = :cpf, idade = :idade, cidade = :cidade,
                endereco = :endereco, data_nascimento = :data_nascimento, estado_civil = :estado_civil, sexo = :sexo
                WHERE id = :id";
        } else {
            $sql = "INSERT INTO clientes (nome, cpf, idade, cidade, endereco, data_nascimento, estado_civil, sexo)
                VALUES (:nome, :cpf, :idade, :cidade, :endereco, :data_nascimento, :estado_civil, :sexo)";
        }

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':nome', $dados['nome']);
        $stmt->bindParam(':cpf', $dados['cpf']);
        $stmt->bindParam(':idade', $dados['idade']);
        $stmt->bindParam(':cidade', $dados['cidade']);
        $stmt->bindParam(':endereco', $dados['endereco']);
        $stmt->bindParam(':data_nascimento', $dados['data_nascimento']);
        $stmt->bindParam(':estado_civil', $dados['estado_civil']);
        $stmt->bindParam(':sexo', $dados['sexo']);

        if (!empty($dados['id'])) {
            $stmt->bindParam(':id', $dados['id']);
        }

        return $stmt->execute();
    }


    public static function excluir($id)
    {
        $pdo = Conexao::conectar();
        $sql = "DELETE FROM clientes WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
