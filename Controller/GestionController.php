<?php namespace Controller;
class GestionController {

  protected static $roles = array('Admin', 'Empleado');

  public function __construct() {
    if (!isset($_SESSION['account']))
      header('location: /');

    require 'AdminViews/GestionLobby.php';
    if (!in_array($_SESSION['role']->getRolename(), self::$roles)) {
      header('location: /PrivilegeError');
    }
  }

  public function Index() {}

  public function SubmitRole($object = null) {
    require 'AdminViews/SubmitPackaging.php';
  }

  public function UpdateRole($object = null) {
    require 'AdminViews/UpdatePackaging.php';
  }

  public function DeleteRole($object = null) {
    require 'AdminViews/DeletePackaging.php';
  }
} ?>
