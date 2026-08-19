<?php


namespace controllers;

class index extends controller
{

  public function notFound()
  {
    $this->render('public/404');
  }

  public function terms()
  {
    $this->render('public/terms');
  }
  public function privacy()
  {
    $this->render('public/privacy');
  }

  public function home()
  {
    $this->render('public/home');
  }

  public function demo()
  {
    $this->render('public/demo');
  }

  public function login()
  {
    $this->render('public/login');
  }

  public function register()
  {
    $this->render('public/register');
  }

}
