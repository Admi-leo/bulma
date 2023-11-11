<?php

namespace App\Controllers;

use App\Components\Roles;

/**
 * RegisterController
 */

class RegisterController extends Controller
{

  public function registerForm()
  {
    ifIsLoggIn('/');

    echo $this->view->render('auth/register');
  }

  function isNotPasswordAllowed($password, $password2) {
      if (strlen($password) < 8) {
          return true;
      }

      $blacklist = [ 'password1', '12345678', 'qwerty', '87654321', $password];

      // if (in_array($password, $blacklist)) {
      //     return true;
      // }

      if ($password != $password2) {
          return true;
      }

      return false;
  }

  public function register()
  {
    ifIsLoggIn('/');

    if ($this->isNotPasswordAllowed($_POST['password'], $_POST['password2'])) {
      flash()->error(['Проблема в пароле']);
      return redirect('/register');
    }
    try {
        $userId = $this->auth->register($_POST['email'], $_POST['password'], $_POST['first_name'], function ($selector, $token) {
          $this->auth->confirmEmail($selector, $token);
        });
        $this->database->update('users', ['roles_mask' => Roles::USER], $userId);
        flash()->success(['Вы успешно зарегистрированы.']);
        return redirect('/login');
    }
    catch (\Delight\Auth\InvalidEmailException $e) {
        flash()->error('Не верный почтовый адрес');
    }
    catch (\Delight\Auth\InvalidPasswordException $e) {
        flash()->error('Не верный пароль');
    }
    catch (\Delight\Auth\UserAlreadyExistsException $e) {
        flash()->error('Такой пользователь уже существует');
    }
    catch (\Delight\Auth\TooManyRequestsException $e) {
        flash()->error('Слишком много попыток. Попробуйте позже');
    }
    return redirect('/register');
  }

}



?>
