<?php
require_once __DIR__ . '/../config/db.php';

class LoginCliente
{
    public static function cadastrar($dados)
    {
        $pdo = Conexao::conectar();
        $senhaHash = password_hash($dados['senha'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios (cliente_id, nome, email, senha, tipo, criado_em) 
                VALUES (:cliente_id, :nome, :email, :senha, 'cliente', NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':cliente_id', $dados['cliente_id'], PDO::PARAM_INT);
        $stmt->bindParam(':nome', $dados['nome'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $dados['email'], PDO::PARAM_STR);
        $stmt->bindParam(':senha', $senhaHash, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public static function listarTodos()
    {
        $pdo = Conexao::conectar();
        $sql = "SELECT u.id, u.nome, u.email, u.tipo, u.criado_em, c.nome AS nome_cliente
                FROM usuarios u
                LEFT JOIN clientes c ON u.cliente_id = c.id
                WHERE u.tipo = 'cliente'
                ORDER BY u.id DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function excluir($id)
    {
        $pdo = Conexao::conectar();
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public static function buscarPorId($id)
    {
        $pdo = Conexao::conectar();
        $sql = "SELECT * FROM usuarios WHERE id = :id AND tipo = 'cliente'";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function atualizarComSenha($id, $cliente_id, $nome, $email, $senhaHash)
    {
        $pdo = Conexao::conectar();
        $sql = "UPDATE usuarios 
                SET cliente_id = :cliente_id, nome = :nome, email = :email, senha = :senha 
                WHERE id = :id AND tipo = 'cliente'";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':cliente_id', $cliente_id, PDO::PARAM_INT);
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':senha', $senhaHash, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public static function atualizarSemSenha($id, $cliente_id, $nome, $email)
    {
        $pdo = Conexao::conectar();
        $sql = "UPDATE usuarios 
                SET cliente_id = :cliente_id, nome = :nome, email = :email 
                WHERE id = :id AND tipo = 'cliente'";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':cliente_id', $cliente_id, PDO::PARAM_INT);
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}
