<?php 

    namespace config;

    class routes {

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

            // views
            $routes['home'] = Array(
                'route' => '/',
                'controller' => 'index',
                'action' => 'home',
                'middleware' => ['auth'],
            );

            $routes['dashboard'] = Array(
                'route' => '/dashboard',
                'controller' => 'index',
                'action' => 'dashboard',
                'middleware' => ['auth'],
            );

            $routes['login'] = Array(
                'route' => '/login',
                'controller' => 'index',
                'action' => 'login',
            );

            $routes['register'] = Array(
                'route' => '/register',
                'controller' => 'index',
                'action' => 'register'
            );

            // auth
            $routes['auth_register'] = Array(
                'route' => '/auth/register',
                'controller' => 'auth',
                'action' => 'register',
                'middleware' => ['crsf']
            );

            $routes['auth_login'] = Array(
                'route' => '/auth/login',
                'controller' => 'auth',
                'action' => 'login',
                'middleware' => ['crsf']
            );

            $routes['auth_logout'] = Array(
                'route' => '/auth/logout',
                'controller' => 'auth',
                'action' => 'logout',
                'middleware' => ['crsf']
            );

            $this->setRoutes($routes);
        }

        public function getPath() {
            return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        }

        public function run($path) {
            foreach($this->getRoutes() as $key => $route) {
                if($route['route'] === $path) {


                    # run route with path
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