<?php 

    require_once '../config/database.php';
    require_once '../config/routes.php';

    use config\database;
    use config\routes;

    try {
        $db = database::connect();
        $setup = database::setup($db);
        $routes = new routes();
    } catch(\Throwable $error) {
        echo $error->getMessage();
    }

?>