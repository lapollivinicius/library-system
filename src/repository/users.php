<?php 

  namespace repository;

  use PDO;

  class users {
    
    protected \PDO $database;

    public function __construct(PDO $database){
      $this->database = $database;
    }

    public function getUserByUsername($username) {
      $query = '
          SELECT *
          FROM users
          WHERE username = :username
      ';
      $stmt = $this->database->prepare($query);
      $stmt->bindValue(':username', $username, PDO::PARAM_STR);
      $stmt->execute();
      return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function registerUser($user) {
      $query = '
        INSERT INTO users
          (`name`, `username`, `password`, `email`, `phone`, `document`)
        VALUES
          (:name, :username, :password, :email, :phone, :document)
      ';
      $stmt = $this->database->prepare($query);
      $stmt->bindValue(':name', $user->name, PDO::PARAM_STR);
      $stmt->bindValue(':username', $user->username, PDO::PARAM_STR);
      $stmt->bindValue(':password', $user->password, PDO::PARAM_STR);
      $stmt->bindValue(':email', $user->email, PDO::PARAM_STR);
      $stmt->bindValue(':phone', $user->phone, PDO::PARAM_STR);
      $stmt->bindValue(':document', $user->document, PDO::PARAM_STR);
      $stmt->execute();
      return $user;
    }

  }

?>