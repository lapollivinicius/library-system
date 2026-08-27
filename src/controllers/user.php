<?php

namespace controllers;

class user extends controller
{

  public function dashboard()
  {
    $this->render('app/users/dashboard');
  }

  public function profile()
  {
    $this->render('app/users/profile');
  }
}
