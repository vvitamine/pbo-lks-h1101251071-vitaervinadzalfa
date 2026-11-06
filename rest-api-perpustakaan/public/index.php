<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Config\Env;
use App\Database\Connection;
use App\Core\Request;
use App\Core\Response;
use App\Core\Router;
use App\Core\Container;
use App\Repositories\MySQLBookRepository;
use App\Services\BookService;
use App\Controllers\BookController;

Env::load(__DIR__ . '/../.env');

$container = new Container();
$container->bind('pdo', fn() => Connection::getInstance());
$container->bind('bookRepo', fn() => new MySQLBookRepository($container->make('pdo')));
$container->bind('bookService', fn() => new BookService($container->make('bookRepo')));
$container->bind('bookController', fn() => new BookController($container->make('bookService')));

$request = new Request();
$request->method = $_SERVER['REQUEST_METHOD'];
$request->uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$request->body = json_decode(file_get_contents('php://input'), true) ?? [];

$router = new Router();

$router->add('GET', '/api/books', function($req) use ($container) {
    $container->make('bookController')->index($req);
});

$router->add('POST', '/api/books', function($req) use ($container) {
    $container->make('bookController')->store($req);
});

// Sekarang Router otomatis mengirim ID sebagai parameter kedua ($id)
$router->add('GET', '/api/books/{id}', function($req, $id) use ($container) {
    $container->make('bookController')->show($req, (int)$id);
});

$router->add('PUT', '/api/books/{id}', function($req, $id) use ($container) {
    $container->make('bookController')->update($req, (int)$id);
});

$router->add('DELETE', '/api/books/{id}', function($req, $id) use ($container) {
    $container->make('bookController')->destroy($req, (int)$id);
});

$router->dispatch($request);