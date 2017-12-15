<?php namespace Controller;

use DAOS\RoleDAO as RoleDAO;
use Model\Role as Role;
use Controller\GestionController as GestionController;

class GestionRoleController extends GestionController implements IGestion {

  private $roleDAO;

  public function __construct() {
    self::$roles = array('Admin');
    try {
      $this->roleDAO = RoleDAO::getInstance();
    } catch (\Exception $e) {
      $alert = "red";
      $msj = "Error: Ocurrio un problema al conectar con la Base de Datos";
    } finally {
      parent::__construct();
      if (isset($msj) && isset($alert)) {
        $this->Alert($msj, $alert);
        die();
      }
    }
  }

  public function Index() {}

  public function Submit() {
    require_once 'AdminViews/SubmitRole.php';
  }

  public function SubmitRole($rolename = null, $description = null) {
    if (isset($rolename) && isset($description)) {
      $role = new Role($rolename, $description);
      try {
        $role = $this->roleDAO->Insert($role);
        if (isset($role)) {
          $alert = "green";
          $msj = "Rol añadido correctamente: ".$role->getRolename();
          $this->Alert($msj, $alert);
        } else {
          // Tiro una Exception, luego la controlo y muestro una alerta
          throw new \Exception("", 1);
        }
      } catch (\PDOException $e) {
        $error = $e->errorInfo;
        $alert = "yellow";
        if ($error[1] == '1062') { //Entrada duplicada
          $msj = "Ya existe el Rol";
        } else {
          $msj = "Ocurrio un problema con la Base de Datos: error ".$error[1];
        }
        $this->Alert($msj, $alert);
      } catch (\Exception $e) {
        $alert = "yellow";
        $msj = "Ocurrio un problema";
        $this->Alert($msj, $alert);
      }
    }
    $this->Submit();
  }

  public function Update($id_role = null) {
    try {
      $list = $this->roleDAO->SelectAll();
    } catch (\Exception $e) {
      $alert = "red";
      $msj = "Ocurrio un problema al traer los Roles";
      $this->Alert($msj, $alert);
      $list = array();
    }
    require_once 'AdminViews/UpdateRole.php';
  }

  public function UpdateRole($id_role = null, $rolename = null, $description = null) {
    if (isset($id_role) && isset($rolename) && isset($description)) {
      $role = new Role($rolename, $description);
      $role->setId($id_role);
      try {
          $role = $this->roleDAO->Update($role);
          if (isset($role)) {
            $alert = "green";
            $msj = "Rol modificado correctamente: ".$role->getRolename();
            $this->Alert($msj, $alert);
          } else {
            // Tiro una Exception, luego la controlo y muestro una alerta
            throw new \Exception("", 1);
          }
      } catch (\Exception $e) {
        $alert = "yellow";
        $msj = "Ocurrio un problema";
        $this->Alert($msj, $alert);
      }
    }
    if (isset($role)) {
      $id_role = $role->getId();
    } else {
      $id_role = null;
    }
    $this->Update($id_role);
  }

  public function Delete() {
    try {
      $list = $this->roleDAO->SelectAll();
    } catch (\Exception $e) {
      $alert = "red";
      $msj = "Ocurrio un problema al traer los Roles";
      $this->Alert($msj, $alert);
      $list = array();
    }
    require_once 'AdminViews/DeleteRole.php';
  }

  public function DeleteRole($rolename = null, $id_role = null) {
    /*
    Si recibo parametros, elimino el que tengo en la BD.
    */
    if (isset($rolename) && isset($id_role)) {
      try {
        if ($this->roleDAO->DeleteById($id_role)) {
          $alert = "green";
          $msj = "Rol eliminado: ".$rolename." (id ".$id_role.")";
          $this->Alert($msj, $alert);
        } else {
          throw new \Exception("", 1);
        }
      } catch (\PDOException $e) {
        $error = $e->errorInfo;
        $alert = "yellow";
        if ($error[1] == '1451') {
          $msj = "No se pudo eliminar, el Rol esta asignado a un Staff";
        } else {
          $msj = "Ocurrio un problema con la Base de Datos: error ".$error[1];
        }
        $this->Alert($msj, $alert);
      } catch (\Exception $e) {
        $alert = "yellow";
        $msj = "Ocurrio un problema al eliminar el Rol";
        $this->Alert($msj, $alert);
      }
    }
    $this->Delete();
  }
}
