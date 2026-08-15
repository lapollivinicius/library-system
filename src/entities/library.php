<?php

    namespace entities;

    class library {

        private string $library_id;
        private string $name;
        private string $is_active;

        public function __construct(string $library_id, string $name, $is_active = true) {
            $this->library_id = $library_id;
            $this->name = $name;
            $this->is_active = $is_active;
        }

        public function __get(string $item) {
            return $this->$item;
        }

        public function __set(string $item, string $value) {
            return $this->$item = $value;
        }

        

    }