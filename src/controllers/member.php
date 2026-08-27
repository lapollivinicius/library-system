<?php

namespace controllers;

require_once '../models/member.php';

class member extends controller
{

  public function index()
  {
    $this->render('app/members/members');
  }

  public function editMember(array $params = [])
  {
    $id = $params['id'] ?? null;

    if (!$id) {
      header('location: /members');
      exit;
    }

    $database = \config\database::connect();
    $model    = new \models\member($database);

    $member = $model->find($id);

    if (!$member) {
      header('location: /members');
      exit;
    }

    $this->view->member = $member;
    $this->render('app/members/edit');
  }
}
