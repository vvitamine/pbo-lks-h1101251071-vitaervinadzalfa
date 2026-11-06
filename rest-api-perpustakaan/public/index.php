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
use App\Repositories\MySQLCategoryRepository;
use App\Services\CategoryService;
use App\Controllers\CategoryController;

// 1. Load .env
Env::load(__DIR__ . '/../.env');

// 2. Setup Container (Dependency Injection)
$container = new Container();
$container->bind('pdo', fn() => Connection::getInstance());

// Binding Book
$container->bind('bookRepo', fn() => new MySQLBookRepository($container->make('pdo')));
$container->bind('bookService', fn() => new BookService($container->make('bookRepo')));
$container->bind('bookController', fn() => new BookController($container->make('bookService')));

// Binding Category
$container->bind('categoryRepo', fn() => new MySQLCategoryRepository($container->make('pdo')));
$container->bind('categoryService', fn() => new CategoryService($container->make('categoryRepo')));
$container->bind('categoryController', fn() => new CategoryController($container->make('categoryService')));

// 3. Setup Request
$request = new Request();
$request->method = $_SERVER['REQUEST_METHOD'];
$request->uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$request->body = json_decode(file_get_contents('php://input'), true) ?? [];

// 4. Setup Router
$router = new Router();

// 5. Daftarkan Route

// --- ROUTE BOOK ---
$router->add('GET', '/api/books', function($req) use ($container) {
    $container->make('bookController')->index($req);
});

$router->add('POST', '/api/books', function($req) use ($container) {
    $container->make('bookController')->store($req);
});

$router->add('GET', '/api/books/{id}', function($req, $id) use ($container) {
    $container->make('bookController')->show($req, (int)$id);
});

$router->add('PUT', '/api/books/{id}', function($req, $id) use ($container) {
    $container->make('bookController')->update($req, (int)$id);
});

$router->add('DELETE', '/api/books/{id}', function($req, $id) use ($container) {
    $container->make('bookController')->destroy($req, (int)$id);
});

// --- ROUTE CATEGORY ---
$router->add('GET', '/api/categories', function($req) use ($container) {
    $container->make('categoryController')->index($req);
});

$router->add('POST', '/api/categories', function($req) use ($container) {
    $container->make('categoryController')->store($req);
});

$router->add('GET', '/api/categories/{id}', function($req, $id) use ($container) {
    $container->make('categoryController')->show($req, (int)$id);
});

$router->add('PUT', '/api/categories/{id}', function($req, $id) use ($container) {
    $container->make('categoryController')->update($req, (int)$id);
});

$router->add('DELETE', '/api/categories/{id}', function($req, $id) use ($container) {
    $container->make('categoryController')->destroy($req, (int)$id);
});

// 6. Jalankan Router
$router->dispatch($request);