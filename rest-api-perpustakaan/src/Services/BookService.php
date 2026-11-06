<?php
namespace App\Services;

use App\Contracts\BookRepositoryInterface;
use App\Models\Book;

class BookService {
    private BookRepositoryInterface $repo;

    public function __construct(BookRepositoryInterface $repo) {
        $this->repo = $repo;
    }

    public function getAllBooks(): array {
        return $this->repo->all();
    }

    public function getBookById(int $id): ?Book {
        return $this->repo->find($id);
    }

    public function createBook(array $data): Book {
        $this->validateBookData($data);
        $book = new Book(null, $data['judul'], $data['penulis'], (int)$data['tahun'], (int)$data['stok']);
        return $this->repo->create($book);
    }

    public function updateBook(int $id, array $data): bool {
        $this->validateBookData($data);
        $book = new Book($id, $data['judul'], $data['penulis'], (int)$data['tahun'], (int)$data['stok']);
        return $this->repo->update($id, $book);
    }

    public function deleteBook(int $id): bool {
        return $this->repo->delete($id);
    }

    private function validateBookData(array $data): void {
        if (empty($data['judul'])) {
            throw new \InvalidArgumentException("Judul wajib diisi");
        }
        if (empty($data['penulis'])) {
            throw new \InvalidArgumentException("Penulis wajib diisi");
        }
    }
}