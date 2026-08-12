<?php 

    namespace config;

    class Routes {

        private $routes;

        public function __construct() {
            $this->initRoutes();
            $this->run($this->getPath());
        }

        public function getRoutes() {
            return $this->routes;
        }

        public function setRoutes(Array $routes) {
            return $this->routes = $routes;
        }

        public function initRoutes() {

            $routes['home'] = Array(
                'route' => '/',
                'controller' => 'index',
                'action' => 'home'
            );
            $routes['dashboard'] = Array(
                'route' => '/dashboard',
                'controller' => 'index',
                'action' => 'dashboard'
            );

            $this->setRoutes($routes);
        }

        public function getPath() {
            return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        }

        public function run($path) {

            foreach($this->getRoutes() as $key => $route) {
                if($route['route'] === $path) {
                    require_once __DIR__ . '/../controllers/' . $route['controller'] . '.php';
                    $class = 'controllers\\' . $route['controller'];
                    $action = $route['action'];
                    $controller = new $class();
                    $controller->$action();
                }
            }
        }


    }


?>