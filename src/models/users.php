<?php 

  namespace models;

  class users {

    private $id;
    private $name;
    private $username;
    private $password;
    private $role;
    private $email;
    private $phone;
    private $document;
    private $is_active;

    public function createUser($name, $username, $password, $email, $phone, $document) {
      $this->name = $name;
      $this->username = $username;
      $this->password = $password;
      $this->email = $email;
      $this->phone = $phone;
      $this->document = $document;
      $this->role = 'user';
      $this->is_active = true;
      return $this;
    }

    public function __get($item) {
      return $this->$item;
    }

    public function __set($item, $value) {
      return $this->$item = $value;
    }

  }
?>