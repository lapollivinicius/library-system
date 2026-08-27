<?php

namespace controllers;
require_once '../validators/validators.php';
require_once '../config/database.php';
require_once '../config/utils.php';

abstract class controller
{

  protected \stdClass $view;
  protected string $user_id;

  public function __construct()
  {
    $this->view = new \stdClass();
    
    if(!empty($_SESSION['user_id'])) {
      $this->user_id = $_SESSION['user_id'];
    }

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
