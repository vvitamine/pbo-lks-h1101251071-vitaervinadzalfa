<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\Config\Env;
use App\Database\Connection;
use App\Repositories\MySQLBookRepository;

Env::load(__DIR__ . '/.env');
$pdo = Connection::getInstance();
$repo = new MySQLBookRepository($pdo);
$books = $repo->all();

echo "Total buku: " . count($books) . "\n";
foreach ($books as $book) {
    echo "- " . $book->getJudul() . " oleh " . $book->getPenulis() . "\n";
}