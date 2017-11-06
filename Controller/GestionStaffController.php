<?php namespace Controller;

use DAOS\StaffDAO as StaffDAO;
use Model\Staff as Staff;
use DAOS\RoleDAO as RoleDAO;
use Model\Role as Role;
use DAOS\AccountDAO as AccountDAO;
use Model\Account as Account;
use Controller\GestionController as GestionController;

class GestionStaffController extends GestionController implements IGestion {

  private $roleDAO;
  private $accountDAO;
  private $staffDAO;

  public function __construct() {
    self::$roles = array('Admin');
    $this->staffDAO = StaffDAO::getInstance();
    $this->roleDAO = RoleDAO::getInstance();
    $this->accountDAO = AccountDAO::getInstance();
    parent::__construct();
  }

  public function Index() {}

  public function Submit(
    $name = null, $surname = null, $dni = null, $address = null, $phone = null, $salary = null, $id_role = null, $id_account = null
  ) {
    $roles = $this->roleDAO->SelectAll();
    $accounts = $this->accountDAO->SelectAll();
    if (isset($name)) {
      try {
        $account = $this->accountDAO->SelectByID($id_account);
        $role = $this->roleDAO->SelectById($id_role);
        $aux = $this->staffDAO->SelectByAccount($account);
        if (isset($aux)) {
          throw new \Exception("Ya hay un Staff vinculado a la cuenta", 1);
        }
        # Si no se encontro otro staff, lo inserto en la BD.
        $staff = new Staff($name, $surname, $dni, $address, $phone, $salary, $account, $role);
        $staff = $this->staffDAO->Insert($staff);
        if (isset($staff)) {
          $alert = "green";
          $msj = "Staff añadido correctamente: ".$staff->getSurname().", ".$staff->getName();
        } else {
          $alert = "yellow";
          $msj = "Ocurrio un problema";
        }
      } catch (\Exception $e) {
        $alert = "yellow";
        $msj = $e->getMessage();
      }
    }
    require_once 'AdminViews/SubmitStaff.php';
  }

  public function Update($id_staff = null, $name = null, $surname = null, $dni = null, $address = null, $phone = null, $salary = null, $id_role = null, $id_account = null) {
    $roles = $this->roleDAO->SelectAll();
    $accounts = $this->accountDAO->SelectAll();
    if (isset($name)) {
      try {
        $account = $this->accountDAO->SelectByID($id_account);
        $role = $this->roleDAO->SelectById($id_role);
        $aux = $this->staffDAO->SelectByAccount($account);
        if (isset($aux) && ($aux->getId() != $id_staff)) {
          throw new \Exception("Ya hay un Staff vinculado a la cuenta", 1);
        }
        $staff = new Staff($name, $surname, $dni, $address, $phone, $salary, $account, $role);
        $staff->setId($id_staff);
        $staff = $this->staffDAO->Update($staff);
        if (isset($staff)) {
          $alert = "green";
          $msj = "Staff modificado correctamente: ".$staff->getSurname().", ".$staff->getName();
        } else {
          $alert = "yellow";
          $msj = "Ocurrio un problema";
        }
      } catch (\Exception $e) {
        $alert = "yellow";
        $msj = $e->getMessage();
      }
    }
    $list = $this->staffDAO->SelectAll();
    require_once 'AdminViews/UpdateStaff.php';
  }

  public function Delete($name = null, $id_staff = null) {
    /*
    Si recibo parametros, elimino el que tengo en la BD.
    */
    if (isset($name) && isset($id_staff)) {
      try {
        if ($this->staffDAO->DeleteById($id_staff)) {
          $alert = "green";
          $msj = "Staff eliminado: ".$name." (id ".$id_staff.")";
        } else {
          $alert = "yellow";
          $msj = "Ocurrio un problema";
        }
      } catch (\Exception $e) {
        $alert = "yellow";
        $msj = $e->getMessage();
      }
    }
    $list = $this->staffDAO->SelectAll();
    require_once 'AdminViews/DeleteStaff.php';
  }
}
