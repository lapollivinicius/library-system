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

  # public
  public function notFound()
  {
    $this->render('index/404');
  }

  public function terms()
  {
    $this->render('index/terms');
  }
  public function privacy()
  {
    $this->render('index/privacy');
  }

  public function home()
  {
    $this->render('index/home');
  }

  public function login()
  {
    # check if already logged in
    $this->render('index/login');
  }

  public function register()
  {
    # check if already logged in
    $this->render('index/register');
  }

  # app
  public function dashboard()
  {
    $this->render('index/dashboard');
  }

  public function books()
  {
    $this->render('index/books');
  }

  public function clients()
  {
    $this->render('index/clients');
  }

  public function loans()
  {
    $this->render('index/loans');
  }

  public function profile()
  {
    $this->render('index/profile');
  }

  protected function render(
    string $view,
    string $layout = 'layout'
  ) {
    $this->view->csrf_token = \config\middleware::csrfToken();
    $this->view->title = ucfirst(basename($view));
    $this->view->content = $view;

    require_once '../views/' . $layout . '.phtml';
  }

  public function content()
  {
   require_once '../views/' . $this->view->content . '.phtml'; 
  }
}
