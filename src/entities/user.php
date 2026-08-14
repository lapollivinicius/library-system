<?php

    namespace entities;

    # '../config/utils.php'
    require_once '../../config/utils.php';

    class user {

        private $user_id;
        private $library_id;
        private $name;
        private $email;
        private $password;
        private $is_active;

        public function __construct($user_id, $library_id, $name, $email, $password, $is_active = true) {
            $this->user_id = $user_id;
            $this->library_id = $library_id;
            $this->name = $name;
            $this->email = $email;
            $this->password = $password;
            $this->is_active = $is_active;
        }

        public function __get($item) {
            return $this->$item;
        }

        public function __set($item, $value) {
            return $this->$item = $value;
        }

    }