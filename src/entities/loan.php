<?php

namespace entities;

class loan
{

  private string $loan_id;
  private string $user_id;
  private string $member_id;
  private string $book_id;
  private string $loaned_at;
  private string $due_at;
  private string $returned_at;
  private bool $is_active;

  public function __construct(
    string $loan_id,
    string $user_id,
    string $member_id,
    string $book_id,
    string $loaned_at,
    string $due_at,
    string $returned_at,
    bool $is_active = true
  ) {
    $this->loan_id = $loan_id;
    $this->user_id = $user_id;
    $this->member_id = $member_id;
    $this->book_id = $book_id;
    $this->loaned_at = $loaned_at;
    $this->due_at = $due_at;
    $this->returned_at = $returned_at;
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
