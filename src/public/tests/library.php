<?php 

    require_once "../../config/database.php";
    require_once "../../config/utils.php";
    
    require_once "../../entities/library.php";
    require_once "../../models/library.php";

    $db = config\database::connect();
    $model = new models\library($db);

    $lib = $model->read('4a9de8c8-4a8a-428e-a7d3-3c23e99cabcb');

    echo '<pre>';
    print_r( $lib);
    echo '</pre>';

?>