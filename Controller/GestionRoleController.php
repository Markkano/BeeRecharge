<?php namespace Controller;

use DAOS\RoleDAO as RoleDAO;
use Model\Role as Role;
use Controller\GestionController as GestionController;

class GestionRoleController extends GestionController {

  private $roleDAO;

  public function __construct() {
    self::$roles = array('Admin');
    $this->roleDAO = new RoleDAO();
    parent::__construct();
  }

  public function Index() {}

  public function SubmitRole($rolename = null, $description = null) {
    if (isset($rolename) && isset($description)) {
      $role = new Role($rolename, $description);
      $error = $this->roleDAO->Insert($role);
      if (!isset($error)) {
        $alert = "green";
        $msj = "Rol añadido correctamente: ".$rolename;
      } else {
        $alert = "yellow";
        $msj = "Ocurrio un problema";
      }
    }
    require 'AdminViews/SubmitRole.php';
  }

  public function UpdateRole($id_role = null, $rolename = null, $description = null) {
    /*
    Si recibo parametros, creo el objeto Beer y actualizo el que tengo en la BD.
    */
    if (isset($rolename)) {
      $role = new Role($rolename, $description);
      $role->setId($id_role);
      $error = $this->roleDAO->Update($role);
      if (!isset($error)) {
        $alert = "green";
        $msj = "Rol modificado correctamente: ".$role->getRolename();
      } else {
        $alert = "yellow";
        $msj = "Ocurrio un problema";
      }
    }
    $list = $this->roleDAO->SelectAll();
    require 'AdminViews/UpdateRole.php';
  }

  public function DeleteRole($rolename = null, $id_role = null) {
    /*
    Si recibo parametros, elimino el que tengo en la BD.
    */
    if (isset($rolename)) {
      $error = $this->roleDAO->DeleteById($id_role);
      if (!isset($error)) {
        $alert = "green";
        $msj = "Rol eliminado: ".$rolename." (id ".$id_role.")";
      } else {
        $alert = "yellow";
        $msj = "Ocurrio un problema";
      }
    }
    $list = $this->roleDAO->SelectAll();
    require 'AdminViews/DeleteRole.php';
  }
}
