<?php

namespace App\Components;

use Delight\Auth\Auth;

class Profile
{
    private $auth;
    private $database;
    private $imageManager;

    public function __construct(Auth $auth, Database $database, ImageManager $imageManager)
    {
        $this->auth = $auth;
        $this->database = $database;
        $this->imageManager = $imageManager;
    }

    public function changeInformation($newEmail, $newUsername = null, $newImage)
    {
        if($this->auth->getEmail() != $newEmail) {
            $this->auth->changeEmail($newEmail, function ($selector, $token) use ($newEmail) {
              $this->auth->confirmEmail($selector, $token);
            });
        }

        $user = $this->database->readOne('users', $this->auth->getUserId());

        $image = $this->imageManager->uploadImage($newImage, 'users', $user['image']);

        $data = [
          'username' => isset($newUsername) ? $newUsername : $this->auth->getUsername(),
          "image" => $image
        ];

        $this->database->update('users', $data, $this->auth->getUserId());
    }

    public function passwordReset($email, $selector, $token)
    {
      try {
            $this->auth->resetPassword($selector, $token, $_POST['password']);

            flash()->success(['Пароль успешно изменен.']);
            return redirect('/login');
        }
        catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
            flash()->error(['Неверный токен']);
        }
        catch (\Delight\Auth\TokenExpiredException $e) {
            flash()->error(['Токен просрочен']);
        }
        catch (\Delight\Auth\ResetDisabledException $e) {
            flash()->error(['Изменение пароля отключено пользователем']);
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            flash()->error(['Введите пароль']);
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            flash()->error(['Превышен лимит.']);
        }

        return back();
    }
}
