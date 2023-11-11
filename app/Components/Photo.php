<?php

namespace App\Components;

use Intervention\Image\ImageManagerStatic as Image;
use Storage;


/**
 * ImageManager
 */

class Photo
{
  private $database;
  private $imageManager;

  public function __construct(Database $database, ImageManager $imageManager)
  {
      $this->database = $database;
      $this->imageManager = $imageManager;
  }

  public function userPhotos()
  {
    $userId = auth()->getUserId();
    $select = $this->database->queryFactory->newSelect();
    $select
      ->cols(['*'])
      ->from('photos')
      ->where('user_id=:user_id')
      ->bindValue('user_id', $userId);

    $sth = $this->database->pdo->prepare($select->getStatement());

    $sth->execute($select->getBindValues());

    return $sth->fetchAll(\PDO::FETCH_ASSOC);
  }



  public function delete($id)
  {
    $photo = $this->database->readOne('photos', $id);

    if ($photo['user_id'] != auth()->getUserId()) {
      return 'Нельзя удалить не свои фотографии';
    }

    $this->imageManager->deleteImage($photo['image']);
    $this->database->delete('photos', 'id', $id);
    return 'Картинка удалена';

  }







}




?>
