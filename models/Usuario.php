<?php 
require_once __DIR__ . '/../config/db.php';

class Usuario {
    public static function buscarPorEmail($email) {
        $pdo = Conexao::conectar();
        $sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}