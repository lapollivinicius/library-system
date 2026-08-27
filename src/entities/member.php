<?php

namespace entities;

class member
{

  private string $member_id;
  private string $user_id;
  private string $code;
  private string $name;
  private string $email;
  private string $phone;
  private string $document;
  private bool $is_active;

  public function __construct(
    string $member_id,
    string $user_id,
    string $code,
    string $name,
    string $email,
    string $phone,
    string $document,
    bool $is_active = true
  ) {
    $this->member_id = $member_id;
    $this->user_id = $user_id;
    $this->code = $code;
    $this->name = $name;
    $this->email = $email;
    $this->phone = $phone;
    $this->document = $document;
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
