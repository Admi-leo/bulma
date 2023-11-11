<?php

namespace App\Controllers\Admin;

use App\Components\Roles;
use App\Components\ImageManager;
use Respect\Validation\Exceptions\ValidationException;
use Respect\Validation\Validator as v;
use Delight\Auth\Status;

/**
 * UsersController
 */

class UsersController extends Controller
{
  protected $imageManager;

  public function __construct(imageManager $imageManager)
  {
    parent::__construct();
    $this->imageManager = $imageManager;
  }
  public function users()
  {
    ifnotIsLoggIn('/');

    $users = $this->database->readAll('users');

    echo $this->view->render('Admin/users/index', ['users' => $users]);
  }

  public function info($id)
  {
    ifnotIsLoggIn('/');

    $user = $this->database->readOne('users', $id);

    echo $this->view->render('Admin/users/info', ['user' => $user]);
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

  public function newUserForm()
  {
    ifnotIsLoggIn('/');
    $roles = Roles::getRoles();
    echo $this->view->render('Admin/users/create', ['roles' => $roles]);
  }
  public function newUser()
  {
    ifnotIsLoggIn('/');

    $validator = v::key('email', v::stringType()->notEmpty())
      ->key('first_name', v::stringType()->notEmpty())
      ->key('roles_mask', v::intVal());
      // ->keyNested('image.tmp_name', v::image());

    $this->validate($validator);

    if ($this->isNotPasswordAllowed($_POST['password'], $_POST['password2'])) {
      flash()->error(['Проблема в пароле']);
      return redirect('/admin/user/create');
    }

    try {
        $userId = $this->auth->admin()->createUser($_POST['email'], $_POST['password'], $_POST['first_name']);
        $user = $this->database->readOne('users', $userId);

        $data = [
          'status' => isset($_POST['status']) ? Status::BANNED : Status::NORMAL,
          'roles_mask' => $_POST['roles_mask'],
        ];

        $data['image'] = $this->imageManager->uploadImage($_FILES['image'], $user['image']);

        $this->database->update('users', $data, $userId);
        flash()->success("Пользователь <i>$_POST[first_name]</i> создан успешно.");
        return redirect('/admin/user/create');
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
    return redirect('/admin/user/create');
  }
  public function status($id)
  {
    $data = [
      'status' => $_GET['status']
    ];
    $this->database->update('users', $data, $id);
    redirect("/admin/users");
  }
  public function newUpdateForm($id)
  {
    ifnotIsLoggIn('/');

    $user = $this->database->readOne('users', $id);

    $roles = Roles::getRoles();

    echo $this->view->render('Admin/users/edit', ['user' => $user, 'roles' => $roles]);
  }
  public function newUpdate($id)
  {
    ifnotIsLoggIn('/');


    $validator = v::key('email', v::stringType()->notEmpty())
      ->key('first_name', v::stringType()->notEmpty())
      ->key('roles_mask', v::intVal());
      // ->keyNested('image.tmp_name', v::image());

    $this->validate($validator);

    $user = $this->database->readOne('users', $id);
    $image = $this->imageManager->uploadImage($_FILES['image'], 'users', $user['image']);

    $data = [
      'email' => $_POST['email'],
      'username' => $_POST['first_name'],
      'roles_mask' => $_POST['roles_mask'],
      'image' => $image,
      'status' => isset($_POST['status']) ? Status::BANNED : Status::NORMAL
    ];
    $update = $this->database->queryFactory->newUpdate();
    $update
      ->table('users')
      ->cols($data)
      ->where('id=:id')
      ->bindValue('id', $id);
    $sth = $this->database->pdo->prepare($update->getStatement());
    $sth->execute($update->getBindValues());

    flash()->success(['Инфо. о пользователе <i>' . $user['username'] . '</i> обновлена']);
    return back();
  }

  public function delete($id)
  {
    ifnotIsLoggIn('/');
    $user = $this->database->readOne('users', $id);
    if (config("info")['email'] == $user['email']) {
      flash()->error('Этого сделать невозможно');
      return redirect('/admin/users');
    } elseif ($this->auth->getUserId() == $id) {
      flash()->error('Нельзя удалить пользователя под которым был выполнен вход');
      return redirect('/admin/users');
    }

    $user = $this->database->readOne('users', $id);

    try {
        $this->auth->admin()->deleteUserById($id);
        $this->database->delete('photos', 'user_id', $id);
        flash()->warning("Пользователь под именем <i>$user[username]</i> удален");
        return redirect('/admin/users');
    }
    catch (\Delight\Auth\UnknownIdException $e) {
        flash()->error('Неизвестный пользователь');
    }
    return redirect('/admin/users');

  }



  private function validate($validator)
  {
    try {
      $validator->assert(array_merge($_POST, $_FILES));
    } catch (ValidationException $exception) {
      $exception->updateParams($this->getMessages());
      flash()->error($exception->getParams());

      return back();
    }
  }
  private function getMessages()
  {
    return [
      'email' => 'Введите email',
      'first_name' => 'Введите имя',
      'roles_mask' => 'Выберите роль',
      'image' => 'Не верный формат картинки'
    ];
  }

}



?>
