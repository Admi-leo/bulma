<?php

namespace App\Controllers\Admin;

/**
 * CategoriesController
 */

class CategoriesController extends Controller
{
  public function categories()
  {
    ifnotIsLoggIn('/');

    $categories = $this->database->readAll('categories');

    echo $this->view->render('Admin/categories/index', ['categories' => $categories]);
  }
  public function newCategoryForm()
  {
    ifnotIsLoggIn('/');

    echo $this->view->render('Admin/categories/create');
  }
  public function newCategory()
  {
    ifnotIsLoggIn('/');

    $titles = $this->database->readAll('categories');

    if (strlen($_POST['title']) < 2) {
      flash()->error('Введите название');
      return back();
    }

    $data = ['title' => $_POST['title']];

    $this->database->create('categories', $data);
    flash()->success("Категория <u>$data[title]</u> добавлена");
    return back();exit;
  }
  public function newEditForm($id)
  {
    ifnotIsLoggIn('/');

    $category = $this->database->readOne('categories', $id);

    echo $this->view->render('Admin/categories/edit', ['category' => $category]);
  }
  public function newEdit($id)
  {
    ifnotIsLoggIn('/');

    if (strlen($_POST['title']) < 2) {
      flash()->error('Введите название');
      return back();
    }

    $oldCategory = $this->database->readOne('categories', $id);

    $data = ['title' => $_POST['title']];

    $this->database->update('categories', $data, $id);
    flash()->success("Категория <u>$oldCategory[title]</u> изменена на <u>$_POST[title]</u>");
    return back();exit;
  }



  public function delete($id)
  {
    ifnotIsLoggIn('/');

    $title = $this->database->readOne('categories', $id);

    $photos = $this->database->whereAll('photos', $id, 'category_id', $limit = null);
    if ($photos) {
      flash()->message("Нельзя удалить категорию <u>$title[title]</u>. Сначала удалите все картинки");
      return redirect('/admin/categories');
    }

    $this->database->delete('categories', 'id', $id);
    flash()->warning("Категория <u>$title[title]</u> удалена");
    return back();
  }

}



?>
