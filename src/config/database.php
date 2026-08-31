<?php

namespace config;

use PDO;

class database
{

  public static function connect(): PDO|array
  {
    $db_host = 'mysql:host=mariadb;dbname=library;charset=utf8mb4';
    $db_user = getenv('DB_USER');
    $db_pass = getenv('DB_PASSWORD');
    $connection = new PDO($db_host, $db_user, $db_pass);
    return $connection;
  }

  public static function setup(PDO $database)
  {
    return $database->exec('
        CREATE TABLE IF NOT EXISTS users (
          user_id VARCHAR(36) PRIMARY KEY NOT NULL,
          name VARCHAR(64) NOT NULL,
          email VARCHAR(64) UNIQUE NOT NULL,
          password VARCHAR(255) NOT NULL,
          library_name VARCHAR(64) NOT NULL,
          is_active BOOLEAN NOT NULL DEFAULT TRUE
        );
        CREATE TABLE IF NOT EXISTS members (
          member_id VARCHAR(36) PRIMARY KEY NOT NULL,
          user_id VARCHAR(36) NOT NULL,
          code VARCHAR(16) NOT NULL,
          name VARCHAR(64) NOT NULL,
          email VARCHAR(64) NOT NULL,
          phone VARCHAR(36) NOT NULL,
          document VARCHAR(36) NOT NULL,
          is_active BOOLEAN NOT NULL DEFAULT TRUE,

          UNIQUE KEY unique_user_code (user_id, code),
          UNIQUE KEY unique_user_name (user_id, name),
          UNIQUE KEY unique_user_email (user_id, email),

          FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
        );
        CREATE TABLE IF NOT EXISTS books (
          book_id VARCHAR(36) PRIMARY KEY NOT NULL,
          user_id VARCHAR(36) NOT NULL,
          code VARCHAR(16) NOT NULL,
          title VARCHAR(64) NOT NULL,
          author VARCHAR(64) NOT NULL,
          isbn VARCHAR(64) NOT NULL,
          genre VARCHAR(64) NOT NULL,
          year VARCHAR(4) NOT NULL,
          quantity INT NOT NULL DEFAULT 0,
          available INT NOT NULL DEFAULT 0,
          is_active BOOLEAN NOT NULL DEFAULT TRUE,

          FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,

          UNIQUE KEY unique_user_title (user_id, title),
          UNIQUE KEY unique_user_code (user_id, code)
        );
        CREATE TABLE IF NOT EXISTS loans (
          loan_id VARCHAR(36) PRIMARY KEY NOT NULL,
          user_id VARCHAR(36) NOT NULL,
          code VARCHAR(16) NOT NULL,
          member_code VARCHAR(36) NOT NULL,
          book_code VARCHAR(36) NOT NULL,
          loaned_at DATETIME NOT NULL,
          due_at DATETIME NOT NULL,
          returned_at DATETIME NULL,
          is_returned BOOLEAN NOT NULL DEFAULT FALSE,
          is_active BOOLEAN NOT NULL DEFAULT TRUE,

          FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
          FOREIGN KEY (user_id, member_code) REFERENCES members(user_id, code) ON DELETE CASCADE,
          FOREIGN KEY (user_id, book_code) REFERENCES books(user_id, code) ON DELETE CASCADE,

          UNIQUE KEY unique_user_code (user_id, code)
        );
    ') !== false;
  }
}
