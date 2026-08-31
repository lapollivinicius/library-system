<?php

namespace entities;

use DateTime;

class loan
{
  private string $loan_id;
  private string $user_id;
  private string $code;
  private string $member_code;
  private string $book_code;
  private string $loaned_at;
  private string $due_at;
  private string $returned_at;
  private bool $is_returned;
  private bool $is_active;
  private string $member_name = '';
  private string $book_title = '';

  public function __construct(
    string $loan_id,
    string $user_id,
    string $code,
    string $member_code,
    string $book_code,
    string $loaned_at,
    string $due_at,
    ?string $returned_at,
    bool $is_returned    = false,
    bool $is_active      = true,
    ?string $member_name = '',
    ?string $book_title  = ''
  ) {
    $this->loan_id     = $loan_id;
    $this->user_id     = $user_id;
    $this->code        = $code;
    $this->member_code = $member_code;
    $this->book_code   = $book_code;
    $this->loaned_at   = $loaned_at;
    $this->due_at      = $due_at;
    $this->returned_at = $returned_at;
    $this->is_returned = $is_returned;
    $this->is_active   = $is_active;
    $this->member_name = $member_name;
    $this->book_title  = $book_title;
  }

  public function __get(string $item)
  {
    return $this->$item;
  }

  public function __set(string $item, mixed $value)
  {
    return $this->$item = $value;
  }
}
