<?php

    namespace models\admin;

    use PDO;

    class Admin {

        protected PDO $database;

        public function __construct(PDO $database){
            $this->database = $database;
        }

        public function getUser($username) {

            $query = '
                SELECT *
                FROM admin
                WHERE username = :username
            ';

            $statement = $this->database->prepare($query);

            $statement->execute([
                'username' => $username
            ]);

            return $statement->fetch(PDO::FETCH_ASSOC);
        }
    }

?>