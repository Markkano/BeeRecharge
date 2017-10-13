<?php namespace Controller;

use DAOS\RoleDAO as RoleDAO;
use Model\Role as Role;

class GestionRoleController {

  public function __construct() {
    require 'AdminViews/GestionLobby.php';
  }

  public function Index() {}

  public function SubmitStaff($object = null) {
    require 'AdminViews/SubmitPackaging.php';
  }

  public function UpdateStaff($object = null) {
    require 'AdminViews/UpdatePackaging.php';
  }

  public function DeleteStaff($object = null) {
    require 'AdminViews/DeletePackaging.php';
  }
}
