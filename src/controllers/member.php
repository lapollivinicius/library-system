<?php

namespace controllers;

require_once '../validators/validators.php';
require_once '../validators/member.php';
require_once '../config/utils.php';
require_once '../entities/member.php';
require_once '../models/member.php';

class member extends controller
{

  public function index()
  {
    $this->view->search = $this->searchMember();
    $this->render('app/members/members');
  }

  public function edit(array $params = [])
  {
    $code = $params['code'] ?? null;

    if (!$code) {
      header('location: /members');
      exit;
    }

    $database = \config\database::connect();
    $model    = new \models\member($database);

    $member = $model->read($this->user_id, $code);

    if (!$member) {
      header('location: /members');
      exit;
    }

    $this->view->member = $member;
    $this->render('app/members/edit');
  }

  public function searchMember() 
  {

    # name
    $name   = $_GET['name'] ?? '';
    $limit  = max(1, (int) ($_GET['limit'] ?? 7));
    $page   = max(1, (int) ($_GET['page']  ?? 1));
    $offset = ($page - 1) * $limit;
    $sort   = $_GET['sort'] ?? 'asc';
    $sort   = in_array(strtolower($sort), ['asc', 'desc'])
      ? strtolower($sort)
      : 'asc';
    
    # validate name ?

    $database = \config\database::connect();
    $model    = new \models\member($database);

    $members      = $model->search($this->user_id, $name, $limit, $offset, $sort);
    $totalMembers = $model->count($this->user_id, $name);
    $totalPages   = (int) ceil($totalMembers / $limit);

    return [
      'members' => $members,
      'totalMembers' => $totalMembers,
      'totalPages' => $totalPages,
      'sort' => $sort,
      'page' => $page,
      'limit' => $limit,
      'offset' => $offset
    ];
  }

  public function addMember() 
  {
    
    # task: add validate to data conflit 
    # name, email, phone, document
    $data = [
      'name' => $_POST['name'] ?? '',
      'email' => $_POST['email'] ?? '',
      'phone' => $_POST['phone'] ?? '',
      'document' => $_POST['document'] ?? ''
    ];

    $validate = new \validators\member();

    if (!$validate->member($data)) {
      $_SESSION['data'] = $data;
      $_SESSION['error'] = $validate->getError();
      header('location: /members');
      exit;
    };

    $database = \config\database::connect();
    $model = new \models\member($database);

    $memberFound = $model->find($this->user_id, $data);

    if($memberFound) {
      $_SESSION['data'] = [
        'name' => $memberFound->__get('name'),
        'email' => $memberFound->__get('email'),
        'phone' => $memberFound->__get('phone'),
        'document' => $memberFound->__get('document'),
      ];
      $_SESSION['error'] = 'Member already registed (check name or email)';
      header('location: /members');
      exit;
    }

    $member_id = \config\utils::UUID();
    $user_id = $this->user_id;
    $code = \config\utils::code('M');
    $name = strtolower($data['name']);
    $email = strtolower($data['email']);
    $phone = $data['phone'] ?? 0;
    $document = $data['document'] ?? 0;

    $member = new \entities\member(
      $member_id,
      $user_id,
      $code,
      $name,
      $email,
      $phone,
      $document,
      true
    );

    try {
      $model->create($member);
      $_SESSION['success'] = 'Member registed';
      header('location: /members');
      exit;
    } catch (\PDOException $error) {
      $_SESSION['error'] = 'DATABASE ERROR - SORRY :( <br> ERROR: ' . $error->getMessage();
      header('location: /members');
      exit;
    }

  }

  public function updateMember(array $params = []) 
  {

    # task: change validate redirect and msg
    # task: add validate to data conflit 
    # name, email, phone, document
    $code = $params['code'] ?? null;

    $database = \config\database::connect();
    $model = new \models\member($database);

    $member = $model->read($this->user_id, $code);

    if(!$member) {
      $_SESSION['error'] = 'The member was not registered';
      header('location: /members');
      exit;
    }

    $data = [
      'name' => $_POST['name'] ?? '',
      'email' => $_POST['email'] ?? '',
      'phone' => $_POST['phone'] ?? '',
      'document' => $_POST['document'] ?? ''
    ];

    $validate = new \validators\member();

    if (!$validate->member($data)) {
      $_SESSION['data'] = $data;
      $_SESSION['error'] = $validate->getError();
      header('location: /members/edit/' . $code);
      exit;
    };

    $member->__set('name', $data['name']);
    $member->__set('email', $data['email']);
    $member->__set('phone', $data['phone']);
    $member->__set('document', $data['document']);

    try {
      $model->update($this->user_id, $member);
      $_SESSION['success'] = 'The member was edited';
      header('location: /members');
      exit;
    } catch (\PDOException $error) {
      $_SESSION['error'] = 'DATABASE ERROR - SORRY :( <br> ERROR: ' . $error->getMessage();
      header('location: /members/edit/' . $code);
      exit;
    }

  }

  public function deleteMember(array $params = [])
  {

    $code = $params['code'] ?? null;

    if (!$code) {
      header('location: /members');
      exit;
    }

    $database = \config\database::connect();
    $model    = new \models\member($database);
    $member     = $model->read($this->user_id, $code);

    if (!$member) {
      $_SESSION['error'] = "The member doesn't exists";
      header('location: /members');
      exit;
    }

    $model->delete($this->user_id, $code);

    $_SESSION['success'] = 'The member was deleted';
    header('location: /members');
    exit;
  }

  public function listMembers()
  {
      $name    = $_GET['name'] ?? '';
      $limit   = max(1, (int) ($_GET['limit'] ?? 7));
      $user_id = $this->user_id ?? false;

      if(!$user_id) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'success' => false,
            'msg' => 'Unauthorized'
        ]);
        exit;
      }

      $database = \config\database::connect();
      $model    = new \models\member($database);
      $members  = $model->search(
          $user_id,
          $name,
          $limit,
          0,
          'asc'
      );

      $members = array_map(
          fn($member) => [
              'name' => $member->__get('name'),
              'email' => $member->__get('email')
          ],
          $members
      );
      
      header('Content-Type: application/json; charset=utf-8');
      echo json_encode([
          'success' => true,
          'member' => $members
      ]);
      exit;
  }

}
