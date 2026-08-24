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
            code,
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
            :code,
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
      'code'     => $book->__get('code'),
      'title'     => $book->__get('title'),
      'author'    => $book->__get('author'),
      'isbn'      => $book->__get('isbn'),
      'genre'     => $book->__get('genre'),
      'year'      => $book->__get('year'),
      'quantity'  => $book->__get('quantity'),
      'is_active' => (bool) $book->__get('is_active'),
    ]);
  }

  public function read(string $user_id, string $code): \entities\book|null
  {

    $query = "
        SELECT book_id, user_id, code, title, author, isbn, genre, year, quantity, is_active
        FROM books
        WHERE code = :code
          AND user_id = :user_id
          AND is_active = 1
        LIMIT 1
      ";

    $stmt = $this->database->prepare($query);
    $stmt->execute([
      ':user_id' => $user_id,
      ':code' => $code
    ]);

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

  public function find(string $user_id, string $title): \entities\book|false
  {

    $query = "
        SELECT book_id, user_id, code, title, author, isbn, genre, year, quantity, is_active
        FROM books
        WHERE title = :title
          AND user_id = :user_id
          AND is_active = 1
        LIMIT 1
      ";

    $stmt = $this->database->prepare($query);
    $stmt->execute([
      ':title' => $title,
      ':user_id' => $user_id
    ]);

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$data) {
      return false;
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

  public function list(string $user_id, int $limit = 10, int $offset = 0): array
  {
    $query = "
        SELECT *
        FROM books
        WHERE user_id = :user_id AND is_active = 1 
        LIMIT :limit OFFSET :offset
    ";

    $stmt = $this->database->prepare($query);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
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

  public function delete(string $user_id, string $code): void
  {
    $query = "
        DELETE FROM books
        WHERE code = :code
          AND user_id = :user_id
        LIMIT 1
    ";

    $stmt = $this->database->prepare($query);
    $stmt->execute([
      ':code' => $code,
      ':user_id' => $user_id
    ]);
  }

  public function search(string $user_id, ?string $title = '', int $limit = 10, int $offset = 0, string $sort = 'asc'): array
  {

    $sort = strtolower($sort);

    if (!in_array($sort, ['asc', 'desc'], true)) {
      $sort = 'asc';
    }

    $where = $title
      ? 'WHERE user_id = :user_id AND title LIKE :title AND is_active = 1'
      : 'WHERE user_id = :user_id AND is_active = 1';

    $query = "
        SELECT *
        FROM books
        {$where}
        ORDER BY title {$sort}
        LIMIT :limit OFFSET :offset
    ";

    $stmt = $this->database->prepare($query);

    if ($title) {
      $stmt->bindValue(':title', "%{$title}%", PDO::PARAM_STR);
    }
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
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

  public function update(string $user_id, \entities\book $book): void
  {
    $query = '
        UPDATE books SET
            title = :title,
            author = :author,
            isbn = :isbn,
            genre = :genre,
            year = :year,
            quantity = :quantity
        WHERE user_id = :user_id AND code = :code
    ';

    $stmt = $this->database->prepare($query);

    $stmt->execute([
      'user_id'    => $user_id,
      'title'    => $book->__get('title'),
      'author'   => $book->__get('author'),
      'isbn'     => $book->__get('isbn'),
      'genre'    => $book->__get('genre'),
      'year'     => $book->__get('year'),
      'quantity' => $book->__get('quantity'),
      'code'     => $book->__get('code'),
    ]);
  }

  public function count(string $user_id, ?string $title = ''): int
  {
    $where = $title
      ? 'WHERE user_id = :user_id AND title LIKE :title AND is_active = 1'
      : 'WHERE user_id = :user_id AND is_active = 1';

    $query = "
          SELECT COUNT(*)
          FROM books
          {$where}
      ";

    $stmt = $this->database->prepare($query);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
    if ($title) {
      $stmt->bindValue(':title', "%{$title}%", PDO::PARAM_STR);
    }

    $stmt->execute();

    return (int) $stmt->fetchColumn();
  }
}
