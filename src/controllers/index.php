<?php 

    namespace controllers;

    class index {

        protected $view;
        
        public function __construct() {
            $this->view = new \stdClass();
        }

        public function home() { 
            $this->view->data = 'hello';
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

        public function render($view, $layout = 'layout') {
            $this->view->page = $view;
            require_once '../views/' . $layout . '.phtml';
        }

        public function content() {
            require_once '../views/index/' . $this->view->page . '.phtml';
        }
    }
?>