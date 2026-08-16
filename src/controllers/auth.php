<?php

namespace controllers;

require_once '../validators/validators.php';
require_once '../validators/auth.php';
require_once '../config/utils.php';
require_once '../config/database.php';
require_once '../entities/user.php';
require_once '../entities/library.php';
require_once '../models/library.php';
require_once '../models/user.php';

class auth
{
  public function register()
  {

    \config\middleware::csrf();

    $data = $_POST;

    $validate = new \validators\auth();

    if (!$validate->register($data)) {
      $_SESSION['data'] = $data;
      $_SESSION['message'] = $validate->getError();
      header('location: /register');
      exit;
    }

    $library_id   = \config\utils::UUID();
    $user_id      = \config\utils::UUID();
    $library_name = strtolower($data['library_name']);
    $name         = strtolower($data['name']);
    $email        = strtolower($data['email']);
    $password     = password_hash($data['password'], PASSWORD_DEFAULT);

    $database     = \config\database::connect();
    $libary_model = new \models\library($database);
    $user_model   = new \models\user($database);

    if ($user_model->read($email)) {
      $_SESSION['message'] = 'email already registed';
      header('location: /login');
      exit;
    }

    $library = new \entities\library(
      $library_id,
      $library_name,
      true
    );

    $user = new \entities\user(
      $user_id,
      $library_id,
      $name,
      $email,
      $password,
      true
    );

    try {
      $libary_model->create($library);
      $user_model->create($user);

      header('location: /login');
      exit;
    } catch (\PDOException $error) {
      $_SESSION['message'] = 'DATABASE ERROR - SORRY :(';
      header('location: /register');
      exit;
    }
  }

  public function login()
  {

    \config\middleware::csrf();

    $data = $_POST;

    $validate = new \validators\auth();

    if (!$validate->login($data)) {
      $_SESSION['data'] = $data;
      $_SESSION['message'] = $validate->getError();
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
      $_SESSION['message'] = 'email or password incorrect';
      header('location: /login');
      exit;
    };

    if (!password_verify($password, $user->__get('password'))) {
      $_SESSION['data'] = $data;
      $_SESSION['message'] = 'email or password incorrect';
      header('location: /login');
      exit;
    };

    $_SESSION['library_id'] = $user->__get('library_id');
    $_SESSION['user_id'] = $user->__get('user_id');
    $_SESSION['name'] = $user->__get('name');

    header('location: /dashboard');
    exit;
  }

  public function logout()
  {

    \config\middleware::csrf();

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

    header('Location: /login');
    exit;
  }
}
