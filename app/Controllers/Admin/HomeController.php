<?php

namespace App\Controllers\Admin;

/**
 * HomeController
 */

class HomeController extends Controller
{
  public function index()
  {
    ifnotIsLoggIn('/');

    echo $this->view->render('Admin/index');
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
