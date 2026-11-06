<?php
namespace App\Database;

use PDO;
use PDOException;

class Connection {
    private static $instance = null;
    public static function getInstance() {
        if (self::$instance === null) {
            $host = getenv('DB_HOST') ?: '127.0.0.1';
            $port = getenv('DB_PORT') ?: '3306';
            $db   = getenv('DB_DATABASE') ?: 'perpustakaan';
            $user = getenv('DB_USERNAME') ?: 'root';
            $pass = getenv('DB_PASSWORD') ?: '';
            $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";
            try {
                self::$instance = new PDO($dsn, $user, $pass, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]);
            } catch (PDOException $e) {
                die("Koneksi gagal: " . $e->getMessage());
            }
        }
        return self::$instance;
    }
}