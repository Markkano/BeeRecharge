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
    try {
      $this->staffDAO = StaffDAO::getInstance();
      $this->roleDAO = RoleDAO::getInstance();
      $this->accountDAO = AccountDAO::getInstance();
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

  private function getRoleList() {
    try {
      return $this->roleDAO->SelectAll();
    } catch (\Exception $e) {
      $alert = "red";
      $msj = "Ocurrio un problema con la Base de Datos";
      $this->Alert($msj, $alert);
      die();
    }
  }

  private function getAccountList() {
    try {
      return $this->accountDAO->SelectAll();
    } catch (\Exception $e) {
      $alert = "red";
      $msj = "Ocurrio un problema con la Base de Datos";
      $this->Alert($msj, $alert);
      die();
    }
  }

  private function getStaffList() {
    try {
      return $this->staffDAO->SelectAll();
    } catch (\Exception $e) {
      $alert = "red";
      $msj = "Ocurrio un problema con la Base de Datos";
      $this->Alert($msj, $alert);
      die();
    }
  }

  /*
  Inserta un Account en la Base de Datos y la retorna,
  si algo sale mal retorna null
  */
  private function InsertAccount($account) {
    try {
      $account = $this->accountDAO->Insert($account);
      return $account;
    } catch (\Exception $e) {
      return null;
    }
  }

  /*
  Crea e inserta un Account en la Base de Datos y la retorna,
  si algo sale mal retorna null
  */
  private function CreateAccount($username, $email, $password) {
    if (isset($username) && isset($email) && isset($password)) {
      $ok = true;
      if ($this->ExisteEmail($email)) {
        $ok = false;
        $alert = "yellow";
        $msj = "La direccion de correo electronico se encuentra en uso";
        $this->Alert($msj, $alert);
      }
      if (!$ok && $this->ExisteAccount($username)) {
        $alert = "yellow";
        $msj = "Ya existe la cuenta, por favor elija otro nombre de usuario";
        $this->Alert($msj, $alert);
        $ok = false;
      }
      if ($ok) {
        $account = new Account($username, $email, $password);
        try {
          $account = $this->InsertAccount($account);
          if (!isset($account)) {
            throw new \Exception("", 1);
          } else {
            return $account;
          }
        } catch (\Exception $e) {
          $alert = "yellow";
          $msj = "Atencion: no se ha podido crear la Cuenta";
          $this->Alert($msj, $alert);
          // Vuelvo al formulario
          return null;
        }
      }
    } else {
      $alert = "yellow";
      $msj = "Compruebe los campos de la Cuenta";
      $this->Alert($msj, $alert);
    }
    return null;
  }

  /*
  Busca la Account y la retorna, si ya esta asignada a otro Staff retorna null
  */
  private function AssignAccount($id_account) {
    $account = $this->accountDAO->SelectByID($id_account);
    $aux = $this->staffDAO->SelectByAccount($account);
    if (isset($aux)) {
      $alert = "yellow";
      $msj = "Ya hay un Staff vinculado a la cuenta";
      $this->Alert($msj, $alert);
      // Vuelvo al formulario
      return null;
    }
    return $account;
  }

  private function ExisteAccount($username) {
    return $this->accountDAO->SelectByUsername($username) != null;
  }

  private function ExisteEmail($email) {
    return $this->accountDAO->SelectByEmail($email) != null;
  }

  public function Submit($name = null, $surname = null, $dni = null, $address = null, $phone = null, $salary = null, $id_role = null, $id_account = null, $username = null, $email = null) {
    $roles = $this->getRoleList();
    $accounts = $this->getAccountList();
    require_once 'AdminViews/SubmitStaff.php';
    die(); // Finaliza la interpretacion del Script
  }

  public function SubmitStaff($name = null, $surname = null, $dni = null, $address = null, $phone = null, $salary = null, $id_role = null, $id_account = null, $username = null, $email = null, $password = null, $password2 = null) {
    if (isset($name) && isset($surname) && isset($dni) && isset($address)  && isset($phone) && isset($salary) && isset($id_role) ) {
      try {
        if ($id_account == 0) { // Estoy creando un nuevo Account
          $account = $this->CreateAccount($username, $email, $password);
        } else { // id_account es distinto de 0, lo que quiere decir que asigno una Account existente
          $account = $this->AssignAccount($id_account);
        }
        if (!isset($account)) { // Vuelvo al formulario
          $alert = "yellow";
          $msj = "No se ha podido crear la Cuenta";
          $this->Alert($msj, $alert);
          $this->Submit($name, $surname, $dni, $address, $phone, $salary, $id_role, $id_account, $username, $email);
        }
        $role = $this->roleDAO->SelectById($id_role);
        # Si no se encontro otro staff, lo inserto en la BD.
        $staff = new Staff($name, $surname, $dni, $address, $phone, $salary, $account, $role);
        $staff = $this->staffDAO->Insert($staff);
        if (isset($staff)) {
          $alert = "green";
          $msj = "Staff añadido correctamente: ".$staff->getSurname().", ".$staff->getName();
          $this->Alert($msj, $alert);
        } else {
          throw new \Exception("", 1);
        }
      } catch (\PDOException $e) {
        $alert = "red";
        $msj = "Ocurrio un problema al agregar el Staff a la Base de Datos: error ".$e->errorInfo[1];
        $this->Alert($msj, $alert);
      } catch (\Exception $e) {
        $alert = "yellow";
        $msj = "Ocurrio un problema al agregar el Staff";
        $this->Alert($msj, $alert);
        // Vuelvo al formulario
        $this->Submit($name, $surname, $dni, $address, $phone, $salary, $id_role, $id_account, $username, $email, $password, $password2);
      }
    }
    $this->Submit();
  }

  public function Update($id_staff = null, $name = null, $surname = null, $dni = null, $address = null, $phone = null, $salary = null, $id_role = null, $id_account = null) {
    $roles = $this->getRoleList();
    $accounts = $this->getAccountList();
    $list = $this->getStaffList();
    require_once 'AdminViews/UpdateStaff.php';
  }

  public function UpdateStaff($id_staff = null, $name = null, $surname = null, $dni = null, $address = null, $phone = null, $salary = null, $id_role = null, $id_account = null, $username = null, $email = null, $password = null, $password2 = null) {
    if (isset($id_staff) && isset($name) && isset($surname) && isset($dni) && isset($address)  && isset($phone) && isset($salary) && isset($id_role) ) {
      try {
        $account = $this->accountDAO->SelectByID($id_account);
        $role = $this->roleDAO->SelectById($id_role);
        $staff = new Staff($name, $surname, $dni, $address, $phone, $salary, $account, $role);
        $staff->setId($id_staff);
        if ($id_account == 0) { // Estoy creando un nuevo Account
          $account = $this->CreateAccount($username, $email, $password);
        } else { // id_account es distinto de 0, lo que quiere decir que asigno una Account existente
          if ($id_account != $staff->getAccount()->getId()) {
            $account = $this->AssignAccount($id_account);
          }
        }
        if (!isset($account)) { // Vuelvo al formulario
          $alert = "yellow";
          $msj = "No se ha podido crear la Cuenta";
          $this->Alert($msj, $alert);
          $this->Update($id_staff, $name, $surname, $dni, $address, $phone, $salary, $id_role, $id_account);
        }
        $staff->setAccount($account);
        $staff = $this->staffDAO->Update($staff);
        if (isset($staff)) {
          $alert = "green";
          $msj = "Staff modificado correctamente: ".$staff->getSurname().", ".$staff->getName();
          $this->Alert($msj, $alert);
        } else {
          throw new \Exception("", 1);
        }
      } catch (\PDOException $e) {
        $alert = "red";
        $msj = "Ocurrio un problema al agregar el Staff a la Base de Datos: error ".$e->errorInfo[1];
        $this->Alert($msj, $alert);
      } catch (\Exception $e) {
        $alert = "yellow";
        $msj = "Ocurrio un problema al agregar el Staff";
        $this->Alert($msj, $alert);
        // Vuelvo al formulario
        $this->Update($id_staff, $name, $surname, $dni, $address, $phone, $salary, $id_role, $id_account);
      }
    }
    $this->Update($id_staff);
  }

  public function Delete($name = null, $id_staff = null) {
    $list = $this->getStaffList();
    require_once 'AdminViews/DeleteStaff.php';
  }

  public function DeleteStaff($name = null, $id_staff = null) {
    /*
    Si recibo parametros, elimino el que tengo en la BD.
    */
    if (isset($name) && isset($id_staff)) {
      try {
        if ($this->staffDAO->DeleteById($id_staff)) {
          $alert = "green";
          $msj = "Staff eliminado: ".$name." (id ".$id_staff.")";
          $this->Alert($msj, $alert);
        } else {
          throw new \Exception("", 1);
        }
      } catch (\Exception $e) {
        $alert = "yellow";
        $msj = "Ocurrio un problema al eliminar el Staff";
        $this->Alert($msj, $alert);
        // Vuelvo al formulario
        $this->Delete($name, $id_staff);
      }
    }
  }
}
