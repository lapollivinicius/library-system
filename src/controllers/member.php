<?php

namespace controllers;

class member extends controller
{

  public function index()
  {
    $this->render('app/members');
  }
}
