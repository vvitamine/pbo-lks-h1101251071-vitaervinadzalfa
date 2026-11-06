<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\Config\Env;
use App\Database\Connection;

Env::load(__DIR__ . '/.env');
$pdo = Connection::getInstance();
echo "✅ Koneksi database berhasil! Versi MySQL: " . $pdo->getAttribute(PDO::ATTR_SERVER_VERSION);