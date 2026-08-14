<?php 

    require_once "../../config/database.php";
    require_once "../../config/utils.php";
    require_once "../../entities/library.php";
    require_once "../../models/library.php";

    $db = config\database::connect();
    $id = config\utils::UUID();
    $model = new models\library($db);

    echo '<pre>';
    print_r($lib->__get('name'));
    echo '</pre>';

?>