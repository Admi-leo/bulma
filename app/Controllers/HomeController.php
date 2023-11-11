<?php

namespace App\Controllers;

/**
 * HomeController
 */

class HomeController extends Controller
{
  public function home()
  {
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $perPage = 12;

    $photos = $this->database->getAllPaginatedFrom('photos', $page, $perPage);

    $paginator = paginate(
      count($this->database->readAll('photos')),
      $page,
      $perPage,
      '/?page=(:num)'
    );

    echo $this->view->render('home', ['photos' => $photos, 'paginator' => $paginator]);
  }
  public function category($id)
  {
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $perPage = 12;

    $photos = $this->database->getPaginatedFrom('photos', 'category_id', $id, $page, $perPage);

    $paginator = paginate(
      $this->database->getCount('photos', 'category_id', $id),
      $page,
      $perPage,
      "/category/$id?page=(:num)"
    );

    $titleCategory = getItem('categories', $id);

    echo $this->view->render('category', ['title' => $titleCategory, 'photos' => $photos, 'paginator' => $paginator]);
  }

  public function user($id)
  {
    ifnotIsLoggIn('/');

    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $perPage = 8;

    $photos = $this->database->getPaginatedFrom('photos', 'user_id', $id, $page, $perPage);

    $countImg = $this->database->getCount('photos', 'user_id', $id);


    $paginator = paginate(
      $countImg,
      $page,
      $perPage,
      "/user/$id?page=(:num)"
    );

    // $countImg = count($this->database->whereAll('photos', $id, 'user_id', $limit = null));

    $user = $this->database->readOne('users', $id);

    echo $this->view->render('user', ['countImg' => $countImg, 'user' => $user, 'photos' => $photos, 'paginator' => $paginator]);

  }

}



?>
