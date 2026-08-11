<?php 

    require_once __DIR__ . '/config.php';

    $db = loadDatabase();

    $query = '
        CREATE TABLE IF NOT EXISTS admin (
            id INT PRIMARY KEY UNIQUE AUTO_INCREMENT,
            username VARCHAR(50) UNIQUE,
            password VARCHAR(50),
            last_login TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
    ';

    $smtm = $db->exec($query);

    $query = '
        INSERT INTO admin (username, password)
        VALUES ("admin", "admin");
    ';

    $smtm = $db->exec($query);

    echo $smtm;

?>