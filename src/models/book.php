<?php

namespace models;

use PDO;

class book
{

  protected PDO $database;

  public function __construct(PDO $database)
  {
    $this->database = $database;
  }

  public function create(\entities\book $book): void
  {
    $query = '
        INSERT INTO books (
            book_id,
            user_id,
            title,
            author,
            isbn,
            genre,
            year,
            quantity,
            is_active
        )
        VALUES (
            :book_id,
            :user_id,
            :title,
            :author,
            :isbn,
            :genre,
            :year,
            :quantity,
            :is_active
        )
    ';

    $stmt = $this->database->prepare($query);

    $stmt->execute([
      'book_id'   => $book->__get('book_id'),
      'user_id'   => $book->__get('user_id'),
      'title'     => $book->__get('title'),
      'author'    => $book->__get('author'),
      'isbn'      => $book->__get('isbn'),
      'genre'     => $book->__get('genre'),
      'year'      => $book->__get('year'),
      'quantity'  => $book->__get('quantity'),
      'is_active' => (bool) $book->__get('is_active'),
    ]);
  }

  public function read(string $code): \entities\book|null
  {

    $query = "
        SELECT book_id, user_id, code, title, author, isbn, genre, year, quantity, is_active
        FROM books
        WHERE code = :code
          AND is_active = 1
        LIMIT 1
      ";

    $stmt = $this->database->prepare($query);
    $stmt->execute([':code' => $code]);

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$data) {
      return null;
    }

    return new \entities\book(
      $data['book_id'],
      $data['user_id'],
      $data['code'],
      $data['title'],
      $data['author'],
      $data['isbn'],
      $data['genre'],
      $data['year'],
      $data['quantity'],
      $data['is_active']
    );
  }

  public function list(int $limit = 10, int $offset = 0): array
  {
    $query = "
        SELECT *
        FROM books
        WHERE is_active = 1
        LIMIT :limit OFFSET :offset
    ";

    $stmt = $this->database->prepare($query);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return array_map(
      fn(array $book) => new \entities\Book(
        $book['book_id'],
        $book['user_id'],
        $book['code'],
        $book['title'],
        $book['author'],
        $book['isbn'],
        $book['genre'],
        $book['year'],
        $book['quantity'],
        $book['is_active']
      ),
      $data
    );
  }

  public function delete(string $code): void
  {
    $query = "
        DELETE FROM books
        WHERE code = :code
        LIMIT 1
    ";

    $stmt = $this->database->prepare($query);
    $stmt->execute([':code' => $code]);
  }

  public function find(?string $title = '', int $limit = 10, int $offset = 0): array
  {

    $where = $title ? 'WHERE title LIKE :title AND is_active = 1' : 'WHERE is_active = 1';

    $query = "
        SELECT *
        FROM books
        {$where}
        LIMIT :limit OFFSET :offset
    ";

    $stmt = $this->database->prepare($query);

    if ($title) {
      $stmt->bindValue(':title', "%{$title}%", PDO::PARAM_STR);
    }
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return array_map(
      fn(array $book) => new \entities\Book(
        $book['book_id'],
        $book['user_id'],
        $book['code'],
        $book['title'],
        $book['author'],
        $book['isbn'],
        $book['genre'],
        $book['year'],
        $book['quantity'],
        $book['is_active']
      ),
      $data
    );
  }
  
}
