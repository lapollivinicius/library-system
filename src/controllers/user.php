<?php

namespace controllers;

require_once '../config/database.php';
require_once '../validators/user.php';
require_once '../models/user.php';
require_once '../models/loan.php';
require_once '../entities/loan.php';
require_once '../entities/user.php';
require_once 'auth.php';

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

    return [
      'stats'   => $stats, 
      'recents' => $recents
    ];
  }

  public function updateUser()
  {

    $data = [
      'library_name' => $_POST['library_name']
    ];

    $validate = new \validators\user();

    if (!$validate->update($data)) {
      $_SESSION['data']  = $data;
      $_SESSION['error'] = $validate->getError();
      header('location: /profile');
      exit;
    }

    $database   = \config\database::connect();
    $model_user = new \models\user($database);

    $user = $model_user->find($this->user_id);

    if (!$user) {
      $_SESSION['error'] = 'User not found' . $this->user_id;
      header('location: /profile');
      exit;
    }

    $user->__set('library_name', $data['library_name']);

    try {
      $model_user->update($this->user_id, $user);
      $_SESSION['library_name'] = $data['library_name'];
      $_SESSION['success'] = 'The user was edited';
      header('location: /profile');
      exit;
    } catch (\PDOException $error) {
      $_SESSION['error'] = 'DATABASE ERROR - SORRY :( <br> ERROR: ' . $error->getMessage();
      header('location: /profile');
      exit;
    }
  }

  public function deleteUser()
  {

    $database   = \config\database::connect();
    $model_user = new \models\user($database);
    $user       = $model_user->find($this->user_id);
    $auth       = new auth();

    if (!$user) {
      $_SESSION['error'] = "User not found";
      header('location: /profile');
      exit;
    }

    try {
      $model_user->delete($this->user_id);
      $auth->logout();
      header('location: /login');
      exit;
    } catch (\PDOException $error) {
      $_SESSION['error'] = 'DATABASE ERROR - SORRY :( <br> ERROR: ' . $error->getMessage();
      header('location: /profile');
      exit;
    }
  }
}
