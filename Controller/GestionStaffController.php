<?php namespace Controller;

use DAOS\StaffDAO as StaffDAO;
use Model\Staff as Staff;
use DAOS\RoleDAO as RoleDAO;
use Model\Role as Role;
use DAOS\AccountDAO as AccountDAO;
use Model\Account as Account;
use Controller\GestionController as GestionController;

class GestionStaffController extends GestionController {

  public function __construct() {
    self::$roles = array('Admin');
    parent::__construct();
  }

  public function Index() {}

  public function SubmitStaff(
    $name = null, $surname = null, $dni = null, $address = null, $phone = null, $salary = null, $id_role = null, $id_account = null
  ) {
    //echo "name:".$name."-surname:".$surname."-dni:".$dni."-address:".$address."-phone".$phone."-salary".$salary."-id_role".$id_role."-id_account".$id_account;
    $staffDAO = new StaffDAO();
    $roleDAO = new RoleDAO();
    $accountDAO = new AccountDAO();
    $roles = $roleDAO->SelectAll();
    $accounts = $accountDAO->SelectAll();
    /*
    Si tengo parametros
    */
    if (isset($name)) {
      /*
      Traigo las entidades necesarias
      */
      $account = $accountDAO->SelectByID($id_account);
      $role = $roleDAO->SelectById($id_role);
      $aux = $staffDAO->SelectByAccount($account);
      if (isset($aux)) {
        # Ya hay un staff vinculado a la account
        $alert = "yellow";
        $msj = "Ya hay un Staff vinculado a la Cuenta";
      } else {
        # Si no se encontro otro staff, lo inserto en la BD.
        $staff = new Staff($name, $surname, $dni, $address, $phone, $salary, $account, $role);
        $error = $staffDAO->Insert($staff);
        if (!isset($error)) {
          $alert = "green";
          $msj = "Staff añadido correctamente: ".$staff->getSurname().", ".$staff->getName();
        } else {
          $alert = "yellow";
          $msj = "Ocurrio un problema: ".$error;
        }
      }
    }
    require 'AdminViews/SubmitStaff.php';
  }

  public function UpdateStaff($id_staff = null, $name = null, $surname = null, $dni = null, $address = null, $phone = null, $salary = null, $id_role = null, $id_account = null) {
    //echo "id_staff:".$id_staff."-name:".$name."-surname:".$surname."-dni:".$dni."-address:".$address."-phone".$phone."-salary".$salary."-id_role".$id_role."-id_account".$id_account;
    $staffDAO = new StaffDAO();
    $roleDAO = new RoleDAO();
    $accountDAO = new AccountDAO();
    $roles = $roleDAO->SelectAll();
    $accounts = $accountDAO->SelectAll();
    /*
    Si tengo parametros
    */
    if (isset($name)) {
      /*
      Traigo las entidades necesarias
      */
      $account = $accountDAO->SelectByID($id_account);
      $role = $roleDAO->SelectById($id_role);
      $aux = $staffDAO->SelectByAccount($account);
      /*
      Si esta seteado aux quiere decir que se encontro un staff para la Cuenta.
      Si tiene id diferente que el que estamos editando, quiere decir que no se
      le puede asignar la cuenta.
      */
      if (isset($aux) && ($aux->getId() != $id_staff)) {
        # Ya hay un staff vinculado a la account
        $alert = "yellow";
        $msj = "Ya hay un Staff vinculado a la Cuenta";
      } else { #Si no se encontro otro staff, o es el mismo que tenemos podemos continuar
        $staff = new Staff($name, $surname, $dni, $address, $phone, $salary, $account, $role);
        $staff->setId($id_staff);
        $error = $staffDAO->Update($staff);
        if (!isset($error)) {
          $alert = "green";
          $msj = "Staff modificado correctamente: ".$staff->getSurname().", ".$staff->getName();
        } else {
          $alert = "yellow";
          $msj = "Ocurrio un problema: ".$error;
        }
      }
    }
    $list = $staffDAO->SelectAll();
    require 'AdminViews/UpdateStaff.php';
  }

  public function DeleteStaff($name = null, $id_staff = null) {
    $staffDAO = new StaffDAO();
    /*
    Si recibo parametros, elimino el que tengo en la BD.
    */
    if (isset($name)) {
      $error = $staffDAO->DeleteById($id_staff);
      if (!isset($error)) {
        $alert = "green";
        $msj = "Staff eliminado: ".$name." (id ".$id_staff.")";
      } else {
        $alert = "yellow";
        $msj = "Ocurrio un problema: ".$error;
      }
    }
    $list = $staffDAO->SelectAll();
    require 'AdminViews/DeleteStaff.php';
  }
}
