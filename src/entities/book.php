<?php

namespace entities;

class book
{

  private string $book_id;
  private string $user_id;
  private int $code;
  private string $title;
  private string $author;
  private string $isbn;
  private string $genre;
  private string $year;
  private int $quantity;
  private bool $is_active;

  public function __construct(
    string $book_id,
    string $user_id,
    int $code,
    string $title,
    string $author,
    string $isbn,
    string $genre,
    string $year,
    int $quantity = 0,
    bool $is_active = true
  ) {
    $this->book_id = $book_id;
    $this->user_id = $user_id;
    $this->code = (int) $code;
    $this->title = $title;
    $this->author = $author;
    $this->isbn = $isbn;
    $this->genre = $genre;
    $this->year = $year;
    $this->quantity = (int) $quantity;
    $this->is_active = (bool) $is_active;
  }

  public function __get(string $item)
  {
    return $this->$item;
  }

  public function __set(string $item, string $value)
  {
    return $this->$item = $value;
  }
}
