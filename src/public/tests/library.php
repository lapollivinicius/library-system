<?php 

    require_once "../../config/database.php";
    require_once "../../config/utils.php";
    require_once "../../entities/library.php";
    require_once "../../models/library.php";

    $db = config\database::connect();
    $id = config\utils::UUID();
    $model = new models\library($db);

    $lib = $model->get('23290ec5-8520-4338-a2cb-823a01866712');

    $lib->__set('name', 'LIBRARY TOWN III');

    $model->update($lib);

    echo '<pre>';
    print_r($lib->__get('name'));
    echo '</pre>';

?>