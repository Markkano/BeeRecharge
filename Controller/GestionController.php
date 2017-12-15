<?php namespace Controller;
class GestionController {

  protected static $roles = array('Admin', 'Empleado');

  public function __construct() {
    if (!isset($_SESSION['account']) || !isset($_SESSION['staff']))
      header('location: /'.BASE_URL);

    require_once 'AdminViews/GestionLobby.php';
    if (!in_array($_SESSION['role']->getRolename(), self::$roles)) {
      header('location: /'.BASE_URL.'PrivilegeError');
    }
  }

  public function Alert($msj, $alert) {
    include 'AdminViews/Alert.php';
  }

  public function Index() {}
} ?>
