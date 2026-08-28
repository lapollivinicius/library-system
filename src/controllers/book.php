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
    $this->view->search = $this->searchBook();
    $this->render('app/books/books');
  }
  
  public function edit(array $params = [])
  {
    $code = $params['code'] ?? null;

    if (!$code) {
      header('location: /books');
      exit;
    }

    $database = \config\database::connect();
    $model    = new \models\book($database);
    $book     = $model->read($this->user_id, $code);

    if (!$book) {
      header('location: /books');
      exit;
    }

    $this->view->book = $book;
    $this->render('app/books/edit');
  }

  public function searchBook()
  {
    # title
    $title  = $_GET['title'] ?? '';
    $limit  = max(1, (int) ($_GET['limit'] ?? 7));
    $page   = max(1, (int) ($_GET['page']  ?? 1));
    $offset = ($page - 1) * $limit;
    $sort   = $_GET['sort'] ?? 'asc';
    $sort   = in_array(strtolower($sort), ['asc', 'desc'])
      ? strtolower($sort)
      : 'asc';

    # validate title ?

    $database = \config\database::connect();
    $model    = new \models\book($database);

    $books = $model->search($this->user_id, $title, $limit, $offset, $sort);

    $totalBooks = $model->count($this->user_id, $title);

    $totalPages = (int) ceil($totalBooks / $limit);

    return [
      'books' => $books,
      'totalBooks' => $totalBooks,
      'totalPages' => $totalPages,
      'sort' => $sort,
      'page' => $page,
      'limit' => $limit,
      'offset' => $offset
    ];
  }

  public function addBook()
  {

    # POST -> title, author, year, genre, quant, isbn
    $data = [
      'title' => $_POST['title'] ?? '',
      'author' => $_POST['author'] ?? '',
      'year' => $_POST['year'] ?? '',
      'genre' => $_POST['genre'] ?? '',
      'quantity' => $_POST['quantity'] ?? '',
      'isbn' => $_POST['isbn'] ?? ''
    ];
    $validate = new \validators\book();

    if (!$validate->book($data)) {
      $_SESSION['data'] = $data;
      $_SESSION['error'] = $validate->getError();
      header('location: /books');
      exit;
    };
    $database  = \config\database::connect();
    $model     = new \models\book($database);

    $title     = strtolower($data['title']);
    $bookFound = $model->find($this->user_id, $title);

    if($bookFound) {
      $_SESSION['data'] = $data;
      $_SESSION['error'] = 'The book already registed';
      header('location: /books');
      exit;
    }

    $book_id  = \config\utils::UUID();
    $code     = \config\utils::code('B');
    $user_id  = $this->user_id;
    $author   = strtolower($data['author']);
    $year     = strtolower($data['year']);
    $genre    = strtolower($data['genre']);
    $quantity = $data['quantity'] ?? 1;
    $isbn     = $data['isbn'] ?? '';

    $book = new \entities\book(
      $book_id,
      $user_id,
      $code,
      $title,
      $author,
      $isbn,
      $genre,
      $year,
      $quantity,
      true
    );

    try {
      $model->create($book);
      $_SESSION['success'] = 'Book registed';
      header('location: /books');
      exit;
    } catch (\PDOException $error) {
      $_SESSION['error'] = 'DATABASE ERROR - SORRY :( <br> ERROR: ' . $error->getMessage();
      header('location: /books');
      exit;
    }
  }

  public function updateBook(array $params = [])
  {
    # TASK: find a book by title to validate (edit a book to title alread registed)
    # POST -> title, author, year, genre, quant, isbn
    $code = $params['code'] ?? null;

    $database  = \config\database::connect();
    $model     = new \models\book($database);

    $book = $model->read($this->user_id, $code);

    if (!$book) {
      $_SESSION['error'] = 'The book was not registered';
      header('location: /books');
      exit;
    }

    $data = [
      'title' => $_POST['title'] ?? '',
      'author' => $_POST['author'] ?? '',
      'genre' => $_POST['genre'] ?? '',
      'year' => $_POST['year'] ?? '',
      'quantity' => $_POST['quantity'] ?? '',
      'isbn' => $_POST['isbn'] ?? ''
    ];

    $validate = new \validators\book();

    if (!$validate->book($data)) {
      $_SESSION['data'] = $data;
      $_SESSION['error'] = $validate->getError();
      header('location: /books/edit/' . $code);
      exit;
    };

    $book->__set('title', $data['title']);
    $book->__set('author', $data['author']);
    $book->__set('genre', $data['genre']);
    $book->__set('year', $data['year']);
    $book->__set('quantity', $data['quantity']);
    $book->__set('isbn', $data['isbn']);

    try {
      $model->update($this->user_id, $book);
      $_SESSION['success'] = 'The Book was edited';
      header('location: /books/edit/' . $code);
      exit;
    } catch (\PDOException $error) {
      $_SESSION['error'] = 'DATABASE ERROR - SORRY :( <br> ERROR: ' . $error->getMessage();
      header('location: /books/edit/' . $code);
      exit;
    }
  }

  public function deleteBook(array $params = [])
  {

    $code = $params['code'] ?? null;

    if (!$code) {
      header('location: /books');
      exit;
    }

    $database = \config\database::connect();
    $model    = new \models\book($database);
    $book     = $model->read($this->user_id, $code);

    if (!$book) {
      $_SESSION['error'] = "The book doesn't exists";
      header('location: /books');
      exit;
    }

    $model->delete($this->user_id, $code);

    $_SESSION['success'] = 'The Book was deleted';
    header('location: /books');
    exit;
  }

  public function listBooks()
  {
      $title = $_GET['title'] ?? '';
      $limit = max(1, (int) ($_GET['limit'] ?? 7));
      $user_id = $this->user_id ?? false;

      if(!$user_id) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'success' => false,
            'msg' => 'Unauthorized'
        ]);
        exit;
      }

      $database = \config\database::connect();
      $model    = new \models\book($database);
      $books    = $model->search(
          $user_id,
          $title,
          $limit,
          0,
          'asc'
      );

      $books = array_map(
          fn($book) => [
              'title' => $book->__get('title'),
              'author' => $book->__get('author')
          ],
          $books
      );
      
      header('Content-Type: application/json; charset=utf-8');
      echo json_encode([
          'success' => true,
          'books' => $books
      ]);
      exit;
  }

}
