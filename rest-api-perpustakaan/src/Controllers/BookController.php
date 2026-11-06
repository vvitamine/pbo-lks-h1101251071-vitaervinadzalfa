<?php
namespace App\Controllers;

use App\Services\BookService;
use App\Core\Request;
use App\Core\Response;

class BookController {
    private BookService $service;

    public function __construct(BookService $service) {
        $this->service = $service;
    }

    public function index(Request $request): void {
        $books = $this->service->getAllBooks();
        $data = array_map(fn($b) => $b->toArray(), $books);
        Response::json(['success' => true, 'message' => 'Daftar buku', 'data' => $data]);
    }

    public function show(Request $request, int $id): void {
        $book = $this->service->getBookById($id);
        if (!$book) {
            Response::json(['success' => false, 'message' => "Buku dengan ID $id tidak ditemukan"], 404);
            return;
        }
        Response::json(['success' => true, 'data' => $book->toArray()]);
    }

    public function store(Request $request): void {
        try {
            $book = $this->service->createBook($request->body);
            Response::json(['success' => true, 'message' => 'Buku berhasil dibuat', 'data' => $book->toArray()], 201);
        } catch (\InvalidArgumentException $e) {
            Response::json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    public function update(Request $request, int $id): void {
        try {
            $book = $this->service->getBookById($id);
            if (!$book) {
                Response::json(['success' => false, 'message' => "Buku dengan ID $id tidak ditemukan"], 404);
                return;
            }
            $this->service->updateBook($id, $request->body);
            Response::json(['success' => true, 'message' => 'Buku berhasil diupdate', 'data' => $this->service->getBookById($id)->toArray()]);
        } catch (\InvalidArgumentException $e) {
            Response::json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    public function destroy(Request $request, int $id): void {
        $book = $this->service->getBookById($id);
        if (!$book) {
            Response::json(['success' => false, 'message' => "Buku dengan ID $id tidak ditemukan"], 404);
            return;
        }
        $this->service->deleteBook($id);
        Response::json(['success' => true, 'message' => 'Buku berhasil dihapus']);
    }
}