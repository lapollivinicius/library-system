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

  private function getRoutes()
  {
    return $this->routes;
  }

  private function setRoutes(array $routes)
  {
    return $this->routes = $routes;
  }

  private function initRoutes()
  {

    // public
    $routes['home'] = array(
      'route' => '/',
      'method' => 'GET',
      'controller' => 'index',
      'middleware' => ['guest'],
      'action' => 'home'
    );
    $routes['login'] = array(
      'route' => '/login',
      'method' => 'GET',
      'controller' => 'index',
      'middleware' => ['guest'],
      'action' => 'login',
    );
    $routes['register'] = array(
      'route' => '/register',
      'method' => 'GET',
      'controller' => 'index',
      'middleware' => ['guest'],
      'action' => 'register'
    );
    $routes['recovery'] = array(
      'route' => '/recovery',
      'method' => 'GET',
      'controller' => 'index',
      'middleware' => ['guest'],
      'action' => 'recovery'
    );
    $routes['terms'] = array(
      'route' => '/terms',
      'method' => 'GET',
      'controller' => 'index',
      'middleware' => ['guest'],
      'action' => 'terms'
    );
    $routes['privacy'] = array(
      'route' => '/privacy',
      'method' => 'GET',
      'controller' => 'index',
      'middleware' => ['guest'],
      'action' => 'privacy'
    );
    $routes['demo'] = array(
      'route' => '/demo',
      'method' => 'GET',
      'controller' => 'index',
      'middleware' => ['guest'],
      'action' => 'demo'
    );

    // user 
    $routes['dashboard'] = array(
      'route' => '/dashboard',
      'method' => 'GET',
      'controller' => 'user',
      'middleware' => ['auth'],
      'action' => 'dashboard'
    );
    $routes['profile'] = array(
      'route' => '/profile',
      'method' => 'GET',
      'controller' => 'user',
      'middleware' => ['auth'],
      'action' => 'profile'
    );
    $routes['update_user'] = array(
      'route' => '/profile/update',
      'method' => 'POST',
      'controller' => 'user',
      'middleware' => ['auth', 'csrf'],
      'action' => 'updateUser'
    );
    $routes['delete_use'] = array(
      'route' => '/profile/delete',
      'method' => 'POST',
      'controller' => 'user',
      'middleware' => ['auth', 'csrf'],
      'action' => 'deleteUser'
    );

    // members
    $routes['members'] = array(
      'route' => '/members',
      'method' => 'GET',
      'controller' => 'member',
      'middleware' => ['auth'],
      'action' => 'index'
    );
    $routes['edit_member'] = array(
      'route' => '/members/edit/:code',
      'method' => 'GET',
      'controller' => 'member',
      'middleware' => ['auth'],
      'action' => 'edit'
    );
    $routes['add_member'] = array(
      'route' => '/members/create',
      'method' => 'POST',
      'controller' => 'member',
      'middleware' => ['auth', 'csrf'],
      'action' => 'addMember'
    );
    $routes['update_member'] = array(
      'route' => '/members/update/:code',
      'method' => 'POST',
      'controller' => 'member',
      'middleware' => ['auth', 'csrf'],
      'action' => 'updateMember'
    );
    $routes['delete_member'] = array(
      'route' => '/members/delete/:code',
      'method' => 'POST',
      'controller' => 'member',
      'middleware' => ['auth', 'csrf'],
      'action' => 'deleteMember'
    );
    $routes['json_members'] = array(
      'route' => '/members/json',
      'method' => 'GET',
      'controller' => 'member',
      'middleware' => [],
      'action' => 'listMembers'
    );

    // loans
    $routes['loans'] = array(
      'route' => '/loans',
      'method' => 'GET',
      'controller' => 'loan',
      'middleware' => ['auth'],
      'action' => 'index'
    );
    $routes['details_loan'] = array(
      'route' => '/loans/details/:code',
      'method' => 'GET',
      'controller' => 'loan',
      'middleware' => ['auth'],
      'action' => 'details'
    );
    $routes['add_loan'] = array(
      'route' => '/loans/create',
      'method' => 'POST',
      'controller' => 'loan',
      'middleware' => ['auth', 'csrf'],
      'action' => 'addLoan'
    );
    $routes['returned_book'] = array(
      'route' => '/loans/returned/:code',
      'method' => 'POST',
      'controller' => 'loan',
      'middleware' => ['auth', 'csrf'],
      'action' => 'returnLoan'
    );

    // books 
    $routes['books'] = array(
      'route' => '/books',
      'method' => 'GET',
      'controller' => 'book',
      'middleware' => ['auth'],
      'action' => 'index'
    );
    $routes['edit_book'] = array(
      'route' => '/books/edit/:code',
      'method' => 'GET',
      'controller' => 'book',
      'middleware' => ['auth'],
      'action' => 'edit'
    );
    $routes['add_book'] = array(
      'route' => '/books/create',
      'method' => 'POST',
      'controller' => 'book',
      'middleware' => ['auth', 'csrf'],
      'action' => 'addBook'
    );
    $routes['update_book'] = array(
      'route' => '/books/update/:code',
      'method' => 'POST',
      'controller' => 'book',
      'middleware' => ['auth', 'csrf'],
      'action' => 'updateBook'
    );
    $routes['delete_book'] = array(
      'route' => '/books/delete/:code',
      'method' => 'POST',
      'controller' => 'book',
      'middleware' => ['auth', 'csrf'],
      'action' => 'deleteBook'
    );
    $routes['json_books'] = array(
      'route' => '/books/json',
      'method' => 'GET',
      'controller' => 'book',
      'middleware' => [],
      'action' => 'listbooks'
    );

    // auth
    $routes['auth_register'] = array(
      'route' => '/auth/register',
      'method' => 'POST',
      'controller' => 'auth',
      'middleware' => ['csrf'],
      'action' => 'register'
    );
    $routes['auth_login'] = array(
      'route' => '/auth/login',
      'method' => 'POST',
      'controller' => 'auth',
      'middleware' => ['csrf'],
      'action' => 'login'
    );
    $routes['auth_logout'] = array(
      'route' => '/auth/logout',
      'method' => 'POST',
      'controller' => 'auth',
      'middleware' => ['csrf'],
      'action' => 'logout'
    );
    $routes['recovery_password'] = array(
      'route' => '/auth/recovery',
      'method' => 'POST',
      'controller' => 'auth',
      'middleware' => ['csrf'],
      'action' => 'recovery'
    );

    $this->setRoutes($routes);
  }

  private function getPath()
  {
    return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  }

  private function getMethod()
  {
    return $_SERVER['REQUEST_METHOD'];
  }

  private function matchRoute(string $route, string $path): array|false
  {
    $routeParts = explode('/', trim($route, '/'));
    $pathParts  = explode('/', trim($path, '/'));
    if (count($routeParts) !== count($pathParts)) {
      return false;
    }
    $params = [];
    foreach ($routeParts as $index => $routePart) {
      if (str_starts_with($routePart, ':')) {
        $paramName = substr($routePart, 1);
        $params[$paramName] = $pathParts[$index];
        continue;
      }
      if ($routePart !== $pathParts[$index]) {
        return false;
      }
    }
    return $params;
  }

  private function runMiddleware(array $middlewares)
  {
    foreach ($middlewares as $middleware) {
      if (!method_exists(
        \config\middleware::class,
        $middleware
      )) {
        throw new \Exception(
          "Middleware [$middleware] not found"
        );
      }
      \config\middleware::$middleware();
    }
  }

  private function run(string $path, string $method)
  {
    require_once __DIR__ . '/../controllers/controller.php';
    $route_found = false;
    foreach ($this->getRoutes() as $route) {
      $params = $this->matchRoute(
        $route['route'],
        $path
      );
      if ($params === false) {
        continue;
      }
      $route_found = true;
      if ($route['method'] !== $method) {
        exit('Method Not Allowed');
      }
      if (isset($route['middleware'])) {
        $this->runMiddleware(
          $route['middleware']
        );
      }
      require_once __DIR__ . '/../controllers/' . $route['controller'] . '.php';
      $class = 'controllers\\' . $route['controller'];
      $action = $route['action'];
      $controller = new $class();
      call_user_func_array(
        [$controller, $action],
        array_values([$params])
      );
      return;
    }
    if (!$route_found) {
      require_once __DIR__ . '/../controllers/index.php';
      $controller = new \controllers\index();
      $controller->notFound();
    }
  }
}
