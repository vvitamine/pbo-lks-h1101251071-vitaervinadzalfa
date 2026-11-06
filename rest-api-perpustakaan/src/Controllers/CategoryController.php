<?php
namespace App\Controllers;

use App\Services\CategoryService;
use App\Core\Request;
use App\Core\Response;

class CategoryController {
    private CategoryService $service;

    public function __construct(CategoryService $service) {
        $this->service = $service;
    }

    public function index(Request $request): void {
        $categories = $this->service->getAllCategories();
        $data = array_map(fn($c) => $c->toArray(), $categories);
        Response::json(['success' => true, 'message' => 'Daftar kategori', 'data' => $data]);
    }

    public function show(Request $request, int $id): void {
        $category = $this->service->getCategoryById($id);
        if (!$category) {
            Response::json(['success' => false, 'message' => "Kategori dengan ID $id tidak ditemukan"], 404);
            return;
        }
        Response::json(['success' => true, 'data' => $category->toArray()]);
    }

    public function store(Request $request): void {
        try {
            $category = $this->service->createCategory($request->body);
            Response::json(['success' => true, 'message' => 'Kategori berhasil dibuat', 'data' => $category->toArray()], 201);
        } catch (\InvalidArgumentException $e) {
            Response::json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    public function update(Request $request, int $id): void {
        try {
            $category = $this->service->getCategoryById($id);
            if (!$category) {
                Response::json(['success' => false, 'message' => "Kategori dengan ID $id tidak ditemukan"], 404);
                return;
            }
            $this->service->updateCategory($id, $request->body);
            Response::json(['success' => true, 'message' => 'Kategori berhasil diupdate', 'data' => $this->service->getCategoryById($id)->toArray()]);
        } catch (\InvalidArgumentException $e) {
            Response::json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    public function destroy(Request $request, int $id): void {
        $category = $this->service->getCategoryById($id);
        if (!$category) {
            Response::json(['success' => false, 'message' => "Kategori dengan ID $id tidak ditemukan"], 404);
            return;
        }
        $this->service->deleteCategory($id);
        Response::json(['success' => true, 'message' => 'Kategori berhasil dihapus']);
    }
}