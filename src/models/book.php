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

  public function create(\entities\book $book) {
    $book_id = $book->__get('book_id');
    $user_id = $book->__get('user_id');
    $title = $book->__get('title');
    $author = $book->__get('author');
    $isbn = $book->__get('isbn');
    $year = $book->__get('year');
    $quantity = $book->__get('quantity');
    $is_active = $book->__get('is_active');
    
    $query = '
        INSERT INTO books (book_id, user_id, title, author, isbn, year, quantity, is_active)
        VALUES (:book_id, :user_id, :title, :author, :isbn, :year, :quantity, :is_active);
      ';
    
    $stmt = $this->database->prepare($query);
    $stmt->bindValue(':book_id', $book_id, PDO::PARAM_STR);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
    $stmt->bindValue(':title', $title, PDO::PARAM_STR);
    $stmt->bindValue(':author', $author, PDO::PARAM_STR);
    $stmt->bindValue(':isbn', $isbn, PDO::PARAM_STR);
    $stmt->bindValue(':year', $year, PDO::PARAM_STR);
    $stmt->bindValue(':quantity', $quantity, PDO::PARAM_INT);
    $stmt->bindValue(':is_active', $is_active, PDO::PARAM_BOOL);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  
}
