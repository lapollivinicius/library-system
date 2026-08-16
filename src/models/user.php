<?php

namespace models;

use PDO;

class user
{

  protected PDO $database;

  public function __construct(PDO $database)
  {
    $this->database = $database;
  }

  public function create(\entities\user $user)
  {
    $user_id = $user->__get('user_id');
    $library_name = $user->__get('library_name');
    $name = $user->__get('name');
    $email = $user->__get('email');
    $password = $user->__get('password');
    $is_active = $user->__get('is_active');
    $query = '
        INSERT INTO users (user_id, library_name, name, email, password, is_active)
        VALUES (:user_id, :library_name, :name, :email, :password, :is_active);
      ';
    $stmt = $this->database->prepare($query);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
    $stmt->bindValue(':library_name', $library_name, PDO::PARAM_STR);
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->bindValue(':password', $password, PDO::PARAM_STR);
    $stmt->bindValue(':is_active', $is_active, PDO::PARAM_BOOL);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function read(string $email)
  {
    $query = '
        SELECT user_id, library_name, name, email, password, is_active
        FROM users
        WHERE email = :email
        LIMIT 1
      ';
    $stmt = $this->database->prepare($query);
    $stmt->execute([
      ':email' => $email
    ]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$data) {
      return null;
    };
    return new \entities\user(
      user_id: $data['user_id'],
      library_name: $data['library_name'],
      name: $data['name'],
      email: $data['email'],
      password: $data['password'],
      is_active: (bool) $data['is_active'],
    );
  }
}
