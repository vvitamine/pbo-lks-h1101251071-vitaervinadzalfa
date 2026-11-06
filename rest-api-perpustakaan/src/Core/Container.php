<?php
namespace App\Core;

class Container {
    private array $bindings = [];

    public function bind(string $key, callable $resolver): void {
        $this->bindings[$key] = $resolver;
    }

    public function make(string $key) {
        if (isset($this->bindings[$key])) {
            return $this->bindings[$key]();
        }
        throw new \Exception("Binding $key tidak ditemukan");
    }
}