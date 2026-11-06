<?php
namespace App\Services;

use App\Contracts\CategoryRepositoryInterface;
use App\Models\Category;

class CategoryService {
    private CategoryRepositoryInterface $repo;

    public function __construct(CategoryRepositoryInterface $repo) {
        $this->repo = $repo;
    }

    public function getAllCategories(): array { return $this->repo->all(); }
    public function getCategoryById(int $id): ?Category { return $this->repo->find($id); }

    public function createCategory(array $data): Category {
        $this->validate($data);
        $category = new Category(null, $data['nama'], $data['deskripsi'] ?? null);
        return $this->repo->create($category);
    }

    public function updateCategory(int $id, array $data): bool {
        $this->validate($data);
        $category = new Category($id, $data['nama'], $data['deskripsi'] ?? null);
        return $this->repo->update($id, $category);
    }

    public function deleteCategory(int $id): bool { return $this->repo->delete($id); }

    private function validate(array $data): void {
        if (empty($data['nama'])) {
            throw new \InvalidArgumentException("Nama kategori wajib diisi");
        }
    }
}