<?php 

    function loadDatabase(): PDO {

        $dsn = 'mysql:host=mariadb;dbname=app;charset=utf8mb4';
        $db_user = 'root';
        $db_password = 'root';

        try {
            return new PDO($dsn, $db_user, $db_password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch(PDOException $error) {
            die($error->getMessage());
        };
    }

?>