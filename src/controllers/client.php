<?php

namespace controllers;

class client extends controller
{

  public function index()
  {
    $this->render('app/clients');
  }
}
