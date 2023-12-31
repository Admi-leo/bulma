<?php

namespace App\Controllers\Admin;

use League\Plates\Engine;
use Delight\Auth\Auth;
use App\Components\Database;
use App\Components\Roles;

/**
 * Controller
 */
class Controller
{
  protected $view;
  protected $auth;
  protected $database;

  function __construct()
  {
    $this->view = components(Engine::class);
    $this->auth = components(Auth::class);
    $this->database = components(Database::class);
    
    $this->checkForAccess();
  }

  public function checkForAccess()
  {
    if($this->auth->hasRole(Roles::USER)) { return redirect('/'); }
  }

}



?>
