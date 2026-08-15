<?php 

    namespace controllers;

    require_once '../validators/validators.php';
    require_once '../validators/register.php';
   
    class auth {

        public function register() {
            
            \config\middleware::csrf();

            $data = $_POST;

            $validate = new \validators\auth();

            $check = $validate->register($data);
            
            if(!$check) {
              $_SESSION['data'] = $data;
              $_SESSION['message'] = $validate->getError();
              header('location: /register');
              exit;
            }

            # user and library UUID
            $name = $data['name']; # to lower case
            $email = $data['email']; # to lower case
            $password = $data['password']; # hash to save
            $library_name = $data['library_name']; # to lower case

            echo '<pre>'; 
            print_r($data);
            echo '</pre>'; 

            # validator (check)
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