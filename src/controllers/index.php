<?php

namespace controllers;

use ArrayIterator;

class index
{

  protected \stdClass $view;

  public function __construct()
  {
    $this->view = new \stdClass();
  }

  public function notFound()
  {
    $this->render('404');
  }

  public function terms()
  {
    $this->render('terms');
  }
  public function privacy()
  {
    $this->render('privacy');
  }

  public function home()
  {
    $this->render('home');
  }

  public function dashboard()
  {
    \config\middleware::auth();
    $this->render('dashboard');
  }

  public function login()
  {
    # check if already logged in
    $this->render('login');
  }

  public function register()
  {
    # check if already logged in
    $this->render('register');
  }

  public function render(string $view, string $layout = 'layout')
  {
    $this->view->page = $view;
    $this->view->csrf_token = \config\middleware::csrfToken();
    require_once '../views/' . $layout . '.phtml';
  }

  public function content()
  {
    require_once '../views/index/' . $this->view->page . '.phtml';
  }
}
