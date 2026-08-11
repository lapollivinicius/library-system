<?php 

    class Admin {

        protected $username = NULL;
        protected $password = NULL;
        protected $last_login = '';

        public function __construct($username, $password) {
            $this->username = $username;
            $this->password = $password;
        }

        public function get() {
            return Array('username' => $this->username, 'password' => $this->password, 'last_login' => $this->last_login);
        }

    };

    $a = new Admin('JOHN', '123');
    echo '<pre>';
    print_r($a->get());
    echo '</pre>';

?>