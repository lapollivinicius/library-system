<?php

namespace controllers;

class user extends controller
{

  public function dashboard()
  {
    $this->render('app/dashboard');
  }

  public function profile()
  {
    $this->render('app/profile');
  }
}
