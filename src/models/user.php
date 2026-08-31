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
    $query = '
      INSERT INTO users (
        user_id, 
        library_name, 
        name, 
        email, 
        password, 
        is_active)
      VALUES (
        :user_id, 
        :library_name, 
        :name, 
        :email, 
        :password, 
        :is_active
      );
    ';

    $stmt = $this->database->prepare($query);
    $stmt->bindValue(':user_id', $user->__get('user_id'), PDO::PARAM_STR);
    $stmt->bindValue(':library_name', $user->__get('library_name'), PDO::PARAM_STR);
    $stmt->bindValue(':name', $user->__get('name'), PDO::PARAM_STR);
    $stmt->bindValue(':email', $user->__get('email'), PDO::PARAM_STR);
    $stmt->bindValue(':password', $user->__get('password'), PDO::PARAM_STR);
    $stmt->bindValue(':is_active', $user->__get('is_active'), PDO::PARAM_BOOL);

    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function read(string $email)
  {
    $query = '
      SELECT *
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

  public function update(string $user_id, \entities\user $user): void
  {
    $query = '
      UPDATE users SET
        library_name = :library_name
      WHERE user_id = :user_id AND is_active = TRUE;
    ';

    $stmt = $this->database->prepare($query);

    $stmt->execute([
      'user_id'      => $user_id,
      'library_name' => $user->__get('library_name'),
    ]);
  }

  public function delete(string $user_id): void
  {
    $query = "
      DELETE FROM users
      WHERE user_id = :user_id
      LIMIT 1
    ";

    $stmt = $this->database->prepare($query);
    $stmt->execute([
      ':user_id' => $user_id
    ]);
  }

  public function find(string $user_id) 
  {
    $query = '
      SELECT *
      FROM users
      WHERE user_id = :user_id 
      LIMIT 1
    ';

    $stmt = $this->database->prepare($query);
    $stmt->execute([
      ':user_id' => $user_id,
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

  public function stats(string $user_id)
  {
    $query = '
      SELECT
        (SELECT COUNT(*)
        FROM books
        WHERE user_id = :user_id
          AND is_active = 1) AS books_count,

        (SELECT COUNT(*)
        FROM members
        WHERE user_id = :user_id
          AND is_active = 1) AS members_count,

        (SELECT COUNT(*)
        FROM loans
        WHERE is_returned = FALSE
          AND user_id = :user_id
          AND is_active = 1) AS active_loans,

        (SELECT COUNT(*)
        FROM loans
        WHERE due_at < NOW()
          AND is_returned = FALSE
          AND user_id = :user_id
          AND is_active = 1) AS overdue_loans
    ';

    $stmt = $this->database->prepare($query);
    $stmt->execute([
        ':user_id' => $user_id
    ]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
}
