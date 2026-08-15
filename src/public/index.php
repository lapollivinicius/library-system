<?php 

    require_once '../config/middleware.php';
    require_once '../config/database.php';
    require_once '../config/routes.php';

    try {
        $db = config\database::connect();
        $setup = config\database::setup($db);
        $routes = new config\routes();
    } catch(\Throwable $error) {
        echo $error->getMessage();
    }

?>