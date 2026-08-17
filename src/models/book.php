<?php

namespace models;

use PDO;

class book
{

  protected PDO $database;

  public function __construct(PDO $database)
  {
    $this->database = $database;
  }

  # crud 

  
}
