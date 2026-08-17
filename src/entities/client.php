<?php

namespace entities;

class client
{

  private string $client_id;
  private string $library_id;
  private string $name;
  private string $email;
  private string $phone;
  private bool $is_active;

  public function __construct(
    string $client_id,
    string $user_id,
    string $name,
    string $email,
    string $phone,
    bool $is_active = true
  ) {
    $this->client_id = $client_id;
    $this->user_id = $user_id;
    $this->name = $name;
    $this->email = $email;
    $this->phone = $phone;
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
