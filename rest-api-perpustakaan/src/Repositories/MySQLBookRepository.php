<?php
namespace App\Repositories;
use App\Contracts\BookRepositoryInterface;
use App\Models\Book;
use PDO;

class MySQLBookRepository implements BookRepositoryInterface {
    private PDO $pdo;
    public function __construct(PDO $pdo) { $this->pdo = $pdo; }

    public function all(): array {
        $stmt = $this->pdo->query("SELECT * FROM books");
        $rows = $stmt->fetchAll();
        $books = [];
        foreach ($rows as $row) {
            $books[] = new Book($row['id'], $row['judul'], $row['penulis'], $row['tahun'], $row['stok']);
        }
        return $books;
    }

    public function find(int $id): ?Book {
        $stmt = $this->pdo->prepare("SELECT * FROM books WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ? new Book($row['id'], $row['judul'], $row['penulis'], $row['tahun'], $row['stok']) : null;
    }

    public function create(Book $book): Book {
        $stmt = $this->pdo->prepare("INSERT INTO books (judul, penulis, tahun, stok) VALUES (?, ?, ?, ?)");
        $stmt->execute([$book->getJudul(), $book->getPenulis(), $book->getTahun(), $book->getStok()]);
        $id = (int)$this->pdo->lastInsertId();
        return new Book($id, $book->getJudul(), $book->getPenulis(), $book->getTahun(), $book->getStok());
    }

    public function update(int $id, Book $book): bool {
        $stmt = $this->pdo->prepare("UPDATE books SET judul=?, penulis=?, tahun=?, stok=? WHERE id=?");
        return $stmt->execute([$book->getJudul(), $book->getPenulis(), $book->getTahun(), $book->getStok(), $id]);
    }

    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM books WHERE id=?");
        return $stmt->execute([$id]);
    }
}