<?php 

  namespace models;

  class users {

    protected PDO $database;

    public function __construct(PDO $database){
      $this->database = $database;
    }

    

  }
?>