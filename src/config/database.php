<?php 

    namespace config;

    use PDO;
    use PDOException;

    class Database {

        public static function connect(): PDO|array {
            $db_host = 'mysql:host=mariadb;dbname=library;charset=utf8mb4';
            $db_user = getenv('DB_USER');
            $db_pass = getenv('DB_PASSWORD');
            $connection = new PDO($db_host, $db_user, $db_pass);
            return $connection;
        }

        public static function setup(PDO $database) {
            $database->exec('
            CREATE TABLE IF NOT EXISTS admin (
                id INT PRIMARY KEY AUTO_INCREMENT,
                username VARCHAR(50) UNIQUE NOT NULL,
                password VARCHAR(50) NOT NULL,
                role ENUM("admin", "moderator", "user") NOT NULL DEFAULT "user",
                is_active BOOLEAN DEFAULT FALSE
            );
        ');
        }

    }
?>