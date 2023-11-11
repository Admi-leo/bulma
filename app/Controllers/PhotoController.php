<?php

namespace App\Controllers;

use App\Components\ImageManager;
use App\Components\Photo;
use Respect\Validation\Exceptions\ValidationException;
use Respect\Validation\Validator as v;


/**
 * PhotoController
 */

class PhotoController extends Controller
{
  protected $imageManager;
  protected $photo;

  public function __construct(ImageManager $imageManager, Photo $photo)
  {
    parent::__construct();
    $this->imageManager = $imageManager;
    $this->photo = $photo;
  }

  public function photo($id)
  {
    $photo = $this->database->readOne('photos', $id);
    $user = $this->database->readOne('users', $photo['user_id']);
    $userImages = $this->database->whereAll('photos', $user['id'], 'user_id');

    echo $this->view->render('photos/photo', [
      'photo' => $photo,
      'user' => $user,
      'userImages' => $userImages,
    ]);
  }

  public function download($id)
  {
    $photo = $this->database->readOne('photos', $id);
    echo $this->view->render('photos/download', [
      'photo' => $photo
    ]);
  }

  public function updateForm($id)
  {
    ifnotIsLoggIn('/');

    $photo = $this->database->readOne('photos', $id);

    echo $this->view->render('photos/update', ['photo' => $photo]);
  }
  public function update($id)
  {
    ifnotIsLoggIn('/');

    $validator = v::key('title', v::stringType()->notEmpty())
      ->key('description', v::stringType()->notEmpty())
      ->keyNested('image.tmp_name', v::image())
      ->key('category_id', v::intVal());

    $this->validate($validator);
    $currentImage = $this->database->readOne('photos', $id);
    $image = $this->imageManager->uploadImage($_FILES['image'], 'photos', $currentImage['image']);
    $dimensions = $this->imageManager->getDimensions($image);

    $data = [
      'title' => $_POST['title'],
      'description' => $_POST['description'],
      'image' => $image,
      'dimensions' => $dimensions,
      'date' => time(),
      'category_id' => $_POST['category_id'],
      'user_id' => auth()->getUserId()
    ];

    $update = $this->database->queryFactory->newUpdate();
    $update
      ->table('photos')
      ->cols($data)
      ->where('id=:id')
      ->bindValue('id', $id);
    $sth = $this->database->pdo->prepare($update->getStatement());
    $sth->execute($update->getBindValues());

    flash()->success(['Картинка <i>' . $data['title'] . '</i> обновлена']);
    return redirect('/profile/photos');
  }

  public function photoUploadForm()
  {
    ifnotIsLoggIn('/');

    echo $this->view->render('profile/upload');
  }

  public function photoUpload()
  {
    ifnotIsLoggIn('/');

    $validator = v::key('title', v::stringType()->notEmpty())
      ->key('description', v::stringType()->notEmpty())
      ->keyNested('image.tmp_name', v::image())
      ->key('category_id', v::intVal());

    $this->validate($validator);

    $image = $this->imageManager->uploadImage($_FILES['image'], 'photos');
    $dimensions = $this->imageManager->getDimensions($image);

    $data = [
      'title' => $_POST['title'],
      'description' => $_POST['description'],
      'image' => $image,
      'dimensions' => $dimensions,
      'date' => time(),
      'category_id' => $_POST['category_id'],
      'user_id' => auth()->getUserId()
    ];

    $insert = $this->database->queryFactory->newInsert();
    $insert
      ->into('photos')
      ->cols($data);
    $sth = $this->database->pdo->prepare($insert->getStatement());
    $sth->execute($insert->getBindValues());

    flash()->success(['Картинка загружена']);
    return redirect('/profile/photos');
  }

  public function delete($id)
  {
    ifnotIsLoggIn('/');

    flash()->message($this->photo->delete($id));
    return redirect('/profile/photos');
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
      'title' => 'Введите название',
      'description' => 'Введите описание',
      'category_id' => 'Выберите категорию',
      'image' => 'Не верный формат картинки'
    ];
  }

}



?>
