<?php namespace Controller;
use DAOS\AccountDAO as AccountDAO;
use Model\Account as Account;
use DAOS\StaffDAO as StaffDAO;
use Model\Staff as Staff;
use DAOS\ClientDAO as ClientDAO;
use Model\Client as Client;
use DAOS\RoleDAO as RoleDAO;
use Model\Role as Role;

class LoginController {

  private $accountDAO;
  private $staffDAO;
  private $clientDAO;

  public function __construct() {
    $this->accountDAO = AccountDAO::getInstance();
    $this->staffDAO = StaffDAO::getInstance();
    $this->clientDAO = ClientDAO::getInstance();
  }

  public function Index($msj = null) {
    require_once 'Views/login.php';
  }

  public function ProcesarLogin($username, $password) {
    $account = $this->accountDAO->SelectByUsername($username);
    if (isset($account)) {
      if(strcmp ($account->getUserName() , $username ) == 0 && (strcmp ($account->getPassword() , $password )) == 0) {
        $_SESSION['account'] = $account;
        $account = $_SESSION['account'];
        $staff = $this->staffDAO->SelectByAccount($account);
        $client = $this->clientDAO->SelectByAccount($account);
      if (isset($client) /* TODO && !isset($staff)*/) {
          $_SESSION['client'] = $client;
          header('location: /listaCervezas');
        } elseif (isset($staff) && !isset($client)) {
          $_SESSION['role'] = $staff->getRole();
          $_SESSION['staff'] = $staff;
          header('location: /gestion');
        }
      } else {
        $this->Index('Credenciales incorrectas');
      }
    }
    $this->Index('No se encontro el usuario');
  }

  public function Logout() {
    unset($_SESSION['account']);
    unset($_SESSION['role']);
    unset($_SESSION['staff']);
    header('location: /');
  }
} ?>
