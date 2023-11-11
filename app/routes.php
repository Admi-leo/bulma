<?php

use DI\ContainerBuilder;
use League\Plates\Engine;
use Delight\Auth\Auth;
use Aura\SqlQuery\QueryFactory;
use FastRoute\RouteCollector;


$containerBuilder = new ContainerBuilder;
$containerBuilder->addDefinitions([
    Engine::class => function() {
        return new Engine('../app/Views');
    },
    PDO::class => function() {
        $driver = config('database.driver');
        $host = config('database.host');
        $database_name = config('database.database_name');
        $username = config('database.username');
        $password = config('database.password');

        return new PDO("$driver:host=$host;dbname=$database_name", $username, $password);
    },
    Auth::class => function($container) {
        return new Auth($container->get('PDO'));
    },
    QueryFactory::class => function() {
        return new QueryFactory('mysql');
    }
]);

$container = $containerBuilder->build();

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
  $r->get('/', ['App\Controllers\HomeController', 'home']);
  $r->get('/category/{id:\d+}', ['App\Controllers\HomeController', 'category']);
  $r->get('/user/{id:\d+}', ['App\Controllers\HomeController', 'user']);

  $r->get('/register', ['App\Controllers\RegisterController', 'registerForm']);
  $r->post('/register', ['App\Controllers\RegisterController', 'register']);

  $r->get('/login', ['App\Controllers\LoginController', 'loginForm']);
  $r->post('/login', ['App\Controllers\LoginController', 'login']);
  $r->get('/logout', ['App\Controllers\LoginController', 'logout']);

  $r->get('/profile/info', ['App\Controllers\ProfileController', 'info']);
  $r->post('/profile/info', ['App\Controllers\ProfileController', 'infoUpdate']);
  $r->get('/profile/info/default_avatar/{id}', ['App\Controllers\ProfileController', 'defaultAvatar']);
  $r->get('/profile/security', ['App\Controllers\ResetPasswordController', 'security']);
  $r->post('/profile/security', ['App\Controllers\ResetPasswordController', 'securityUpdate']);

  $r->get('/profile/photos', ['App\Controllers\ProfileController', 'userPhotos']);

  $r->get('/profile/upload/photo', ['App\Controllers\PhotoController', 'photoUploadForm']);
  $r->post('/profile/upload/photo', ['App\Controllers\PhotoController', 'photoUpload']);
  $r->get('/profile/photo/update/{id:\d+}', ['App\Controllers\PhotoController', 'updateForm']);
  $r->post('/profile/photo/update/{id:\d+}', ['App\Controllers\PhotoController', 'update']);


  $r->get('/photo/{id:\d+}', ['App\Controllers\PhotoController', 'photo']);
  $r->get('/photo/download/{id:\d+}', ['App\Controllers\PhotoController', 'download']);
  $r->get('/profile/photo/delete/{id:\d+}', ['App\Controllers\PhotoController', 'delete']);


  $r->addGroup('/admin', function (RouteCollector $r) {
    $r->get('', ['App\Controllers\Admin\HomeController', 'index']);
    $r->get('/photos', ['App\Controllers\Admin\PhotoController', 'photos']);
    $r->get('/photo/more/{id:\d+}', ['App\Controllers\Admin\PhotoController', 'more']);
    $r->get('/photo/create', ['App\Controllers\Admin\PhotoController', 'newPhotoForm']);
    $r->post('/photo/create', ['App\Controllers\Admin\PhotoController', 'newPhoto']);
    $r->get('/photo/edit/{id:\d+}', ['App\Controllers\Admin\PhotoController', 'newEditForm']);
    $r->post('/photo/edit/{id:\d+}', ['App\Controllers\Admin\PhotoController', 'newEdit']);
    $r->get('/photo/delete/{id:\d+}', ['App\Controllers\Admin\PhotoController', 'delete']);

    $r->get('/categories', ['App\Controllers\Admin\CategoriesController', 'categories']);
    $r->get('/category/create', ['App\Controllers\Admin\CategoriesController', 'newCategoryForm']);
    $r->post('/category/create', ['App\Controllers\Admin\CategoriesController', 'newCategory']);
    $r->get('/category/edit/{id:\d+}', ['App\Controllers\Admin\CategoriesController', 'newEditForm']);
    $r->post('/category/edit/{id:\d+}', ['App\Controllers\Admin\CategoriesController', 'newEdit']);
    $r->get('/category/delete/{id:\d+}', ['App\Controllers\Admin\CategoriesController', 'delete']);

    $r->get('/users', ['App\Controllers\Admin\UsersController', 'users']);
    $r->get('/user/create', ['App\Controllers\Admin\UsersController', 'newUserForm']);
    $r->post('/user/create', ['App\Controllers\Admin\UsersController', 'newUser']);
    $r->get('/user/update/{id:\d+}', ['App\Controllers\Admin\UsersController', 'newUpdateForm']);
    $r->post('/user/update/{id:\d+}', ['App\Controllers\Admin\UsersController', 'newUpdate']);
    $r->get('/user/info/{id:\d+}', ['App\Controllers\Admin\UsersController', 'info']);
    $r->get('/user/delete/{id:\d+}', ['App\Controllers\Admin\UsersController', 'delete']);
    $r->get('/user/status/{id:\d+}', ['App\Controllers\Admin\UsersController', 'status']);



  });


});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
  $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
  case FastRoute\Dispatcher::NOT_FOUND:
  abort(404);
  break;
case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
  $allowedMethods = $routeInfo[1];
  abort(405);
  break;
case FastRoute\Dispatcher::FOUND:
  $handler = $routeInfo[1];
  $vars = $routeInfo[2];
  $container->call($handler, $vars);
  break;
}

?>
