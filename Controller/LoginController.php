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

  private function LoginClient($client) {
    $_SESSION['client'] = $client;
    header('location: /'.BASE_URL.'Lobby');
  }

  private function LoginStaff($staff) {
    $_SESSION['role'] = $staff->getRole();
    $_SESSION['staff'] = $staff;
    header('location: /'.BASE_URL.'Gestion');
  }

  public function ProcesarLogin($username, $password) {
    try {
      $account = $this->accountDAO->SelectByUsername($username);
    } catch (\Exception $e) {
        $this->Index("No se pudo conectar");
    }
    if (isset($account)) {
      if(strcmp ($account->getUserName() , $username ) == 0 && (strcmp ($account->getPassword() , $password )) == 0) {
        $_SESSION['account'] = $account;
        $account = $_SESSION['account'];
        try {
          $staff = $this->staffDAO->SelectByAccount($account);
          $client = $this->clientDAO->SelectByAccount($account);
        } catch (\Exception $e) {
          $this->Index("Ocurrio un problema al iniciar sesion");
        }
        if (!isset($staff) && isset($client)) {
          $this->LoginClient($client);
        } elseif (isset($staff) && !isset($client)) {
          $this->LoginStaff($staff);
        } elseif (isset($staff) && isset($client)) {
          $this->LoginStaff($staff);
        }
      }
    }
    $this->Index('Credenciales incorrectas');
  }

  public function facebookLogin($usuario) {
      if(isset($usuario)) {
        $objeto = json_decode($usuario);
        $nombre = $objeto->name;
        $apellido = $objeto->surname;
        $username = $nombre.'-'.$apellido;
        $email = $objeto->email;
        $password = $objeto->password;
        $image = $objeto->image;

        $usuario = new Account($username,$email,$password);
        $account= $this->accountDAO->SelectByUsername($username);
        if(isset($account)) {
            $_SESSION['account'] = $account;
            $account = $_SESSION['account'];
            try {
              $staff = $this->staffDAO->SelectByAccount($account);
              $client = $this->clientDAO->SelectByAccount($account);
            } catch (\Exception $e) {
              $this->Index("Ocurrio un problema al iniciar sesion");
          }
          if (!isset($staff) && isset($client)) {
            $this->LoginClient($client);
          } elseif (isset($staff) && !isset($client)) {
            $this->LoginStaff($staff);
          } elseif (isset($staff) && isset($client)) {
            $this->LoginStaff($staff);
          }
        } else {
        $_SESSION['usuario']=$usuario;
        $_SESSION['fotoPerfil']=$image;
        header('location: /'.BASE_URL.'Register/facebookRegister');
      }
    }
  }

  public function Logout() {
    unset($_SESSION['account']);
    unset($_SESSION['role']);
    unset($_SESSION['staff']);
    header('location: /'.BASE_URL);
  }
} ?>
