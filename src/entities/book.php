<?php

namespace entities;

class book
{

  private string $book_id;
  private string $user_id;
  private string $title;
  private string $author;
  private string $isbn;
  private int $quantity = 0;
  private bool $is_active;

  public function __construct(
    string $book_id,
    string $user_id,
    string $title,
    string $author,
    string $isbn,
    int $quantity = 0,
    bool $is_active = true
  ) {
    $this->book_id = $book_id;
    $this->user_id = $user_id;
    $this->title = $title;
    $this->author = $author;
    $this->isbn = $isbn;
    $this->quantity = $quantity;
    $this->is_active = $is_active;
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
