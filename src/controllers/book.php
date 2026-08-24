<?php

namespace controllers;

require_once '../validators/validators.php';
require_once '../validators/book.php';
require_once '../config/utils.php';
require_once '../entities/book.php';
require_once '../models/book.php';

class book extends controller
{

  public function index()
  {

    $this->view->books = $this->searchBook();

    $this->render('app/books/books');
  }

  public function searchBook()
  {
    # title
    $limit  = max(1, (int) ($_GET['limit'] ?? 10));
    $page   = max(1, (int) ($_GET['page']  ?? 1));
    $offset = ($page - 1) * $limit;
    $title  = $_GET['title'] ?? '';

    $database = \config\database::connect();
    $model    = new \models\book($database);

    $books = $model->find($title, $limit, $offset);

    return $books;
  }

  public function addBook()
  {

    # title, author, year, genre, quant, isbn
    $data = $_POST;
    $validate = new \validators\book();

    if (!$validate->book($data)) {
      $_SESSION['data'] = $data;
      $_SESSION['error'] = $validate->getError();
      header('location: /books');
      exit;
    };

    $book_id  = \config\utils::UUID();
    $user_id  = $_SESSION['user_id'];
    $title    = strtolower($data['title']);
    $author   = strtolower($data['author']);
    $year     = strtolower($data['year']);
    $genre    = strtolower($data['genre']);
    $quantity = $data['quantity'] ?? 1;
    $isbn     = $data['isbn'] ?? '';
    $database     = \config\database::connect();
    $book_model   = new \models\book($database);

    $book = new \entities\book(
      $book_id,
      $user_id,
      0,
      $title,
      $author,
      $isbn,
      $genre,
      $year,
      $quantity,
      true
    );

    try {
      $book_model->create($book);
      $_SESSION['success'] = 'Book registed';
      header('location: /books');
      exit;
    } catch (\PDOException $error) {
      $_SESSION['error'] = 'DATABASE ERROR - SORRY :( <br> ERROR: ' . $error->getMessage();
      header('location: /books');
      exit;
    }
  }

  public function editBook(array $params = [])
  {
    $code = $params['code'] ?? null;

    if (!$code) {
      header('location: /books');
      exit;
    }

    $database = \config\database::connect();
    $model    = new \models\book($database);
    $book     = $model->read($code);

    if (!$book) {
      header('location: /books');
      exit;
    }

    $this->view->book = $book;
    $this->render('app/books/edit');
  }

  # updateBook -> update data
  # listBooks -> return JSON (title, author)

  public function deleteBook(array $params = [])
  {

    $code = $params['code'] ?? null;

    if (!$code) {
      header('location: /books');
      exit;
    }

    $database = \config\database::connect();
    $model    = new \models\book($database);
    $book     = $model->read($code);

    if (!$book) {
      header('location: /books');
      exit;
    }

    $model->delete($code);

    header('location: /books');
    exit;
  }

}
