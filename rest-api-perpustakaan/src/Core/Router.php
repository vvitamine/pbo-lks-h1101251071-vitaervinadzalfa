<?php
namespace App\Core;

class Router {
    private array $routes = [];

    public function add(string $method, string $path, callable $handler): void {
        $this->routes[] = compact('method', 'path', 'handler');
    }

    public function dispatch(Request $request): void {
        foreach ($this->routes as $route) {
            if ($route['method'] === $request->method && $route['path'] === $request->uri) {
                call_user_func($route['handler'], $request);
                return;
            }
        }
        Response::json(['success' => false, 'message' => 'Endpoint tidak ditemukan'], 404);
    }
}