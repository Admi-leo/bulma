<?php

use Illuminate\Support\Arr;
use App\Components\Roles;
use App\Components\Database;
use Delight\Auth\Auth;
use JasonGrimes\Paginator;


function config($field)
{
  $config = require '../app/config.php';
  return arr::get($config, $field);
}

function components($name)
{
  global $container;
  return $container->get($name);
}

function back()
{
  header("Location: ". $_SERVER['HTTP_REFERER']);
  exit;
}

function redirect($path)
{
  header("Location: $path");
  exit;
}

function abort($type)
{
  $view = components(League\Plates\Engine::class);
  switch ($type) {
    case 404:
      echo $view->render('errors/404');exit;
      break;
    case 405:
      echo $view->render('errors/405');exit;
      break;
  }
}

function getItems($table)
{
  global $container;
  $queryFactory = $container->get('Aura\SqlQuery\QueryFactory');
  $pdo = $container->get('PDO');
  $database = new Database($pdo, $queryFactory);
  return $database->readAll($table);
}
function getItem($table, $key)
{
  global $container;
  $queryFactory = $container->get('Aura\SqlQuery\QueryFactory');
  $pdo = $container->get('PDO');
  $database = new Database($pdo, $queryFactory);
  return $database->readOne($table, $key);
}

function auth()
{
  global $container;
  return $container->get(Auth::class);
}
function database()
{
  global $container;
  return $container->get(Database::class);
}

function getImage($image, $pers)
{
  return (new \App\Components\ImageManager())->getImage($image, $pers);
}

function uploadedDate($timestamp)
{
  return date('d.m.Y', $timestamp);
}
function ifIsLoggIn($path)
{
  if(auth()->isLoggedIn()) { redirect($path);exit; }
}
function ifnotIsLoggIn($path)
{
  if(!auth()->isLoggedIn()) { redirect($path);exit; }
}


function paginate($count, $page, $perPage, $url)
{
  $totalItems = $count;
  $itemsPerPage = $perPage;
  $currentPage = $page;
  $urlPattern = $url;

  $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);
  return $paginator;
}

function paginator($paginator)
{
  include config('views_path') . 'blocks/pagination.php';
}

function getRole($key)
{
  return Roles::getRole($key);
}

// Show size a file
function getFileSize($file)
{
  if(!file_exists($file)) return "Файл не найден";
  $filesize = filesize($file);
  if ($filesize > 1024) {
    $filesize /= 1024;
    if ($filesize > 1024) {
      $filesize /= 1024;
      if ($filesize > 1024) {
        $filesize /= 1024;
        return round($filesize, 1)." GB";
      } else {
        return round($filesize, 1)." MB";
      }
    } else {
      return round($filesize, 1)." KB";
    }
  } else {
    return round($filesize, 1)." bytes";
  }
}


?>
