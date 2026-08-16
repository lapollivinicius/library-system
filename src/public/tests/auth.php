<?php 

  require_once "../../repository/users.php";
  require_once "../../config/database.php";
  require_once "../../models/users.php";

  try {

    $db = config\database::connect();
    $users = new repository\users($db);
    $user = new models\users();

    $user->createUser(
      'john',
      'johndoe123',
      '12345',
      'johndoe123@email.com',
      '00 0000 0000',
      '000.000.000-00'
    );

    $user = $users->registerUser($user);

    echo '<pre>';
    print_r($user);
    echo '</pre>';
    
  } catch(\Throwable $error) {
    echo $error->getMessage();
  }

?>