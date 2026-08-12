<?php 

    require_once '../config/database.php';
    require_once '../config/routes.php';

    use config\Database;
    use config\Routes;

    try {
        $db = Database::connect();
        $setup = Database::setup($db);
        $routes = new Routes();
    } catch(\Throwable $error) {
        echo $error->getMessage();
    }

?>