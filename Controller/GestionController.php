<?php namespace Controller;
class GestionController {

  protected static $roles = array('Admin', 'Empleado');

  public function __construct() {
    if (!isset($_SESSION['account']))
      header('location: /'.BASE_URL);

    require_once 'AdminViews/GestionLobby.php';
    if (!in_array($_SESSION['role']->getRolename(), self::$roles)) {
      header('location: /'.BASE_URL.'PrivilegeError');
    }
  }

  public function Index() {}

  public function Submit($object = null) {
    require_once 'AdminViews/SubmitPackaging.php';
  }

  public function Update($object = null) {
    require_once 'AdminViews/UpdatePackaging.php';
  }

  public function Delete($object = null) {
    require_once 'AdminViews/DeletePackaging.php';
  }
} ?>
