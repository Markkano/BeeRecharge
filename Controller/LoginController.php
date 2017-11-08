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
    require_once 'Views/Login.php';
  }

  public function ProcesarLogin($username, $password) {
    try {
      $account = $this->accountDAO->SelectByUsername($username);
    } catch (\Exception $e) {
        // FIXME: Exception
        $this->Index($e->getMessage());
    }
    if (isset($account)) {
      if(strcmp ($account->getUserName() , $username ) == 0 && (strcmp ($account->getPassword() , $password )) == 0) {
        $_SESSION['account'] = $account;
        $account = $_SESSION['account'];
        try {
          $staff = $this->staffDAO->SelectByAccount($account);
        } catch (\Exception $e) {
          // FIXME: Exception
          $this->Index($e->getMessage());
        }
        try {
          $client = $this->clientDAO->SelectByAccount($account);
        } catch (\Exception $e) {
          // FIXME: Exception
          $this->Index($e->getMessage());
        }
        if (isset($client) /* TODO && !isset($staff)*/) {
          $_SESSION['client'] = $client;
          header('location: /'.BASE_URL.'Lobby');
        } elseif (isset($staff) && !isset($client)) {
          $_SESSION['role'] = $staff->getRole();
          $_SESSION['staff'] = $staff;
          header('location: /'.BASE_URL.'Gestion');
        }
      }
    }
    $this->Index('Credenciales incorrectas');
  }

  public function Logout() {
    unset($_SESSION['account']);
    unset($_SESSION['role']);
    unset($_SESSION['staff']);
    header('location: /'.BASE_URL);
  }
} ?>
