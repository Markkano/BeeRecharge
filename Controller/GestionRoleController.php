<?php namespace Controller;

use DAOS\RoleDAO as RoleDAO;
use Model\Role as Role;
use Controller\GestionController as GestionController;

class GestionRoleController extends GestionController {

  public function __construct() {
    self::$roles = array('Admin');
    parent::__construct();
  }

  public function Index() {}

  public function SubmitRole($rolename = null, $description = null) {
    if (isset($rolename) && isset($description)) {
      $roleDAO = new RoleDAO();
      $role = new Role($rolename, $description);
      $roleDAO->Insert($role);
      $alert = "green";
      $msj = "Rol añadido correctamente: ".$rolename;
    }
    require 'AdminViews/SubmitRole.php';
  }

  public function UpdateRole($id_role = null, $rolename = null, $description = null) {
    $roleDAO = new RoleDAO();
    /*
    Si recibo parametros, creo el objeto Beer y actualizo el que tengo en la BD.
    */
    if (isset($rolename)) {
      $role = new Role($rolename, $description);
      $role->setId($id_role);
      $error = $roleDAO->Update($role);
      if (!isset($error)) {
        $alert = "green";
        $msj = "Rol modificado correctamente: ".$role->getRolename();
      } else {
        $alert = "yellow";
        $msj = "Ocurrio un problema: ".$error;
      }
    }
    $list = $roleDAO->SelectAll();
    require 'AdminViews/UpdateRole.php';
  }

  public function DeleteRole($rolename = null, $id_role = null) {
    $roleDAO = new RoleDAO();
    /*
    Si recibo parametros, elimino el que tengo en la BD.
    */
    if (isset($rolename)) {
      $error = $roleDAO->DeleteById($id_role);
      if (!isset($error)) {
        $alert = "green";
        $msj = "Rol eliminado: ".$rolename." (id ".$id_role.")";
      } else {
        $alert = "yellow";
        $msj = "Ocurrio un problema: ".$error;
      }
    }
    $list = $roleDAO->SelectAll();
    require 'AdminViews/DeleteRole.php';
  }
}
