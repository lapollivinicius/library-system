<?php

namespace controllers;

require_once '../validators/validators.php';
require_once '../validators/loan.php';
require_once '../config/utils.php';
require_once '../entities/loan.php';
require_once '../entities/book.php';
require_once '../entities/member.php';
require_once '../models/loan.php';
require_once '../models/book.php';
require_once '../models/member.php';

class loan extends controller
{

  public function index()
  {
    $this->view->search = $this->searchLoans();
    $this->render('app/loans/loans');
  }

  public function searchLoans()
  {
    # search
    $search  = $_GET['search'] ?? '';
    $limit  = max(1, (int) ($_GET['limit'] ?? 7));
    $page   = max(1, (int) ($_GET['page']  ?? 1));
    $offset = ($page - 1) * $limit;
    $sort   = $_GET['sort'] ?? 'asc';
    $sort   = in_array(strtolower($sort), ['asc', 'desc'])
      ? strtolower($sort)
      : 'asc';

    $database = \config\database::connect();
    $model_loan    = new \models\loan($database);

    $loans = $model_loan->search($this->user_id, $search, $limit, $offset, $sort);

    $totalLoans = $model_loan->count($this->user_id, $search);

    $totalPages = (int) ceil($totalLoans / $limit);

    return [
      'loans' => $loans,
      'totalLoans' => $totalLoans,
      'totalPages' => $totalPages,
      'sort' => $sort,
      'page' => $page,
      'limit' => $limit,
      'offset' => $offset
    ];
  }

  public function addLoan() 
  {

    # book, member, loan (date), return (date)
    $data = [
      'book' => $_POST['book'],
      'member' => $_POST['member'],
      'loan' => $_POST['loan'],
      'return' => $_POST['return'],
    ];

    $validate = new \validators\loan();

    if (!$validate->loan($data)) {
      $_SESSION['data'] = $data;
      $_SESSION['error'] = $validate->getError();
      header('location: /loans');
      exit;
    };

    $database     = \config\database::connect();
    $model_loan   = new \models\loan($database);
    $model_book   = new \models\book($database);
    $model_member = new \models\member($database);

    $book = $model_book->find($this->user_id, $data['book']);

    if(!$book) {
      $_SESSION['data'] = $data;
      $_SESSION['error'] = 'Book not found';
      header('location: /loans');
      exit;
    }

    $book_available = $book->__get('available');

    if($book_available < 1) {
      $_SESSION['data'] = $data;
      $_SESSION['error'] = 'This book isnt available';
      header('location: /loans');
      exit;
    }

    $book->__set('available', ($book_available - 1));
    $search_member = ['name' => $data['member'],'email' => ''];
    $member = $model_member->find($this->user_id, $search_member);

    if(!$member) {
      $_SESSION['data'] = $data;
      $_SESSION['error'] = 'Member not found';
      header('location: /loans');
      exit;
    }
 
    $loan_id = \config\utils::UUID();
    $user_id = $this->user_id;
    $code = \config\utils::code('L');
    $member_code = $member->__get('code');
    $book_code = $book->__get('code');
    $loaned_at = $data['loan'];
    $due_at = $data['return'];
    $returned_at = '0000-00-00';

    $loan = new \entities\loan(
      $loan_id,
      $user_id,
      $code,
      $member_code,
      $book_code,
      $loaned_at,
      $due_at,
      $returned_at,
      false,
      true
    );

    try {
      $model_loan->create($loan);
      $model_book->update($this->user_id, $book);
      $_SESSION['success'] = 'Loan registed';
      header('location: /loans');
      exit;
    } catch (\PDOException $error) {
      $_SESSION['error'] = 'DATABASE ERROR - SORRY :( <br> ERROR: ' . $error->getMessage();
      header('location: /loans');
      exit;
    }

  }

  public function returnLoan(array $params = []) {

    $code = $params['code'] ?? null;

    $database = \config\database::connect();
    $model_loan = new \models\loan($database);
    $model_book = new \models\book($database);

    $loan = $model_loan->read($this->user_id, $code);

    if(!$loan) {
      $_SESSION['error'] = 'Loan record not found';
      header('location: /loans');
      exit;
    };

    $loan->__set('is_returned', true);
    $loan->__set('returned_at', date('Y-m-d'));
    $book = $model_book->find($this->user_id, $loan->__get('book_title'));

    if(!$book) {
      $_SESSION['error'] = 'ERROR to find the book';
      header('location: /loans');
      exit;
    };

    $book_available = $book->__get('available');
    $book->__set('available', ($book_available + 1));

    try {
      $model_loan->update($this->user_id, $loan);
      $model_book->update($this->user_id, $book);
      $_SESSION['success'] = 'Book returned';
      header('location: /loans');
      exit;
    } catch (\PDOException $error) {
      $_SESSION['error'] = 'DATABASE ERROR - SORRY :( <br> ERROR: ' . $error->getMessage();
      header('location: /loans');
      exit;
    }

  }

  public function details(array $params = [])
  {
    $code = $params['code'] ?? null;

    if (!$code) {
      header('location: /loans');
      exit;
    }

    $database = \config\database::connect();
    $model    = new \models\loan($database);

    $loan = $model->read($this->user_id, $code);

    if (!$loan) {
      header('location: /loans');
      exit;
    }

    $this->view->loan = $loan;
    $this->render('app/loans/details');
  }
}
