<?php
namespace App\Core;

class Request {
    public static function capture(): array {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $body = json_decode(file_get_contents('php://input'), true) ?? [];
        return ['method' => $method, 'uri' => $uri, 'body' => $body];
    }
}