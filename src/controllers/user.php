<?php

namespace controllers;

require_once '../config/database.php';
require_once '../models/user.php';
require_once '../models/loan.php';
require_once '../entities/loan.php';

class user extends controller
{

  public function dashboard()
  {
    $this->view->infoDashboard = $this->infoDashboard();
    $this->render('app/users/dashboard');
  }

  public function profile()
  {
    $this->render('app/users/profile');
  }

  public function infoDashboard() 
  {

    $database   = \config\database::connect();
    $model_user = new \models\user($database);
    $model_loan = new \models\loan($database);

    $stats   = $model_user->stats($this->user_id);
    $recents = $model_loan->recent($this->user_id);

    return ['stats' => $stats, 'recents' => $recents];

  }
}
