<?php

namespace config;

use ArrayIterator;

class routes
{

  private array $routes;

  public function __construct()
  {
    $this->initRoutes();
    $this->run($this->getPath());
  }

  public function getRoutes()
  {
    return $this->routes;
  }

  public function setRoutes(array $routes)
  {
    return $this->routes = $routes;
  }

  public function initRoutes()
  {

    // views
    $routes['home'] = array(
      'route' => '/',
      'controller' => 'index',
      'action' => 'home'
    );

    $routes['dashboard'] = array(
      'route' => '/dashboard',
      'controller' => 'index',
      'action' => 'dashboard'
    );

    $routes['login'] = array(
      'route' => '/login',
      'controller' => 'index',
      'action' => 'login',
    );

    $routes['register'] = array(
      'route' => '/register',
      'controller' => 'index',
      'action' => 'register'
    );

    // auth
    $routes['auth_register'] = array(
      'route' => '/auth/register',
      'controller' => 'auth',
      'action' => 'register'
    );

    $routes['auth_login'] = array(
      'route' => '/auth/login',
      'controller' => 'auth',
      'action' => 'login'
    );

    $routes['auth_logout'] = array(
      'route' => '/auth/logout',
      'controller' => 'auth',
      'action' => 'logout'
    );

    $this->setRoutes($routes);
  }

  public function getPath()
  {
    return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  }

  public function run(string $path)
  {
    foreach ($this->getRoutes() as $key => $route) {
      if ($route['route'] === $path) {

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
