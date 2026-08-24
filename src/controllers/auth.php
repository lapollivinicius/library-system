<?php

namespace controllers;

require_once '../validators/auth.php';
require_once '../entities/user.php';
require_once '../models/user.php';

class auth
{
  public function register()
  {

    $data = $_POST;
    $validate = new \validators\auth();

    if (!$validate->register($data)) {
      $_SESSION['data'] = $data;
      $_SESSION['error'] = $validate->getError();
      header('location: /register');
      exit;
    }

    $user_id      = \config\utils::UUID();
    $library_name = strtolower($data['library_name']);
    $name         = strtolower($data['name']);
    $email        = strtolower($data['email']);
    $password     = password_hash($data['password'], PASSWORD_DEFAULT);

    $database     = \config\database::connect();
    $user_model   = new \models\user($database);

    if ($user_model->read($email)) {
      $_SESSION['success'] = 'email already registed';
      header('location: /login');
      exit;
    }

    $user = new \entities\user(
      $user_id,
      $library_name,
      $name,
      $email,
      $password,
      true
    );

    try {
      $user_model->create($user);
      $_SESSION['success'] = 'Welcome, enter your email and password to log in.';
      header('location: /login');
      exit;
    } catch (\PDOException $error) {
      $_SESSION['error'] = 'DATABASE ERROR - SORRY :( <br> ERROR: ' . $error->getMessage();
      header('location: /register');
      exit;
    }
  }

  public function login()
  {

    $data = $_POST;
    $validate = new \validators\auth();

    if (!$validate->login($data)) {
      $_SESSION['data'] = $data;
      $_SESSION['error'] = $validate->getError();
      header('location: /login');
      exit;
    };

    $email    = strtolower($data['email']);
    $password = $data['password'];

    $database = \config\database::connect();
    $user_model = new \models\user($database);
    $user = $user_model->read($email);

    if (!$user) {
      $_SESSION['data'] = $data;
      $_SESSION['error'] = 'email or password incorrect';
      header('location: /login');
      exit;
    };

    if (!password_verify($password, $user->__get('password'))) {
      $_SESSION['data'] = $data;
      $_SESSION['error'] = 'email or password incorrect';
      header('location: /login');
      exit;
    };

    $_SESSION['library_name'] = $user->__get('library_name');
    $_SESSION['user_id'] = $user->__get('user_id');
    $_SESSION['name'] = $user->__get('name');

    header('location: /dashboard');
    exit;
  }

  public function logout()
  {
    $_SESSION = [];

    if (ini_get('session.use_cookies')) {
      $params = session_get_cookie_params();

      setcookie(
        session_name(),
        '',
        time() - 42000,
        $params['path'],
        $params['domain'],
        $params['secure'],
        $params['httponly']
      );
    }

    session_destroy();
    $_SESSION['success'] = 'See you later :)';
    header('Location: /login');
    exit;
  }
}
