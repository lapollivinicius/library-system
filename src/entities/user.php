<?php

namespace entities;

class user
{

  private string $user_id;
  private string $library_name;
  private string $name;
  private string $email;
  private string $password;
  private bool $is_active;

  public function __construct(string $user_id, string $library_name, string $name, string $email, string $password, bool $is_active = true)
  {
    $this->user_id = $user_id;
    $this->library_name = $library_name;
    $this->name = $name;
    $this->email = $email;
    $this->password = $password;
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
