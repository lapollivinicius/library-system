<?php

namespace models;

use PDO;

class user
{

  protected PDO $database;

  public function __construct(PDO $database)
  {
    $this->database = $database;
  }

  # crud 


}
