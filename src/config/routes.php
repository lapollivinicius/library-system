<?php

namespace config;

use ArrayIterator;

class routes
{

  private array $routes;

  public function __construct()
  {
    $this->initRoutes();
    $this->run(
      $this->getPath(),
      $this->getMethod()
    );
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

    // public views
    $routes['home'] = array(
      'route' => '/',
      'method' => 'GET',
      'controller' => 'index',
      'action' => 'home'
    );
    $routes['login'] = array(
      'route' => '/login',
      'method' => 'GET',
      'controller' => 'index',
      'action' => 'login',
    );
    $routes['register'] = array(
      'route' => '/register',
      'method' => 'GET',
      'controller' => 'index',
      'action' => 'register'
    );
    $routes['terms'] = array(
      'route' => '/terms',
      'method' => 'GET',
      'controller' => 'index',
      'action' => 'terms'
    );
    $routes['privacy'] = array(
      'route' => '/privacy',
      'method' => 'GET',
      'controller' => 'index',
      'action' => 'privacy'
    );

    // app view
    $routes['dashboard'] = array(
      'route' => '/dashboard',
      'method' => 'GET',
      'controller' => 'index',
      'action' => 'dashboard'
    );
    $routes['books'] = array(
      'route' => '/books',
      'method' => 'GET',
      'controller' => 'index',
      'action' => 'books'
    );
    $routes['clients'] = array(
      'route' => '/clients',
      'method' => 'GET',
      'controller' => 'index',
      'action' => 'clients'
    );
    $routes['loans'] = array(
      'route' => '/loans',
      'method' => 'GET',
      'controller' => 'index',
      'action' => 'loans'
    );
    $routes['profile'] = array(
      'route' => '/profile',
      'method' => 'GET',
      'controller' => 'index',
      'action' => 'profile'
    );

    // auth
    $routes['auth_register'] = array(
      'route' => '/auth/register',
      'method' => 'POST',
      'controller' => 'auth',
      'action' => 'register'
    );
    $routes['auth_login'] = array(
      'route' => '/auth/login',
      'method' => 'POST',
      'controller' => 'auth',
      'action' => 'login'
    );
    $routes['auth_logout'] = array(
      'route' => '/auth/logout',
      'method' => 'POST',
      'controller' => 'auth',
      'action' => 'logout'
    );

    $this->setRoutes($routes);
  }

  public function getPath()
  {
    return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  }

  public function getMethod()
  {
    return $_SERVER['REQUEST_METHOD'];
  }

  public function run(string $path, string $method)
  {
    $route_found = false;

    foreach ($this->getRoutes() as $key => $route) {

      if ($route['route'] !== $path) {
        continue;
      }

      $routeFound = true;

      if ($route['method'] !== $method) {
        exit('Method Not Allowed');
      }

      require_once __DIR__ . '/../controllers/' . $route['controller'] . '.php';
      $class = 'controllers\\' . $route['controller'];
      $action = $route['action'];
      $controller = new $class();
      $controller->$action();

      return;
    }

    if (!$route_found) {
      require_once __DIR__ . '/../controllers/index.php';
      $controller = new \controllers\index();
      $controller->notFound();
    }
  }
}
