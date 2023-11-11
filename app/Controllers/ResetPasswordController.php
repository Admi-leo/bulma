<?php

namespace App\Controllers;

use App\Components\Profile;

/**
 * ResetPasswordController
 */

class ResetPasswordController extends Controller
{
  private $profile;

  public function __construct(Profile $profile)
  {
     parent::__construct();
     $this->profile = $profile;
  }

  public function security()
  {
    echo $this->view->render('profile/security');
  }

  public function securityUpdate()
  {
    try {
        $this->auth->changePassword($_POST['currentPassword'], $_POST['newPassword']);
        $this->auth->logout();
        flash()->success('Пароль был изменен успешно');
        return redirect('/login');
    }
    catch (\Delight\Auth\NotLoggedInException $e) {
        flash()->error('Вы не вошли на сайт');
    }
    catch (\Delight\Auth\InvalidPasswordException $e) {
        flash()->error('Не верные пароли');
    }
    catch (\Delight\Auth\TooManyRequestsException $e) {
        flash()->error('Слишком много запросов');
    }
    return redirect('/profile/security');


  }
}



?>
