<?php 

    require_once "../../config/database.php";
    require_once "../../config/utils.php";
    require_once "../../entities/user.php";
    require_once "../../models/user.php";

    $db = \config\database::connect();
    $model = new \models\user($db);
    $id = config\utils::UUID();

    $user = $model->read("johndoe@gmail.com");

    echo '<pre>';
    print_r($user);
    echo '</pre>';


?>