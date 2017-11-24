<?php namespace Controller;

use DAOS\AccountDAO as AccountDAO;
use DAOS\ClientDAO as ClientDAO;
use Model\Client as Client;
use Model\Account as Account;

class RegisterController {

  private $accountDAO;
  private $clientDAO;

  public function __construct() {
    $this->accountDAO = AccountDAO::getInstance();
    $this->clientDAO = ClientDAO::getInstance();
  }

  public function Index($msj = null, $alert = null) {
  	require_once 'Views/Register.php';
  }

  public function InsertClient($username, $email, $password, $name, $surname, $dni, $address, $phone) {
    /*
    Creo la cuenta, creo el cliente y los inserto a la base de datos.
    */
    if (
      isset($username) && !strcmp($username, "") == 0 &&
      isset($email) && !strcmp($email, "") == 0 &&
      isset($password) && !strcmp($password, "") == 0 &&
      isset($name) && !strcmp($name, "") == 0 &&
      isset($surname) && !strcmp($surname, "") == 0 &&
      isset($dni) && !strcmp($dni, "") == 0 &&
      isset($address) && !strcmp($address, "") == 0 &&
      isset($phone) && !strcmp($phone, "") == 0 )
      {
      try {
        $account = new Account($username, $email, $password, "");
        $account = $this->accountDAO->Insert($account);
        if (isset($account)) {
          $client = new Client($name, $surname, $dni, $address, $phone, $account);
          $client = $this->clientDAO->Insert($client);
          if (isset($client)) {
            $_SESSION['account'] = $account;
            $_SESSION['client'] = $client;
            header('location: /'.BASE_URL.'Lobby');
          } else {
            throw new \Exception("Problema al insertar el Client", 1);
          }
        } else {
          throw new \Exception("Problema al insertar el Account", 1);
        }
      } catch (\Exception $e) {
        $msj = "Ocurrio un problema procesando su solicitud";
        $alert = "yellow";
        $this->Index($msj, $alert);
      }
    }
  }

  public function facebookRegister() {
    $nya = explode('-', $_SESSION['usuario']->getUsername());
    $name = $nya[0];
    $surname = $nya[1];
    require_once 'Views/Register.php';
  }
} ?>
