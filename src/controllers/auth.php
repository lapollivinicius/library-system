<?php 

    namespace controllers;

    class auth {

        public function register() {
            echo '<pre>'; 
            print_r($_POST);
            echo '</pre>'; 

            # validator
            # create library and save
            # create user and save
        }

        public function login() { 
            echo 'login';
        }

        public function logout() { 
            echo 'logout';
        }
    }
?>