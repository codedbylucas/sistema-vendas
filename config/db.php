<?php
class Conexao {
    public static function conectar() {
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=sistema_vendas;charset=utf8", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("Erro na conexão: " . $e->getMessage());
        }
    }
}