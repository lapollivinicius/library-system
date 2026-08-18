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

  # app
  public function dashboard()
  {
    \config\middleware::auth();
    $this->render('dashboard');
  }

  public function books() {
    \config\middleware::auth();
    $this->render('books');
  }

  public function clients() {
    \config\middleware::auth();
    $this->render('clients');
  }

  public function loans() {
    \config\middleware::auth();
    $this->render('loans');
  }

  public function profile() {
    \config\middleware::auth();
    $this->render('profile');
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
