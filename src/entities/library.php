<?php

    namespace entities;

    # '../config/utils.php'
    require_once '../../config/utils.php';

    class library {

        private $library_id;
        private $name;
        private $is_active;

        public function __construct(string $library_id, string $name, $is_active = true) {
            $this->library_id = $library_id;
            $this->name = $name;
            $this->is_active = $is_active;
        }

        public function __get($item) {
            return $this->$item;
        }

        public function __set($item, $value) {
            return $this->$item = $value;
        }

        

    }