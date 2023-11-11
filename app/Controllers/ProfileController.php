<?php

namespace App\Controllers;

use App\Components\Profile;
use App\Components\ImageManager;

/**
 * ProfileController
 */

class ProfileController extends Controller
{
  protected $profile;
  protected $imageManager;
  public function __construct(Profile $profile, ImageManager $imageManager)
  {
    parent::__construct();
    $this->profile = $profile;
    $this->imageManager = $imageManager;
  }
  public function userPhotos()
  {
    ifnotIsLoggIn('/');

    $id = $this->auth->getUserId();
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $perPage = 8;

    $photos = $this->database->getPaginatedFrom('photos', 'user_id', $id, $page, $perPage);

    $paginator = paginate(
      $this->database->getCount('photos', 'user_id', $id),
      $page,
      $perPage,
      "/profile/photos?page=(:num)"
    );

    echo $this->view->render('/profile/photos', ['photos' => $photos, 'paginator' => $paginator]);
  }

  public function info()
  {
    ifnotIsLoggIn('/');

    $userId = auth()->getUserId();
    $info = $this->database->readOne('users', $userId);
    echo $this->view->render('profile/info', ['info' => $info]);
  }

  public function infoUpdate()
  {
    ifnotIsLoggIn('/');

    try {
        $this->profile->changeInformation($_POST['email'], $_POST['username'], $_FILES['image']);
        flash()->success(['Профиль обновлен']);
    }
    catch (\Delight\Auth\InvalidEmailException $e) {
        flash()->error(['Неверный формат эл. почты']);
        // invalid email address
    }
    catch (\Delight\Auth\UserAlreadyExistsException $e) {
        // email address already exists
        flash()->error(['Эл. почта уже существует']);
    }
    catch (\Delight\Auth\EmailNotVerifiedException $e) {
        // account not verified
        flash()->error(['Почта не подтверждена']);
    }
    catch (\Delight\Auth\NotLoggedInException $e) {
        // not logged in
        flash()->error(['Вы не вошли на сайт']);
    }
    catch (\Delight\Auth\TooManyRequestsException $e) {
        // too many requests
        flash()->error(['Слишком много попыток. Попробуйте позже..']);
    }
    return redirect('/profile/info');
  }

  public function defaultAvatar($id)
  {
    ifnotIsLoggIn('/');

    $file = "users/no-users.png";
    $user = $this->database->readOne('users', auth()->getUserId());
    $this->database->update('users', ['image' => $file], $id);
    $this->imageManager->deleteImage($user['image']);
    back();
  }
}



?>
