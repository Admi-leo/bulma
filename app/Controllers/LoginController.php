<?php

namespace App\Controllers;

/**
 * LoginController
 */

class LoginController extends Controller
{

  public function loginForm()
  {
    ifIsLoggIn('/');

    echo $this->view->render('auth/login');
  }
  public function login()
  {
    ifIsLoggIn('/');

    if ($_POST['remember']) {
        // keep logged in for one year
        $rememberDuration = (int) (60 * 60 * 24 * 30);
    }
    else {
        // do not keep logged in after session ends
        $rememberDuration = null;
    }

    try {
        $this->auth->login($_POST['email'], $_POST['password'], $rememberDuration);
        return redirect('/');
    }
    catch (\Delight\Auth\InvalidEmailException $e) {
        flash()->error('Не верный почтовый адрес');
    }
    catch (\Delight\Auth\InvalidPasswordException $e) {
        flash()->error('Не верный пароль');
    }
    catch (\Delight\Auth\EmailNotVerifiedException $e) {
        flash()->error('Эл. почта не подтверждена');
    }
    catch (\Delight\Auth\TooManyRequestsException $e) {
        flash()->error('Слишком много попыток. Попробуйте поезже..');
    }
    return back();
  }

  public function logout()
  {
    if(!$this->auth->isLoggedIn())
    {
      flash()->message(['Вы не можете выйти, не войдя на сайт.<br>Войдите']);
      return redirect('/login');
    }
    $this->auth->logOut();
    return redirect('/');

  }

}



?>
