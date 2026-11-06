<?php
namespace App\Repositories;
use App\Contracts\CategoryRepositoryInterface;
use App\Models\Category;
use PDO;

class MySQLCategoryRepository implements CategoryRepositoryInterface {
    private PDO $pdo;
    public function __construct(PDO $pdo) { $this->pdo = $pdo; }

    public function all(): array {
        $stmt = $this->pdo->query("SELECT * FROM categories");
        $rows = $stmt->fetchAll();
        $categories = [];
        foreach ($rows as $row) {
            $categories[] = new Category($row['id'], $row['nama'], $row['deskripsi']);
        }
        return $categories;
    }

    public function find(int $id): ?Category {
        $stmt = $this->pdo->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ? new Category($row['id'], $row['nama'], $row['deskripsi']) : null;
    }

    public function create(Category $category): Category {
        $stmt = $this->pdo->prepare("INSERT INTO categories (nama, deskripsi) VALUES (?, ?)");
        $stmt->execute([$category->getNama(), $category->getDeskripsi()]);
        $id = (int)$this->pdo->lastInsertId();
        return new Category($id, $category->getNama(), $category->getDeskripsi());
    }

    public function update(int $id, Category $category): bool {
        $stmt = $this->pdo->prepare("UPDATE categories SET nama=?, deskripsi=? WHERE id=?");
        return $stmt->execute([$category->getNama(), $category->getDeskripsi(), $id]);
    }

    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM categories WHERE id=?");
        return $stmt->execute([$id]);
    }
}