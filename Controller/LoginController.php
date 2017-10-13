<?php namespace Controller;
use DAOS\AccountDAO as AccountDAO;
use Model\Account as Account;
class LoginController {

  public function Index() {
    // TODO Logica de sesion
    /*if (isset($_SESSION['account'])) {
      $dao = new AccountDAO();
      $account = $dao->SelectByUsername($_SESSION['account']->getUsername());
      if(strcmp ($account->getUserName() , $_SESSION['account']->getUsername() ) == 0 && (strcmp ($account->getPassword() , $_SESSION['account']->getPassword() )) == 0) {
        header('location: /ListaCervezas');
      }
    }*/
    require_once 'Views/login.php';
  }

  public function ProcesarLogin($username, $password) {
    $dao = new AccountDAO();
    $account = $dao->SelectByUsername($username);
    if (isset($account)) {
      if(strcmp ($account->getUserName() , $username ) == 0 && (strcmp ($account->getPassword() , $password )) == 0) {
        $_SESSION['account'] = $account;
        if (true) {
          header('location: /listaCervezas');
        } else {
          header('location: /gestion');
        }
      } else {
        echo "Credenciales Incorrectas";
      }
    }
     #TODO Credenciales Incorrectas
  }

  public function Logout() {
    unset($_SESSION['account']);
    header('location: /');
  }
} ?>
