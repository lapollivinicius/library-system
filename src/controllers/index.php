<?php 

    namespace controllers;

use ArrayIterator;

    class index {

        protected \stdClass $view;

        public function __construct() {
            $this->view = new \stdClass();
        }

        public function home() { 
            $this->render('home');
        }

        public function dashboard() {
            $this->render('dashboard');
        }

        public function login() {
            $this->render('login');
        }

        public function register() {
            $csrf = \config\middleware::csrfToken();
            $this->view->csrf_token = $csrf;
            $this->render('register');
        }

        public function render(string $view, string $layout = 'layout') {
            $this->view->page = $view;
            require_once '../views/' . $layout . '.phtml';
        }

        public function content() {
            require_once '../views/index/' . $this->view->page . '.phtml';
        }
    }
?>