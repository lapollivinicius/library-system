<?php

namespace controllers;

require_once '../models/loan.php';

class loan extends controller
{

  public function index()
  {
    $this->render('app/loans');
  }

  public function editLoan(array $params = [])
  {
    $id = $params['id'] ?? null;

    if (!$id) {
      header('location: /loans');
      exit;
    }

    $database = \config\database::connect();
    $model    = new \models\loan($database);

    $loan = $model->find($id);

    if (!$loan) {
      header('location: /loans');
      exit;
    }

    $this->view->loan = $loan;
    $this->render('app/edit-loan');
  }
}
