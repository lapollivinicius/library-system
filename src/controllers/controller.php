<?php

namespace controllers;

abstract class controller
{

  protected \stdClass $view;

  public function __construct()
  {
    $this->view = new \stdClass();
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
