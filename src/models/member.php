<?php

namespace models;

use PDO;

class member
{

  protected PDO $database;

  public function __construct(PDO $database)
  {
    $this->database = $database;
  }

  # crud 


}
