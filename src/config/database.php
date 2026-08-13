<?php 

  namespace config;

  use PDO;
  use PDOException;

  class database {

    public static function connect(): PDO|array {
      $db_host = 'mysql:host=mariadb;dbname=library;charset=utf8mb4';
      $db_user = getenv('DB_USER');
      $db_pass = getenv('DB_PASSWORD');
      $connection = new PDO($db_host, $db_user, $db_pass);
      return $connection;
    }

    public static function setup(PDO $database) {
      $database->exec('
        CREATE TABLE IF NOT EXISTS users (
          id VARCHAR(36) PRIMARY KEY DEFAULT (UUID()),
          name VARCHAR(64) NOT NULL,
          username VARCHAR(64) UNIQUE NOT NULL,
          password VARCHAR(64) NOT NULL,
          role ENUM("admin", "user") NOT NULL DEFAULT "user",
          email VARCHAR(64) UNIQUE NOT NULL,
          phone VARCHAR(64) NOT NULL,
          document VARCHAR(64) NOT NULL,
          is_active BOOLEAN NOT NULL DEFAULT FALSE
        );
    ');
    }

  }
?>