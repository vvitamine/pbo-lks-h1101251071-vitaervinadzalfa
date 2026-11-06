<?php
namespace App\Core;

class Router {
    private array $routes = [];

    public function add(string $method, string $path, callable $handler): void {
        $this->routes[] = compact('method', 'path', 'handler');
    }

    public function dispatch(Request $request): void {
        foreach ($this->routes as $route) {
            if ($route['method'] !== $request->method) continue;

            // Ubah path seperti /api/books/{id} menjadi regex
            $pattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_-]+)', $route['path']);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $request->uri, $matches)) {
                // Buang elemen pertama (full match)
                array_shift($matches);
                
                // Jalankan handler, kirim request dan parameter (seperti ID)
                call_user_func_array($route['handler'], array_merge([$request], $matches));
                return;
            }
        }
        
        Response::json(['success' => false, 'message' => 'Endpoint tidak ditemukan: ' . $request->uri], 404);
    }
}